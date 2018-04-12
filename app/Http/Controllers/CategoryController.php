<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    
    /**
     * index
     */
    public function index () {
        $categories = Category::paginate(6);
        return view('pages/categories')->with('categories', $categories);
    }
    
    public function create (CategoryRequest $request) {
        $parameter = $this->buildRequestParameters($request);
        Category::insert($parameter);
        
        return $this->buildResponses(
                Config::get('global.HTTP_SUCCESS_CODE'), 
                Lang::get('id.success_inserted_msg')
        );
    }
    
    public function update (CategoryRequest $request) {
        $parameter = $this->buildRequestParameters($request);
        Category::where('id',$parameter['id'])->update($parameter);
        
        return $this->buildResponses(
                Config::get('global.HTTP_SUCCESS_CODE'), 
                Lang::get('id.success_updated_msg')
        );
    }
    
    /**
     * delete category
     * @param type $id
     */
    public function delete ($id) {
        $category = Category::find($id);

        $responseJSON = $this->buildResponses(
                Config::get('global.HTTP_INTERNAL_ERROR_CODE'), 
                Lang::get('id.internal_error_msg')
        );

        if (null != $category) {

            try {
                $category->delete();
                $responseJSON = $this->buildResponses(
                        Config::get('global.HTTP_SUCCESS_CODE'), 
                        Lang::get('id.success_deleted_data')
                );
            } catch (\Illuminate\Database\QueryException $ex) {
                $responseJSON = $this->buildResponses(
                        Config::get('global.HTTP_INTERNAL_ERROR_CODE'), 
                        Lang::get('id.move_product_msg',['name'=>$category->name])
                );
            }

        }
        
        return redirect()->route('dashboard.index')->with('alert',$responseJSON->getData()); 
    }
    
    protected function buildRequestParameters (CategoryRequest $request) {

        $img = Config::get('global.DEFAULT_IMAGE');
        
        $parameter = [
            'name' => $request->category_name,
            'description' => $request->category_description,
            'created_by' => Session::get('id')
        ];
        
        if (isset($request->category_id)) {
            $parameter['id'] = $request->category_id;
            $img = Category::select('img')->where('id',$request->category_id)->get()[0]->img;
        }
        
        if( $request->hasFile('category_img')) {
        
            $image = $request->file('category_img');
            $path = public_path(). '/img/';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);
            
            $img = $filename;
            
        }
        
        $parameter['img'] = $img;
        
        return $parameter;
        
    }
        
}
