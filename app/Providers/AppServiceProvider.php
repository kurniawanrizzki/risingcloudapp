<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class AppServiceProvider extends ServiceProvider
{
    
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive ("modal", function ($expression) {

            list($idForm, $idAlert, $titleForm, $routeForm) = explode(',',str_replace(['(',')',' '], '', $expression));
            return $this->build($idForm, $idAlert, $titleForm, $routeForm);

            
        });
        
        Blade::directive ("alert", function ($expression){
            
            list($idAlert, $isSingleButton, $routeButtonClass, $message) = explode(',',str_replace(['(',')',' '], '', $expression));
            return $this->alert($idAlert, $isSingleButton, $routeButtonClass, $message);
            
        });
        
        Validator::extend('validateOldPassword', function ($attribute, $value, $parameters, $validator) {
        
            $data = User::find($parameters[0]);
            if (Hash::check($value, $data->password)) {
                return true;
            }
            
            return false;
        }, Lang::get('id.old_password_not_validated_msg'));
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    
    /**
     * Build Modal Blade 
     * @param type $idForm 
     * @param type $idAlert
     * @param type $titleForm
     * @param type $routeForm
     * @return type
     */
    protected function build ($idForm, $idAlert, $titleForm, $routeForm) {  
        
        $content = $this->getContent(
                $this->getAsString($idForm),
                Config::get($this->getAsString($routeForm))
        );
               
        return 
            "<div class='modal fade' id='".$this->getAsString($idForm)."' tabindex='-1' role='dialog' aria-labelledby='".$this->getAsString($idForm)."'-label' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
           
                        <div class='modal-header'>
                            ".$this->isNeedClosedButton($this->getAsString($idAlert), true)."
                            <h4 class='modal-title' id='".$idForm."-label' >".Lang::get($this->getAsString($titleForm))."</h4>
                        </div>

                        <div class='row'>
                            <div class='col-lg-12'>
                                <div class='panel'>
                                    ".$content."
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='modal fade' id='".$this->getAsString($idAlert)."' tabindex='-1' role='dialog' aria-labelledby='".$this->getAsString($idAlert)."'-label' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            ".$this->isNeedClosedButton($this->getAsString($idAlert), false)."
                            <h4 class='modal-title' id='".$this->getAsString($idAlert)."-label' >".Lang::get('id.confirmation_text')."</h4>
                        </div>

                        <div class='row'>
                            <div class='col-lg-12'>
                                <div class='panel'>
                                    <div class='panel-body'>
                                    ".Lang::get('id.back_msg')."
                                    </div>
                                    <div class='modal-footer'>
                                        <button type='button' class='btn btn-default' data-dismiss='modal'>{{ trans('id.back_text') }}</button>
                                        <button type='button' class='btn btn-danger' id='".$this->getAsString($idForm)."-canceled' data-dismiss='modal'>{{ trans('id.cancel_text') }}</button>       
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";      
    }
    
    public function alert ($idAlert, $isSingleButton, $routeButtonClass, $message) {
       return "
            <div class='modal fade' id='".$this->getAsString($idAlert)."' tabindex='-1' role='dialog' aria-labelledby='".$this->getAsString($idAlert)."'-label' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h4 class='modal-title' id='".$this->getAsString($idAlert)."-label' >".Lang::get('id.confirmation_text')."</h4>
                        </div>

                        <div class='row'>
                            <div class='col-lg-12'>
                                <div class='panel'>
                                    <div class='panel-body'>
                                    ".Lang::get($this->getAsString($message))."
                                    </div>
                                    <div class='modal-footer'>
                                    ".$this->isSingleButton($isSingleButton, $routeButtonClass)."
                                    </div>                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>"; 
    }
    
    /**
     * Get content;
     * @param type $routeFormId
     * @param type $routeForm
     * @return type
     */
    protected function getContent ($routeFormId, $routeForm) {
        if (($routeForm == Config::get('global.USER_ADD_ACTION')) || ($routeForm == Config::get('global.USER_EDIT_ACTION')) || ($routeForm == Config::get('global.USER_CHANGE_PASSWORD_ACTION')) || ($routeForm == Config::get('global.OWN_CHANGE_PASSWORD_ACTION'))) {
            if (($routeForm == Config::get('global.USER_CHANGE_PASSWORD_ACTION')) || ($routeForm == Config::get('global.OWN_CHANGE_PASSWORD_ACTION'))) {
                return $this->buildChangePasswordForm($routeFormId, $routeForm);
            }
            
            return $this->buildUserContentForm($routeFormId, $routeForm);
        } else if ($routeForm == Config::get('global.PROFILE_ACTION')) {
            return $this->buildProfileForm();
        } else if ($routeForm == Config::get('global.PRODUCT_ADD_ACTION') || $routeForm == Config::get('global.PRODUCT_EDIT_ACTION')) {
            return $this->buildProductContentForm($routeFormId, $routeForm);
        }

        return $this->buildCategoryContentForm($routeFormId, $routeForm);
    }
    
    /**
     * Build Profile Action;
     */
    protected function buildProfileForm () {
        return 
            "
                <div class='panel-body'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div id='content-profile'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='panel-footer'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='pull right'>
                                <button type='button' class='btn btn-success btn-circle' data-toggle='modal' data-target='#user-own-password-form' data-backdrop='static' data-keyboard='false' id='profile_password_btn'><i class='fa fa-key fa-fw'></i></button>
                                <button type='button' class='btn btn-primary btn-circle' data-toggle='modal' data-target='#user-edit-form' data-backdrop='static' data-keyboard='false' id='profile_edit_btn'><i class='fa fa-pencil fa-fw'></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            ";
    }
    
    /**
     * Build change password form;
     * @param type $routeFormId
     * @param type $routeForm
     * @return type
     */
    protected function buildChangePasswordForm ($routeFormId, $routeForm) {
        return "
            <div class='panel-body'>
                {!!
                    Form::open([
                        'id'    => '".$routeFormId."-id',
                        'method'=> 'post'
                    ])
                !!}
                
                    {{ csrf_field() }}
                
                    {!! Form::hidden('user_id','',['class'=>'form-control']) !!}

                    <?php
                    if ($routeForm !== \Config::get('global.USER_CHANGE_PASSWORD_ACTION')) {
                    ?>
                        <div class='form-group old_password-group'>
                            {!! Form::label('', '', ['class'=>'control-label old_password_error_label', 'for'=>'inputError', 'hidden' => '']) !!}
                            {!! Form::password('old_password',['class'=>'form-control old_password_field','placeholder'=> trans('id.old_password_text')]) !!}
                        </div>

                    <?php
                    }
                    ?>
                    <div class='form-group password-group'>
                        {!! Form::label('', '', ['class'=>'control-label password_error_label', 'for'=>'inputError', 'hidden' => '']) !!}
                        {!! Form::password('password',['class'=>'form-control password_error_field','placeholder'=> trans('id.password_text')]) !!}
                    </div>

                    <div class='form-group confirm_password-group'>
                        {!! Form::label('', '', ['class'=>'control-label confirm_password_error_label', 'for'=>'inputError', 'hidden' => '']) !!}
                        {!! Form::password('confirm_password',['class'=>'form-control confirm_password_field','placeholder'=> trans('id.confirm_password_text')]) !!}
                    </div>
                
                    {!! Form::submit(
                        trans('id.form_user_edit_text'), 
                        ['class'=>'btn btn-lg btn-success btn-block']) 
                    !!}
            
                {!! Form::close() !!}
            </div>";
    }
    
    /**
     * Build user content form;
     * @param type $routeFormId
     * @param type $routeForm
     * @return type
     */
    protected function buildUserContentForm ($routeFormId, $routeForm) {
                                                                                
        return 
        "<div class='panel-body'>
            
            {!!
                Form::open([
                    'id'    => '".$routeFormId."-id',
                    'method'=> 'post'
                ])
            !!}
            
            {{ csrf_field() }}
            
            <?php
            if ($routeForm !== \Config::get('global.USER_ADD_ACTION')) {
                
            ?>
            
                {!! Form::hidden('user_id','',['class'=>'form-control']) !!}

            <?php
            }   
            ?>
            
            <div class='form-group username-group'>
                {!! Form::label('', '', ['class'=>'control-label username_error_label', 'for'=>'inputError','hidden' => '']) !!}
                {!! Form::text('username','',['class'=>'form-control username_error_field','placeholder'=> trans('id.username_text')]) !!}
            </div>
            
            <div class='form-group phone-group'>
                {!! Form::label('', '', ['class'=>'control-label phone_error_label', 'for'=>'inputError', 'hidden' => '']) !!}
                {!! Form::text('phone','',['class'=>'form-control phone_error_field','placeholder'=> trans('id.phone_text')]) !!}
            </div>
            
            <div class='form-group address-group'>
                {!! Form::label('', '', ['class'=>'control-label address_error_label', 'for'=>'inputError', 'hidden' => '']) !!}
                {!! Form::textarea('address','',['class'=>'form-control address_error_field','rows'=>'3','placeholder'=> trans('id.address_text')]) !!}
            </div>
            
            <?php
            if (\Session::get('role') === \Config::get('global.ADMIN_ROLE_ID')) {
            ?>
            
                <div class='form-group role-group'>
                    {!! Form::select('role',trans('id.role_options_text'),\Config::get('global.CASHIER_ROLE_ID'),['class'=>'form-control']) !!}
                </div>
            
            <?php
            }
            ?>
            
            <?php
            if ($routeForm === \Config::get('global.USER_ADD_ACTION')) {
                
            ?>
            
                <div class='form-group password-group'>
                    {!! Form::label('', '', ['class'=>'control-label password_error_label', 'for'=>'inputError', 'hidden' => '']) !!}
                    {!! Form::password('password',['class'=>'form-control address_error_field','placeholder'=> trans('id.password_text')]) !!}
                </div>

                <div class='form-group confirm_password-group'>
                    {!! Form::label('', '', ['class'=>'control-label confirm_password_error_label', 'for'=>'inputError', 'hidden' => '']) !!}
                    {!! Form::password('confirm_password',['class'=>'form-control confirm_password_field','placeholder'=> trans('id.confirm_password_text')]) !!}
                </div>
            
            <?php
            }   
            ?>

            {!! Form::submit(
            $routeForm == \Config::get('global.USER_ADD_ACTION')?trans('id.form_create_text'):trans('id.form_edit_text'), 
            ['class'=>'btn btn-lg btn-success btn-block']) !!}
            
            {!! Form::close() !!}
        
        </div>";
        
    }
    
    protected function buildProductContentForm ($routeFormId, $routeForm) {
        return 
        "<div class='panel-body'>
            
            {!!
                Form::open([
                    'id'    => '".$routeFormId."-id',
                    'method'=> 'post'
                ])
            !!}
            
                {{ csrf_field() }}
                
                <?php
                if ($routeForm !== \Config::get('global.PRODUCT_ADD_ACTION')) {

                ?>

                    {!! Form::hidden('user_id','',['class'=>'form-control']) !!}

                <?php
                }   
                ?>
                <div class='form-group name-group'>
                    {!! Form::label('', '', ['class'=>'control-label name_error_label', 'for'=>'inputError','hidden' => '']) !!}
                    {!! Form::text('name','',['class'=>'form-control name_error_field','placeholder'=> trans('id.product_name_text')]) !!}
                </div>
                
                <div class='form-group category-group'>
                    {!! Form::label('', '', ['class'=>'control-label category_error_label', 'for'=>'inputError','hidden' => '']) !!}
                    {!! Form::select('category',[],'0',['class'=>'form-control category_error_field']) !!}
                </div>

                <div class='form-group deskripsi-group'>
                    {!! Form::label('', '', ['class'=>'control-label deskripsi_error_label', 'for'=>'inputError', 'hidden' => '']) !!}
                    {!! Form::textarea('deskripsi','',['class'=>'form-control deskripsi_error_field','rows'=>'3','placeholder'=> trans('id.product_description_text')]) !!}
                </div>

                <div class='form-group purchase-group'>
                    {!! Form::label('', '', ['class'=>'control-label purchase_error_label', 'for'=>'inputError','hidden' => '']) !!}
                    {!! Form::text('purchase','',['class'=>'form-control purchase_error_field','placeholder'=> trans('id.purchase_text')]) !!}
                </div>

                <div class='form-group sell-group'>
                    {!! Form::label('', '', ['class'=>'control-label sell_error_label', 'for'=>'inputError','hidden' => '']) !!}
                    {!! Form::text('sell','',['class'=>'form-control sell_error_field','placeholder'=> trans('id.sell_text')]) !!}
                </div>
                
                <div class='form-group'>
                    {!! Form::label('product_image', \Lang::get('id.upload_image_text'), ['class'=>'control-label']) !!}
                    <div class='form-group product_image-group'>
                        {!! Form::label('', '', ['class'=>'control-label product_image_error_label', 'for'=>'inputError', 'hidden' => '']) !!}
                        {!! Form::file('product_image','',['class'=>'form-control product_image_error_field']) !!}
                    </div>
                </div>

                <div class='form-group product_image-group'>
                    {!! Form::label('', '', ['class'=>'control-label product_image_error_label', 'for'=>'inputError', 'hidden' => '']) !!}
                    {!! Form::file('product_image','',['class'=>'form-control product_image_error_field']) !!}
                </div>

            {!! Form::submit(
            $routeForm == \Config::get('global.PRODUCT_ADD_ACTION')?trans('id.form_create_text'):trans('id.form_edit_text'), 
            ['class'=>'btn btn-lg btn-success btn-block']) !!}
            
            {!! Form::close() !!}
        
        </div>";
    }
    
    protected function buildCategoryContentForm ($routeFormId, $routeForm) {
        return 
        "<div class='panel-body'>
            
            {!!
                Form::open([
                    'id'    => '".$routeFormId."-id',
                    'method'=> 'post',
                    'files' => true
                ])
            !!}
            
                {{ csrf_field() }}
                
                <?php
                if ($routeForm !== \Config::get('global.CATEGORY_ADD_ACTION')) {

                ?>

                    {!! Form::hidden('user_id','',['class'=>'form-control']) !!}

                <?php
                }   
                ?>
                <div class='form-group name-group'>
                    {!! Form::label('', '', ['class'=>'control-label name_error_label', 'for'=>'inputError','hidden' => '']) !!}
                    {!! Form::text('name','',['class'=>'form-control name_error_field','placeholder'=> trans('id.category_name_text')]) !!}
                </div>

                <div class='form-group category_description-group'>
                    {!! Form::label('', '', ['class'=>'control-label category_description_error_label', 'for'=>'inputError', 'hidden' => '']) !!}
                    {!! Form::textarea('category_description','',['class'=>'form-control category_description_error_field','rows'=>'3','placeholder'=> trans('id.category_description_text')]) !!}
                </div>
                
                    <div class='form-group category_img-group'>
                        {!! Form::label('', '', ['class'=>'control-label category_img_error_label', 'for'=>'inputError', 'hidden' => '']) !!}
                        {!! Form::file('category_img','',['class'=>'form-control category_img_error_field']) !!}
                    </div>

            {!! Form::submit(
            $routeForm == \Config::get('global.CATEGORY_ADD_ACTION')?trans('id.form_create_text'):trans('id.form_edit_text'), 
            ['class'=>'btn btn-lg btn-success btn-block']) !!}
            
            {!! Form::close() !!}
        
        </div>";
    }

    /**
     * Get as string
     * @param type $string
     * @return type
     */
    protected function getAsString ($string) {
        $stringTrim = trim(preg_replace('/\s\s+/', ' ', $string));
        return $stringTrim;
    }
    
    /**
     * Is need button closed at a modal;
     * @param type $idAlert
     * @param type $isNeed
     * @return string
     */
    protected function isNeedClosedButton ($idAlert, $isNeed) {
        if ($isNeed) {
            return "<button type='button' class='close' data-target='#".$idAlert."' data-toggle='modal' aria-hidden='true' data-backdrop='static' data-keyboard='false'>&times;</button>";
        }
        return "";
    }
    
    /**
     * Check if it's single button;
     * @param type $isSingleButton
     * @param type $routeButtonClass
     * @return string
     */
    protected function isSingleButton ($isSingleButton, $routeButtonClass) {
        if ($this->isBoolean($isSingleButton)) {
            return "<button type='button' class='btn btn-default'>{{ trans('id.understand_text') }}</button>";
        }
        
        return "
            <button type='button' class='btn btn-default' data-dismiss='modal'>{{ trans('id.cancel_text') }}</button>
            <a class='btn btn-".$this->getAsString($routeButtonClass)." confirmed_action_button'>{{ trans('id.understand_text') }}</a>";
    }
    
    protected function isBoolean($value) {
        $valueTrim = $this->getAsString($value);
        if ($valueTrim &&  $valueTrim === "true") {
           return true;
        } else {
           return false;
        }
    }
   
}
