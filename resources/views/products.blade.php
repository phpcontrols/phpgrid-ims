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

              $dgProd = new C_DataGrid('SELECT * FROM products', 'id', 'products');
              $dgProd->set_col_hidden('id', false);
              $dgProd->enable_autowidth(true)->set_dimension('auto', '200px')->set_pagesize(100);

              $dgProd->set_col_title('ProductName', 'Name');
              $dgProd->set_col_title('PartNumber', 'Part Number');
              $dgProd->set_col_title('ProductLabel', 'Label');
              $dgProd->set_col_title('StartingInventory', 'Starting Inventory');
              $dgProd->set_col_title('InventoryReceived', 'Inventory Received');
              $dgProd->set_col_title('InventoryShipped', 'Inventory Shipped');
              $dgProd->set_col_title('InventoryOnHand', 'Inventory On Hand');
              $dgProd->set_col_title('MinimumRequired', 'Minimum Required');

              $dgProd->set_col_format('StartingInventory', 'integer', array('thousandsSeparator'=>',', 'defaultValue'=>'0'));
              $dgProd->set_col_format('InventoryReceived', 'integer', array('thousandsSeparator'=>',', 'defaultValue'=>'0'));
              $dgProd->set_col_format('InventoryShipped', 'integer', array('thousandsSeparator'=>',', 'defaultValue'=>'0'));
              $dgProd->set_col_format('InventoryOnHand', 'integer', array('thousandsSeparator'=>',', 'defaultValue'=>'0'));
              $dgProd->set_col_format('MinimumRequired', 'integer', array('thousandsSeparator'=>',', 'defaultValue'=>'0'));

              $dgProd->set_conditional_format('InventoryOnHand', 'CELL', array("condition"=>"lt",
                                                                "value"=>"1",
                                                                "css"=> array("color"=>"red","background-color"=>"#DCDCDC")));

              $dgProd->set_col_property('StartingInventory', array('classes'=>'number-columns'));
              $dgProd->set_col_property('InventoryReceived', array('classes'=>'number-columns'));
              $dgProd->set_col_property('InventoryShipped', array('classes'=>'number-columns'));
              $dgProd->set_col_property('InventoryOnHand', array('classes'=>'number-columns'));
              $dgProd->set_col_property('MinimumRequired', array('classes'=>'number-columns'));

              $onGridLoadComplete = <<<ONGRIDLOADCOMPLETE
              function(status, rowid)
              {
                  var ids = jQuery("#products").jqGrid('getDataIDs');
                  for (var i = 0; i < ids.length; i++)
                  {
                      var rowId = ids[i];
                      var rowData = jQuery('#products').jqGrid ('getRowData', rowId);

                      var inventoryOnHand = $("#products").jqGrid("getCell", rowId, "InventoryOnHand");
                      var minimumRequired = $("#products").jqGrid("getCell", rowId, "MinimumRequired");

                      // compare two dates and set custom display in another field "status" 
                      console.log(inventoryOnHand + " | " + minimumRequired);
                      if(parseInt(inventoryOnHand) < parseInt(minimumRequired)){
                          
                          $("#products").jqGrid("setCell", rowId, "PartNumber", '', {'background-color':'gold'}); 
                              
                      }
                  }

              }
              ONGRIDLOADCOMPLETE;
              $dgProd->add_event("jqGridLoadComplete", $onGridLoadComplete);
              $dgProd->enable_edit('FORM');

              // Purchases detail grid
              $dgPur = new C_DataGrid('SELECT id, PurchaseDate, ProductId, NumberReceived, SupplierId FROM purchases', 'id', 'purchases');
              $dgPur->set_col_hidden('id', false)->set_caption('Incoming Purchases');
              $dgPur->set_col_edittype('ProductId', 'select', "select id, ProductLabel from products");
              $dgPur->set_col_edittype('SupplierId', 'select', "select id, supplier from suppliers");
              $dgPur->set_dimension('800px');

              // Orders detail grid
              $dgOrd = new C_DataGrid('SELECT id, OrderDate, ProductId, NumberShipped, First, Last FROM orders', 'id', 'orders');
              $dgOrd->set_sortname('OrderDate', 'DESC')->set_caption('Outgoing Orders');
              $dgOrd->set_col_hidden('id', false);
              $dgOrd->set_col_edittype('ProductId', 'select', "select id, ProductLabel from products");
              $dgOrd->set_dimension('800px');

              $dgProd->set_masterdetail($dgPur, 'ProductId', 'id');
              $dgProd->set_masterdetail($dgOrd, 'ProductId', 'id');
              $dgProd->display();
              ?>

              <span style="background-color:gold">______</span> -- Indicating inventory that needs reorder.<br />
              <span style="background-color:#DCDCDC">______</span> -- Negative inventory on hand!

              <style>
              .number-columns{
                font-weight: 700 !important;
              }
              </style>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  @endsection
