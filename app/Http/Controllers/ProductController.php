<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Session;

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
        $categories = Category::get();
        $category = Category::select('name')->where('id',$categoryId)->get();
        
        if (!empty($searchParam)) {
            $data = $data->where('name', 'like', '%'.$searchParam.'%');
        }
        
        $data = $data->orderBy($orderBy, $sortBy)->paginate(6); 
        
        if ((sizeof($category) > 0) && (sizeof($data) > 0)) {
            return view('pages/product',[
                'products'=>$data,
                'categories'=>$categories,
                'categoryName'=>$category[0]->name
            ]);
        }
        
        $responseJSON = $this->buildResponses(
                Config::get('global.HTTP_INTERNAL_ERROR_CODE'), 
                Lang::get('id.data_not_found_msg')
        );
        
        return view('pages/product',['alert'=>$responseJSON]);
        
    }
    
    public function create (ProductRequest $request) {
        $parameter = $this->buildRequestParameters($request);
        Product::insert($parameter);
        
        return $this->buildResponses(
                Config::get('global.HTTP_SUCCESS_CODE'), 
                Lang::get('id.success_inserted_msg')
        );
    }
    
    public function update (ProductRequest $request) {
        $parameter = $this->buildRequestParameters($request);
        Product::where('id',$parameter['id'])->update($parameter);
        
        return $this->buildResponses(
                Config::get('global.HTTP_SUCCESS_CODE'), 
                Lang::get('id.success_updated_msg')
        );
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
            $categoryId = $product->category_id;
            $product->delete();
            $responseJSON = $this->buildResponses(
                    Config::get('global.HTTP_SUCCESS_CODE'), 
                    Lang::get('id.success_deleted_data')
            );

        }
        
        return redirect()->route('dashboard.product.view',$categoryId)->with('alert',$responseJSON->getData()); 
    }
    
    protected function buildRequestParameters (ProductRequest $request) {

        $img = Config::get('global.DEFAULT_IMAGE');
                
        if (isset($request->product_id)) {
            $parameter['id'] = $request->product_id;
            $img = Product::select('img')->where('id',$request->product_id)->get()[0]->img;
        }
        
        $parameter = [
            'name' => $request->product_name,
            'category_id' => $request->category,
            'description' => $request->deskripsi,
            'purchase' => $request->purchase,
            'sell'=> $request->sell,
            'stock'=> $request->stock,
            'created_by' => Session::get('id')
        ];
        
        
        if( $request->hasFile('product_image')) {
        
            $image = $request->file('product_image');
            $path = public_path(). '/img/';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);
            $img = $filename;
        }
        
        $parameter['img'] = $img;
        
        if (isset($request->product_id)) {
            $parameter['id'] = $request->product_id;
        }
        
        return $parameter;
        
    }
    
}
