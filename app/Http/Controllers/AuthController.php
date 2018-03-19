<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    /**
     * Initiate welcome page;
     */
    public function index () {

        if (!Session::get('login')) {
            return view('pages.auth'); 
        }
        
        return redirect()->route('dashboard.index');
    
    }
    
    /**
     * Show login page;
     * @return type page;
     */
    public function login () {
        return view ('login');
    }
    
    /**
     * Authenticate method that is going to validate your credential;
     * @param UserRequest $request user model;
     * @return type page;
     */
    public function auth (UserRequest $request) {
                
        $username = $request->username;
        $password = $request->password;
        
        $data = User::where('username', $username)->first ();
        $isValidatedData = count($data) > 0;
        if (!$isValidatedData) {
            return redirect ()->route('auth.index')->with('alert', Config::get('global.USERNAME_NOT_FOUND_ERROR'));
        }
        
        $isValidatedCredential = Hash::check($password, $data->password);
        
        if (!$isValidatedCredential) {
            return redirect()->route('auth.index')->with('alert', Config::get('global.PASSWORD_NOT_MATCHED_ERROR'));
        }
        
        Session::put('id', $data->id);
        Session::put('login', TRUE);
        Session::put('role', $data->role);
        
        User::where('id', $data->id)->update([
            'remember_token' => $request->_token
        ]);
        
        return redirect()->route('dashboard.index');
        
    }
    
    /**
     * Log out from the application;
     * @return type page;
     */
    public function logout () {
        
        if (Session::has('id')) {
            
            User::where('id', Session::get('id'))->update([
                'remember_token'=> NULL
            ]);
            
        }
        
        Session::flush();
        return redirect()->route('auth.index')->with('alert', Config::get('global.SESSION_END_ERROR'));
    
       
    }
    
    
}
