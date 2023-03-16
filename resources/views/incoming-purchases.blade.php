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

                $dgPur = new C_DataGrid('SELECT id, PurchaseDate, ProductId, NumberReceived, SupplierId FROM purchases', 'id', 'purchases');
                $dgPur->set_col_hidden('id', false);

                $dgPur->set_col_title('PurchaseDate', 'Date of Purchase');
                $dgPur->set_col_title('ProductId', 'Product');
                $dgPur->set_col_title('NumberReceived', 'Number Received');
                $dgPur->set_col_title('SupplierId', 'Supplier');

                $dgPur->set_col_edittype('ProductId', 'autocomplete', "select id, concat(lpad(id, 8, '0'), ' | ', ProductLabel) from products");
                $dgPur->set_col_edittype('SupplierId', 'autocomplete', "select id, supplier from suppliers");

                // $dgPur->enable_edit('FORM');
                $dgPur->set_pagesize(100);

                $dgPur->set_col_width('PurchaseDate', '50px');
                $dgPur->set_col_width('NumberReceived', '35px');

                $dgPur -> set_group_properties('ProductId', false, true, true, false);
                $dgPur -> set_group_summary('NumberReceived','sum');

                $dgPur->enable_autowidth(true);

                $dgPur->enable_edit('FORM');
                $dgPur->display();
                ?>

                Incoming orders increase inventory.

                <script>
                $(function(){	
                    $(".add-new-row").on("click",function(){
                        $("#add_purchases").click();
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