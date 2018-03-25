<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index () {
        $data = User::get();
        return view('pages/user',['users'=>$data]);
    }
    
    /**
     * Create User data;
     * @param UserRequest $request
     * @return type
     */
    public function create (UserRequest $request) {
        
        $parameter = $this->buildRequestParameters($request);
        User::insert($parameter);
        
        return $this->buildResponses(
                Config::get('global.HTTP_SUCCESS_CODE'), 
                Lang::get('id.success_inserted_msg')
        );
        
    }
    
    /**
     * Update user;
     * @param UserRequest $request
     * @return type
     */
    public function update (UserRequest $request) {
                
        $parameter = $this->buildRequestParameters($request);
        User::where('id',$parameter['id'])->update($parameter);
        
        return $this->buildResponses(
                Config::get('global.HTTP_SUCCESS_CODE'), 
                Lang::get('id.success_updated_msg')
        );
        
    }
    
    /**
     * View user data based on id;
     * @param type $id
     * @return type
     */
    public function view () {

        $user = User::find(Session::get('id'));
        
        if (null != $user) {
            
            return $this->buildResponses(
                    Config::get('global.HTTP_SUCCESS_CODE'), 
                    Lang::get('id.success_fetch_data'), 
                    $user
            );
            
        }
        
        return $this->buildResponses(
                Config::get('global.HTTP_INTERNAL_ERROR_CODE'), 
                Lang::get('id.internal_error_msg')
        );
        
    }
    
    /**
     * Delete data;
     * @param type $id
     * @return type
     */
    public function delete ($id) {
        
        $responseJSON = $this->buildResponses(
                Config::get('global.HTTP_INTERNAL_ERROR_CODE'), 
                Lang::get('id.danger_own_user_deleted_msg')
        );
        
        if (!empty(Session::get('id')) && ($id != Session::get('id'))) {
            
            $user = User::find($id);
            
            $responseJSON = $this->buildResponses(
                    Config::get('global.HTTP_INTERNAL_ERROR_CODE'), 
                    Lang::get('id.internal_error_msg')
            );

            if (null != $user) {

                $user->delete();
                $responseJSON = $this->buildResponses(
                        Config::get('global.HTTP_SUCCESS_CODE'), 
                        Lang::get('id.success_deleted_data')
                );

            }
        
        }
        
        return redirect()->route('dashboard.user')->with('alert',$responseJSON->getData()); 
        
    }
    
    /**
     * Build request parameters;
     * @param UserRequest $request
     * @return type
     */
    protected function buildRequestParameters (UserRequest $request) {

        $parameter = [];
        
        if (isset($request->username)) {
            $parameter = [
                'username' => $request->username,
                'address' => $request->address,
                'phone'=> $request->phone,
                'role' => $request->role,
                'created_by' => \Session::get('id')
            ];
        }
        
        if (isset($request->password)) {
            $parameter['password'] = bcrypt($request->password);
        }
        
        if (isset($request->user_id)) {
            $parameter['id'] = $request->user_id;
        }
        
        return $parameter;
        
    }
    
    /**
     * Build JSON response;
     * @param type $httpCode
     * @param type $message
     * @param type $data
     * @return type
     */
    protected function buildResponses ($httpCode, $message, $data = []) {
        
        $responsesJSON = [
            'responseJSON' => [
                "status"=> $httpCode,
                "message"=> $message
            ]
        ];
        
        if (sizeof($data) > 0) {
            $responsesJSON['responseJSON']['data'] = $data; 
        }
        
        return response()->json($responsesJSON);
        
    }
    
}
