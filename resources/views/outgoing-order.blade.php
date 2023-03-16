@extends('layouts.user_type.auth')

@section('content')

  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4 border-0">
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">

              <?php
              use phpCtrl\C_DataGrid;

              $dgOrd = new C_DataGrid('SELECT id, OrderDate, ProductId, NumberShipped, First, Last FROM orders', 'id', 'orders');
              $dgOrd->set_sortname('OrderDate', 'DESC');
              $dgOrd->set_col_hidden('id', false);
              
              $dgOrd->set_col_title('OrderDate', 'Order Date');
              $dgOrd->set_col_title('ProductId', 'Product');
              $dgOrd->set_col_title('NumberShipped', 'Number Shipped');
              
              $dgOrd->set_col_edittype('ProductId', 'autocomplete', "select id, ProductLabel from products");
              
              // $dgOrd->enable_edit('FORM');
              $dgOrd->set_pagesize(100);
              
              $dgOrd->set_col_width('OrderDate', '30px');
              $dgOrd->set_col_width('NumberShipped', '35px');
              $dgOrd->set_col_width('First', '20px');
              $dgOrd->set_col_width('Last', '20px');
              
              $dgOrd->set_grid_method('setGroupHeaders', array(
                                              array('useColSpanStyle'=>true),
                                              'groupHeaders'=>array(
                                                      array('startColumnName'=>'First',
                                                            'numberOfColumns'=>2,
                                                            'titleText'=>'Customer Name') )));
              
              $dgOrd->enable_autowidth(true);
              $dgOrd->enable_edit('FORM');
              
              $dgOrd->display();
              ?>
              
              Outgoing orders reduce inventory.
              
              <script>
              $(function(){	
                  $(".add-new-row").on("click",function(){
                      $("#add_orders").click();
                  });
              });
              </script>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  @endsection
