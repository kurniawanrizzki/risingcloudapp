<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function index () {
        $products = $this->buildItemsBasedOnCategory();
        return view ('pages/transaction',['products'=>$products]);
    }
    
    /**
     * Insert request;
     * @param Request $request
     * @return type
     */
    public function create (Request $request) {
        
        $transactionId = 
            Transaction::create([
                'amount' => $request->amount,
                'cash' => $request->cash,
                'created_by' => Session::get('id')
            ])->id;
        
        $response = $this->buildResponses(
                Config::get('global.HTTP_SUCCESS_CODE'), 
                Lang::get('id.success_inserted_msg'),
                $transactionId
        );
        
        foreach ($request->products as $key => $value) {
            if (null != $value) {
                $isAllowToInserted = $this->updateStock($key, $value['counted']);
                
                if ($isAllowToInserted) {
                    TransactionDetail::insert([
                        'tran_id' => $transactionId,
                        'product_id' => $key,
                        'counted' => $value['counted']
                    ]);
                    
                    continue;
                }
                
                $response =  $this->buildResponses(
                        Config::get('global.HTTP_INTERNAL_ERROR_CODE'), 
                        Lang::get('id.internal_error_msg')
                );
                
                break;
                                
            }
        }
        
        return $response;
        
    }
    
    public function view () {
        
        $report = $this->buildTransactionsReport();
        
        return view('pages/report',['report'=>$report]);
    }
    
    public function printing ($id) {
        $struk = Transaction::join('transaction_details','transactions.id','=','transaction_details.tran_id')
                ->join('products','transaction_details.product_id','=','products.id')->where('transactions.id','=',$id)
                ->join('users','transactions.created_by','=','users.id')
                ->select('transactions.id','transactions.amount','transactions.cash', \Illuminate\Support\Facades\DB::raw('transactions.cash - transactions.amount as remained'),'products.name as product_name','products.sell','transaction_details.counted', \Illuminate\Support\Facades\DB::raw('transaction_details.counted * products.sell as total'),'users.username as cashier','transactions.created_at')
                ->get();
        
        if (sizeof($struk) > 0) {
            return view('pages/struk',['struk'=>$struk]);
        }
        
        return abort(404);
    }
    
    protected function updateStock ($productId, $counted) {
        $product = Product::find($productId);
        $result = $product->stock - $counted;
        
        if ($result > -1) {
            $product->stock = $result;
            $product->update();
            return true;
        }
        
        return false;
    }
    
    /**
     * Build items based on category;
     * @return array();
     */
    protected function buildItemsBasedOnCategory () {
        
        $products = [];
        $categories = Category::select('id','name')->get();
        
        foreach ($categories as $key => $value) {
            $products[$key] = [];
            $products[$key]['category_id'] = $value->id;
            $products[$key]['category_name'] = $value->name;
            $products[$key]['products'] = [];
            
            $productByCategory = Product::where('category_id','=',$value->id)->get();
            
            foreach ($productByCategory as $kp => $vp) {
                $products[$key]['products'][$kp] = $vp;
            }
            
        }
        
        return $products;
        
    }
    
    protected function buildTransactionsReport () {
        
        $report = [];
        
        $transactions = Transaction::join('users','transactions.created_by','=','users.id')
                ->select('transactions.id','transactions.amount','users.username as reported', 'transactions.created_at')->get();
        
        foreach ($transactions as $key => $value) {
            
            $transactionDetails = TransactionDetail::join('products','products.id','=','transaction_details.product_id')->where('transaction_details.tran_id','=',$value->id)
                    ->select('products.id','products.name','transaction_details.counted')->get();
            
            if (sizeof($transactionDetails) > 0) {
                
                $report[$key] = $value->getOriginal();
                $report[$key]['details'] = [];

                foreach ($transactionDetails as $kp => $vp) {
                    $report[$key]['details'][$kp] = $vp->getOriginal();
                }
                
            }
                        
        }
        
        return $report;
        
    }
    
}
