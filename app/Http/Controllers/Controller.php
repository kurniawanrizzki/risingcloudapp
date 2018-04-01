<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
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
