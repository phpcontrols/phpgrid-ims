@extends('layouts.user_type.auth')

@section('content')

<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                    <?php
                    use phpCtrl\C_DataGrid;

                    $userGrid = new C_DataGrid('SELECT id, name, email, phone, location, about_me FROM users', 'id', 'users', 
                                                    ["hostname"=>PHPGRID_DB_HOSTNAME,
                                                    "username"=>PHPGRID_DB_USERNAME,
                                                    "password"=>PHPGRID_DB_PASSWORD,
                                                    "dbname"=>"softui-laravel-phpgrid", 
                                                    "dbtype"=>"mysql", 
                                                    "dbcharset"=>"utf8mb4"]);  
                    $userGrid->set_caption('User Management');
                    $userGrid->enable_autowidth('100%');  
                    $userGrid->enable_edit();      
                    $userGrid->display();
                    ?>
                </div>
            </div>
        </div>
    </div>

</div>
 
@endsection