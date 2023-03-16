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
              use phpCtrl\C_DataBase;

              $db = new C_DataBase(PHPGRID_DB_HOSTNAME, PHPGRID_DB_USERNAME, PHPGRID_DB_PASSWORD, PHPGRID_DB_NAME, PHPGRID_DB_TYPE,PHPGRID_DB_CHARSET);
              
              $results = $db->db_query('SELECT * FROM products');
              $data1 = array();
              $count = 0;
              
              $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
              
              echo '<ul class="barcode">';
              while($row = $db->fetch_array_assoc($results)) {
                for($i = 0; $i < $db->num_fields($results); $i++) {
                    $col_name = $db->field_name($results, $i);
                    $data1[$count][$col_name] = $row[$col_name];
                }
              
                $code = str_pad($data1[$count]['id'], 8, '0', STR_PAD_LEFT);
                $label = $data1[$count]['ProductLabel'];
              
                echo '<li><div>';
                echo $generator->getBarcode($code, $generator::TYPE_CODE_128, 2, 50);
                echo "<div>$code</div>";
                echo "<div>$label</div>";
                echo '</div></li>';
              
                $count++;
              
              }
              echo '</ul>';
              ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  @endsection
