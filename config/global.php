<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

return [
    
    //ERROR CODE
    'USERNAME_NOT_FOUND_ERROR' => 0,
    'PASSWORD_NOT_MATCHED_ERROR' => 1,
    'SESSION_END_ERROR' => 2,
    'HTTP_SUCCESS_CODE' => 200,
    'HTTP_INTERNAL_ERROR_CODE' => 500,

    //ROLE
    'ADMIN_ROLE_ID' => 0,
    'CASHIER_ROLE_ID' => 1,
    
    //OTHER
    'DEFAULT_IMAGE' => 'noimage.png',
    'APPLIED_CURRENCY'=>"IDR ",
    'USERS_COLUMNS_TITLE' => [
        'ID','ID KASIR','ROLE','NOMOR TELEPON','ALAMAT','PERALATAN'
    ],
    'USER_ADD_ACTION' => 0,
    'USER_EDIT_ACTION' => 1,
    'PROFILE_ACTION' => 2,
    'OWN_CHANGE_PASSWORD_ACTION' => 3,
    'USER_CHANGE_PASSWORD_ACTION' => 4,
    'PRODUCT_ADD_ACTION' => 5,
    'PRODUCT_EDIT_ACTION' => 6,
    'CATEGORY_ADD_ACTION' => 7,
    'CATEGORY_EDIT_ACTION' => 8
    
];

