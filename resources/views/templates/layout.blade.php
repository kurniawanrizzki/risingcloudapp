<!doctype html>
<html lang="{{ app()->getLocale() }}">
    
    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>
            {{env('APP_NAME')}}  
            @section('title')
                -
            @show
        </title>

        <!-- Bootstrap Core CSS -->
        <link href="{{asset('dist/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="{{asset('dist/vendor/metisMenu/metisMenu.min.css')}}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{asset('dist/css/sb-admin-2.css')}}" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="{{asset('dist/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
        
        <!-- DataTables CSS -->
        <link href="{{ asset('dist/vendor/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">

        <!-- DataTables Responsive CSS -->
        <link href="{{ asset('dist/vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">

        
    </head>
    
    <body>
        
        <div class="content">
            @yield("content")
        </div>

        <!-- jQuery -->
        <script src="{{asset('dist/vendor/jquery/jquery.min.js')}}"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="{{asset('dist/vendor/bootstrap/js/bootstrap.min.js')}}"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="{{asset('dist/vendor/metisMenu/metisMenu.min.js')}}"></script>

        <!-- Custom Theme JavaScript -->
        <script src="{{asset('dist/js/sb-admin-2.js')}}"></script>
        
        <!-- DataTables JavaScript -->
        <script src="{{ asset('dist/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('dist/vendor/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
        <script src="{{ asset('dist/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>
        
        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <script>

        $(document).ready(function() {
            
            //user table;
            $('#users_table').DataTable({
                responsive: true
            });
            
            //search button event
            $('#search_btn').click(function (){
                var searchParam = $("[name='search']").val();
                window.location.href = "?search="+searchParam;
            });
            
            //delete alert
            $('#delete-alert').on('show.bs.modal', function(e) {

                var deleteId = $(e.relatedTarget).data('id');
                var confirmedButton = $('.confirmed_action_button');
                
                var route = '{{ \Request::route()->getName()}}';
                var url = '';
                
                if (route === 'dashboard.user') {
                    url = '/dashboard/user/'+deleteId+'/delete';
                } else if (route === 'dashboard.product.index') {
                    url = '/dashboard/product/'+deleteId+'/delete';                    
                } else if (route === 'dashboard.index') {
                    url = '/dashboard/'+deleteId+'/delete';                    
                }
                
                confirmedButton.attr('href', url);
                
            });
      
            // Validate image size in product
            $("input[name='product_image']").bind('change', function() {
                var size = this.files[0].size/1024/1024;
                if (size > 7) {
                    var message = "<?php echo \Lang::get('id.file_large_error_msg',['file_input'=>'product']); ?>";
                    showErrorField('product_image', message);
                    $("input[name='product_image']").val('');
                }
            });
            
            // Validate image size in category
            $("input[name='category_img']").bind('change', function() {
                var size = this.files[0].size/1024/1024;
                if (size > 7) {
                    var message = "<?php echo \Lang::get('id.file_large_error_msg',['file_input'=>'category']); ?>";
                    showErrorField('category_img', message);
                    $("input[name='category_img']").val('');
                }
            });
            
            /**
             * USER ADD COMPONENTS
             */
            
            $('#user-add-form-id').submit(function (e) {
                e.preventDefault();
                var map = getUserFormItems();

                userFormAJAXRequest($(this),"{{ route('dashboard.user.add') }}", map,0);
            });
            
            $('#user-add-form-canceled').click(function() {
                var map = getUserFormItems();
                resetErrorField(map, true);
                $("[name='role']").val("0").change();
                $('.role-group').show();
                
                $('#user-add-form').modal('hide');
            });
                      
            
            /**
             * END OF USER ADD COMPONENTS
             */
            
            
            /**
             * USER EDIT COMPONENTS
             */
            
            $('#user-edit-form').on('show.bs.modal', function(e) {
                var selfRole = {{ \Session::get('role') }}
                var data = $(e.relatedTarget).data('edit');
                
                if (selfRole == data.role) {
                    $('.role-group').hide();
                }
                
                $("[name='user_id']").val(data.id);
                $("[name='username']").val(data.username);
                $("[name='address']").val(data.address);
                $("[name='role']").val(data.role).change();
                $("[name='phone']").val(data.phone);
                
            });
            
            $('#user-edit-form-id').submit(function (e) {
                e.preventDefault();
                var map = getUserFormItems();

                userFormAJAXRequest($(this),"{{ route('dashboard.user.edit') }}", map,0);
            });
            
            $('#user-edit-form-canceled').click(function() {
                var map = getUserFormItems();
                resetErrorField(map, true);
                $("[name='role']").val("0").change();
                $('.role-group').show();

                $('#user-edit-form').modal('hide');
            });
            
            /**
             *END OF USER EDIT COMPONENTS 
             */
             
             /**
              * USER CHANGE PASSWORD COMPONENTS
              */
             
            $('#user-password-form').on('show.bs.modal', function(e) {
                var dataId = $(e.relatedTarget).data('id');
                $("[name='user_id']").val(dataId);
            });
            
            $('#user-password-form-id').submit(function (e) {
                e.preventDefault();
                var map = getUserFormItems();

                userFormAJAXRequest($(this),"{{ route('dashboard.user.edit') }}", map,0);
            });
            
            $('#user-password-form-canceled').click(function() {
                var map = getUserFormItems();
                resetErrorField(map, true);

                $('#user-password-form').modal('hide');
            });
            
            /**
             * END OF USER CHANGE PASSWORD
             */
            
            /**
             * OWN USER CHANGE PASSWORD
             */
            
            $('#user-own-password-form').on('show.bs.modal', function(e) {
                var dataId = $(e.relatedTarget).data('id');
                $("[name='user_id']").val(dataId);
            });
         
            
            $('#user-own-password-form-id').submit(function (e) {
                e.preventDefault();
                var map = getUserFormItems();

                userFormAJAXRequest($(this),"{{ route('dashboard.user.edit') }}", map,0);
            });
            
            $('#user-own-form-canceled').click(function() {
                $('#content-profile').text("")

                $('#profile_password_btn').removeAttr('data-id');
                $('#profile_edit_btn').removeAttr('data-edit');
                $('#user-own-form').modal('hide');
            
            });
            
            /**
             * END OF OWN USER CHANGE PASSWORD
             */
            
            /**
             * PRODUCT ADD FORM 
             */
            
            $('#product-add-form').on('show.bs.modal', function(e) {
                var categories =  <?php echo isset($categories)?json_encode($categories):null ?> ;
                fillCategoriesDropdown (categories.data);
                
            });
            
            $('#product-add-form-id').submit(function (e) {
                e.preventDefault();
                var map = getProductFormItems();

                userFormAJAXRequest($(this),"{{ route('dashboard.product.add') }}", map,1);
            });
            
            $('#product-add-form-canceled').click(function() {
                $('#product-add-form').modal('hide');
            });
            
            /**
             * END OF PRODUCT ADD FORM
             */
            
            /**
             * PRODUCT EDIT FORM 
             */
            $('#product-edit-form').on('show.bs.modal', function(e) {
                var categories =  <?php echo isset($categories)?json_encode($categories):null ?> ;
                var data = $(e.relatedTarget).data('edit');
                fillCategoriesDropdown (categories);
                
                $("[name='product_id']").val(data.id);
                $("[name='product_name']").val(data.name);
                $("[name='category']").val(data.category_id).change();
                $("[name='deskripsi']").val(data.description);
                $("[name='stock']").val(data.stock);
                $("[name='purchase']").val(data.purchase);
                $("[name='sell']").val(data.sell);
                               
            });
            
            $('#product-edit-form-id').submit(function (e) {
                e.preventDefault();
                var map = getProductFormItems();

                userFormAJAXRequest($(this),"{{ route('dashboard.product.edit') }}", map,1);
            });
            
            $('#product-edit-form-canceled').click(function() {
                $('#product-edit-form').modal('hide');
            });
            
            /**
             * END OF PRODUCT EDIT FORM
             */
            
            /**
             * CATEGORY ADD FORM
             */
            
            $('#category-add-form-id').submit(function (e) {
                e.preventDefault();
                var map = getCategoryFormItems();

                userFormAJAXRequest($(this),"{{ route('dashboard.add') }}", map,1);
            });
            
            $('#category-add-form-canceled').click(function() {
                
                var map = getCategoryFormItems();
                resetErrorField(map, true);
                
                $('#category-add-form').modal('hide');
                
            });
            
            /**
             * END OF CATEGORY ADD FORM
             */
            
            /**
             * CATEGORY EDIT FORM
             */
            
            $('#category-edit-form').on('show.bs.modal', function(e) {
                var data = $(e.relatedTarget).data('edit');
                
                $("[name='category_id']").val(data.id);
                $("[name='category_name']").val(data.name);
                $("[name='category_description']").val(data.description);
                
            });
            
            $('#category-edit-form-id').submit(function (e) {
                e.preventDefault();
                var map = getCategoryFormItems();

                userFormAJAXRequest($(this),"{{ route('dashboard.edit') }}", map,1);
            });
            
            $('#category-edit-form-canceled').click(function() {
                var map = getCategoryFormItems();
                resetErrorField(map, true);
                $('#category-edit-form').modal('hide');
            });
            
            /**
             * END OF CATEGORY EDIT FORM
             */
            
            $('#profile-id').click(function(e){
                e.preventDefault();

                $.ajax({
                    type    :'GET',
                    url     : "{{ route('dashboard.user.view') }}",
                    success : function (e) {
                        var response = e.responseJSON;
                                                
                        if (typeof response !== 'undefined') {
                            
                            var errors = response.errors;
                            
                                
                            if (typeof errors === 'undefined') {
                                var status  = response.status;
                                var msg     = response.message;                                
                                
                                if (status == 200) {
                                    
                                    var profileData    = response.data;
                                    
                                    $("#content-profile").append("<div>"+
                                        "<strong>"+profileData.username+"</strong>"+
                                        "<span class='pull-right text-muted'>"+
                                            "<em>"+(profileData.role == 0?"ADMIN":"KASIR")+"</em>"+
                                        "</span>"+
                                    "</div>"+
                                    "<div>"+
                                        "<p>"+profileData.address+" - "+profileData.phone+"</p>"+
                                    "</div>");
                                    
                                    $('#profile_password_btn').attr('data-id',profileData.id);
                                    $('#profile_edit_btn').attr('data-edit',JSON.stringify(profileData));
                                    
                                }
                                
                                return;
                            }
                            
                            console.log(errors);
                             
                        }

                    },
                    error   : function (e) {
                        console.log(e);
                    } 
                })
            })
            
            /**
             * User form ajax request;
             * @param {type} form
             * @param {type} route
             * @param {type} map
             * @param {type} code --> for file please put 1; Otherwise default;
             * @returns {undefined}
             */
            function userFormAJAXRequest (form,route,map,code) {
                var mapper = map;
                var request;
                
                switch (code) {
                    case 1 :
                        var serializeData = new FormData(form[0]);
                        request = {
                            type        : 'POST',
                            url         : route,
                            data        : serializeData,
                            processData : false,
                            contentType : false,
                            cache       : false
                        }
                        
                        break;
                    default :
                        
                        request = {
                            type    : 'POST',
                            url     : route,
                            data    : form.serialize(),
                            dataType: 'json'
                        };
                        
                        break;
                }
                                
                request.success = function (e) {
                    
                    var response = e.responseJSON;

                    if (typeof response !== 'undefined') {

                       var errors = response.errors;

                       if (typeof errors === 'undefined') {
                            
                            var dstRoute = null;
                            var status  = response.status;
                            var msg     = response.message;

                            if (status == 200) {
                                resetErrorField(mapper, true);

                                // check which the modal that is displayed currently;
                                if ($('#user-add-form').hasClass('in')) {
                                    $('#user-add-form').modal('hide');
                                } else if ($('#user-edit-form').hasClass('in')) {
                                    $("[name='user_id']").val(""); 
                                    $("[name='role']").val("0").change();
                                    $('.role-group').show();
                                    $('#user-edit-form').modal('hide');
                                } else if ($('#user-password-form').hasClass('in')) {
                                    $("[name='user_id']").val(""); 
                                    $('#user-password-form').modal('hide');                                        
                                } else if ($('#product-add-form').hasClass('in')) {
                                    $('#product-add-form').modal('hide');
                                    var categoryId = $("select[name = 'category']").val();
                                    dstRoute = '/dashboard/product/'+categoryId+'/view';
                                } else if ($('#product-edit-form').hasClass('in')) {
                                    $("[name='product_id']").val(""); 
                                    $('#product-edit-form').modal('hide'); 
                                } else if ($('#category-add-form').hasClass('in')) {
                                    $('#category-add-form').modal('hide');                                        
                                } else if ($('#category-edit-form').hasClass('in')) {
                                    $("[name='category_id']").val(""); 
                                    $('#category-edit-form').modal('hide');                                       
                                }

                                alerting(msg,true, dstRoute);

                            }

                            return;

                       }

                       console.log(errors);

                    }
                    
                }
                
                request.error = function(e){
                    var errors = e.responseJSON.errors;
                    if (typeof errors !== 'undefined') {

                        Object.keys(errors).forEach(function(key) {
                            var message = errors[key][0];
                            showErrorField (key, message);
                            mapper[key] = !mapper[key];
                        });

                        resetErrorField(mapper, false);

                    } 
                };
                
                $.ajax(request);
                
            }
            
            /**
             * Show error field;
             * @param {type} errorFieldId
             * @param {type} message
             * @returns {undefined}
             */
            function showErrorField (errorFieldId, message) {
                var errorFieldGroup = $("."+errorFieldId+"-group");
                var errorField = $("."+errorFieldId+"_error_label");
                errorField.text('');
                
                errorField.append(message);
                errorFieldGroup.addClass('has-error');
                errorField.removeAttr('hidden');
            }
            
            /**
             * Hide error field;
             * @param {type} errorFieldId
             * @returns {undefined}
             */
            function hideErrorField (errorFieldId) {
                var errorFieldGroup = $("."+errorFieldId+"-group");
                var errorField = $("."+errorFieldId+"_error_label");
                
                errorField.text('');
                errorFieldGroup.removeClass('has-error');
                errorField.attr('hidden');
            } 
            
            /**
             * Reseting error field;
             * @param {type} isNeedToClearField
             * @param {type} map
             */
            function resetErrorField (map, isNeedToClearField) {
                Object.keys(map).forEach(function(key){
                   if (map[key]) {
                        hideErrorField(key);
                        if (isNeedToClearField) {
                            $("[name='"+key+"']").val("");
                        }
                    } 
                });
            }
            
            /**
             * Alerting box;
             * @param {type} msg
             * @param {type} isNeedToReload
             * @param {type} dstRoute
             */
            function alerting (msg,isNeedToReload, dstRoute) {
                alert(msg);
                if (null == dstRoute) {
                    window.location.reload(isNeedToReload);
                    return;
                }
                window.location = dstRoute;
            }
            
            /**
             * get user form items;
             * @returns {layout.bladeL#16.getUserFormItems.layout.bladeAnonym$0}
             */
            function getUserFormItems () {
                return {
                    username            : true,
                    old_password        : true,
                    password            : true,
                    confirm_password    : true,
                    phone               : true,
                    address             : true
                };
            }
            
            /**
            * get category form items; 
            */
            function getCategoryFormItems () {
                return {
                    category_name           : true,
                    category_description    : true,
                    category_img            : true
                };
            }
            
            /**
            * Get Products form item;
             */
            function getProductFormItems () {
                return {
                    product_name        : true,
                    deskripsi           : true,
                    purchase            : true,
                    stock               : true,
                    sell                : true,
                    product_image       : true
                    
                }
            }
            
            /**
            * Fill category dropdowns
             */
            function fillCategoriesDropdown (categories) {
                
                var categoryDropdown = $("[name='category']");
                
                if (categories.length > 0) {
                    
                    $.each(categories, function(key,category) {
                        categoryDropdown.append($("<option />").val(category.id).text(category.name));
                    });
                    
                    return;
                }
                
                showErrorField('category','Empty Category. Please add certain category before to add new product.');
            }
            
        });
        </script>


    </body>

</html>

