<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;

class ProductController extends Controller
{
    
    /**
     * View;
     * @return type
     */
    public function view ($categoryId) {
        
        $orderBy = Input::get('orderBy','id');
        $sortBy = Input::get('sortBy','ASC');
        $searchParam = Input::get('search','');
        
        $data = Product::where('category_id', $categoryId);
        $category = Category::select('name')->where('id',$categoryId)->get();
        
        if (!empty($searchParam)) {
            $data = $data->where('name', 'like', '%'.$searchParam.'%');
        }
        
        $data = $data->orderBy($orderBy, $sortBy)->paginate(6); 
        
        if ((sizeof($category) > 0) && (sizeof($data) > 0)) {
            return view('pages/product',[
                'products'=>$data,
                'categoryName'=>$category[0]->name
            ]);
        }
        
        $responseJSON = $this->buildResponses(
                Config::get('global.HTTP_INTERNAL_ERROR_CODE'), 
                Lang::get('id.data_not_found_msg')
        );
        
        return view('pages/product',['alert'=>$responseJSON]);
        
    }
    
    /**
     * Delete product;
     * @param type $id
     * @return type
     */
    public function delete($id) {
        
        $product = Product::find($id);

        $responseJSON = $this->buildResponses(
                Config::get('global.HTTP_INTERNAL_ERROR_CODE'), 
                Lang::get('id.internal_error_msg')
        );

        if (null != $product) {

            $product->delete();
            $responseJSON = $this->buildResponses(
                    Config::get('global.HTTP_SUCCESS_CODE'), 
                    Lang::get('id.success_deleted_data')
            );

        }
        
        return redirect()->route('dashboard.product.index')->with('alert',$responseJSON->getData()); 
    }
    
}
