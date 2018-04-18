<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Transaction;
use Barryvdh\DomPDF\Facade as PDF;
use App\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

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
             
            $this->printout($struk);
           
            return redirect()->route('dashboard.transaction.index');
        }
        
        return abort(404);
    }
    
    public function download () {
        
        $response =  $this->buildResponses(
                Config::get('global.HTTP_INTERNAL_ERROR_CODE'), 
                Lang::get('id.internal_error_msg')
        );
        
        $parameters = json_decode(Input::get('parameters',''));
        
        if (sizeof($parameters) > 0) {
            if (isset($parameters->_token) && !empty($parameters->_token)) {
                if (!empty($parameters->start) || !empty($parameters->end)){
                    
                    $report = $this->buildTransactionsReport($parameters->start, $parameters->end);

                    if (sizeof($report) > 0) {
                        $pdf = PDF::loadView('templates.components.file', ['report'=>$report]);
                        $pdf->setPaper('a4', 'landscape')->setWarnings(false);
                        return $pdf->download();
                    }
                    
                }
            }
        }
        
        return $response;
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
    
    protected function buildTransactionsReport ($start = '', $end = '') {
        
        $total = 0;
        $report = [];
        
        $transactions = Transaction::join('users','transactions.created_by','=','users.id');
        
        if (!empty($start)) {
            $transactions->whereRaw('DATE(transactions.created_at) >= ?',$start);
        } 
        
        if (!empty($end)) {
            $transactions->whereRaw('DATE(transactions.created_at) <= ?',$end);            
        }
        
        $transactions = $transactions
                ->select('transactions.id','transactions.amount','users.username as reported', 'transactions.created_at')
                ->get();
        
        foreach ($transactions as $key => $value) {
            
            $total += $value->amount;
            
            $transactionDetails = TransactionDetail::join('products','products.id','=','transaction_details.product_id')->where('transaction_details.tran_id','=',$value->id)
                    ->select('products.id','products.name','transaction_details.counted')->get();
            
            if (sizeof($transactionDetails) > 0) {
                
                $report['item'][$key] = $value->getOriginal();
                $report['item'][$key]['details'] = [];

                foreach ($transactionDetails as $kp => $vp) {
                    $report['item'][$key]['details'][$kp] = $vp->getOriginal();
                }
                
            }
                        
        }
        
        if ($total > 0) {
            $report['total_transactions'] = $total;
        }

        return $report;
        
    }
    
    protected function printout ($struk) {
        
        $connector = new FilePrintConnector(env("PRINTER_CONNECTION"));

        $logo = EscposImage::load(asset('img/roundlogo.jpg'), false);
        $printer = new Printer($connector);

        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> graphics($logo);

        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> text(Config::get('global.STORE_NAME').'\n');
        $printer -> selectPrintMode();
        $printer -> text(Config::get('global.STORE_ADDRESS').'\n');     
        $printer -> feed();

        $printer -> setEmphasis(true);
        $printer -> text("STRUK PEMBELIAN\n");
        $printer -> setEmphasis(false);

        $printer -> setJustification(Printer::JUSTIFY_LEFT);
        $printer -> setEmphasis(true);
        $printer -> text(new Item('Nama','Qty','Harga','Sub Total'));
        $printer -> setEmphasis(false);


        foreach ($struk as $key => $item) {
            $printer->text(new Item(
                    $item->product_name,
                    $item->counted,
                    Config::get('global.APPLIED_CURRENCY').number_format($item->sell,2)
                    )
            );
        }

        $printer -> feed();
        $printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
        $printer -> text(new Item('Total','',Config::get('global.APPLIED_CURRENCY').number_format($struk[0]->amount,2),true));
        $printer -> text(new Item('Bayar','',Config::get('global.APPLIED_CURRENCY').number_format($struk[0]->cash,2),true));
        $printer -> text(new Item('Kembali','',Config::get('global.APPLIED_CURRENCY').number_format($struk[0]->remained,2),true));
        $printer -> selectPrintMode();

        /* Footer */
        $printer -> feed(2);
        $printer -> setJustification(Printer::JUSTIFY_CENTER);
        $printer -> text(Lang::get('id.thank_you_text')."\n");
        $printer -> feed(2);
        $printer -> text($struk[0]->created_at . "\n");

        $printer -> cut();
        $printer -> pulse();

        $printer -> close();
        
    }
    
}

class Item {
    private $name;
    private $qty;
    private $price;
    private $isNotKindOfItem;
    
    public function __construct(
            $name = '',
            $qty = '',
            $price = '',
            $isNotKindOfItem = false
            ) {
        
        $this->name = $name;
        $this->qty = $qty;
        $this->price = $price;
        $this->isNotKindOfItem = $isNotKindOfItem;
        
    }
    
    public function __toString() {
        $widthCols = [32,8,20,20];
        
        if ($this->isNotKindOfItem) {
            $widthCols[0] = ($widthCols[0]+$widthCols[1])/2 - $widthCols[1];
            $widthCols[2] = 40;
        }
        
        $firstCol = str_pad($this->name, $widthCols[0]);        
        $secondCol = str_pad($this->qty, $widthCols[1],' ',STR_PAD_BOTH);
        $thirdCol = str_pad($this->price, $widthCols[2],' ',STR_PAD_LEFT);
        
        if ($qty != '') {
            $fourthCol = str_pad(($this->qty*$this->price),$widthCols[3],' ',STR_PAD_LEFT);
        }

        
        return "$firstCol$secondCol$thirdCol$fourthCol\n";
        
    }
    
}
