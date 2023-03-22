@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4 border-0">
            <div class="card-body px-2 pt-2 pb-2">
              <div class="table-responsive p-0">

              <?php
              use phpCtrl\C_DataGrid;

              $suppliers = new C_DataGrid('SELECT * FROM category', 'id', 'category');
              $suppliers->enable_autowidth(true);
              $suppliers->enable_edit();
              $suppliers->display();
              ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  @endsection
