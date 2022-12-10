<?php 
  require "./include/kiemtradangnhap.php";
  include "include/header3.php";
  include "mohinh/mongodb.php";
?>
<?php 
  $tableSach = $db->sach;
  $i = 1;
  unset($_SESSION['page']);
  // $cursor1 = $tableSach->find()->limit($offset,$total_records_per_page);
  // get page number
  if (isset($_GET['page_no']) && $_GET['page_no'] !== ""){
    $page_no = $_GET['page_no'];
    $_SESSION['page'] = $page_no;
    // print_r($_SESSION);
  } else {
    $page_no = 1;
    $_SESSION['page'] = $page_no;
  }
  $tableSach = $db->sach;
  //toltal rows or records to display
  $total_records_per_page = 5;
  //get page limit
  $offset = ($page_no - 1) * $total_records_per_page;
  // print_r($offset); 0
  //get previous
  $previous_page = $page_no - 1;
  //get the next
  $next_page = $page_no + 1;
  //get the total count of records
  $result_count = $tableSach->count();
  // print_r($result_count); 735
  //get total pages
  $total_no_of_pages = ceil($result_count / $total_records_per_page);
  // print_r($total_no_of_pages);

  $cursor = $tableSach -> find();
  $arrQuery = [];
  $j=1;
  foreach ($cursor as $document) {
    $document->stt = $j;
    $arrQuery[]=$document;
    $j++;
  }
  // $cursor1 = $tableSach->find([], ["limit" => $total_records_per_page,"skip" => $offset]);
  // $cursor1 = $tableSach->find()->limit($total_records_per_page)->skip($offset);
  //  print_r($cursor1);
  // $page_no = (int)$_GET['page_no'];
  $start = $total_records_per_page*$page_no - $total_records_per_page;
  $end = $total_records_per_page*$page_no - 1;
  $dataPagination = [];
  for($i=$start ; $i <= $end; $i++){
    if($i<=$result_count-1){
      $dataPagination[]=$arrQuery[$i];
    }
  }
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Victory</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Quản lý
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index2.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tra cứu tài liệu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Vị trí sách</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Quản lý RFID</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index4.php" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Quản lý vật cản</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index5.php" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Quản lý sách</p>
                </a>
              </li>
            </ul>
          </li>
          <?php 
                // include "include/sidebar.php";
              ?>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Quản lý sách</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Quản lý sách</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- Content Wrapper. Contains page content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row mb-2">
        <?php 
          if (isset($_GET['capnhatsach'])){
            // $_SESSION['capnhatsach']=$_GET['capnhatsach'];
            $id_capnhat=$_GET['capnhatsach'];
            $tableSach = $db->sach;
            $a = $tableSach->find(['mass' => (int)$id_capnhat]);
            foreach ($a as $capnhat){
            
        ?>
        <div class="col-sm-3">
            <form action="quanlysach/thaotac.php" method="post">

            <legend>Cập nhật sách</legend>
              <label for="">Mã số:</label> <br>
              <input type="number" name="mass" value="<?php echo $capnhat['mass'] ?>" required> <br>
              <label for="">Tên sách:</label> <br>
              <input type="text" name="tensach" value="<?php echo $capnhat['tensach'] ?>" required> <br>
              <label for="">Trạng thái:</label> <br>
              <input type="text" name="trangthai" value="<?php echo $capnhat['trangthai'] ?>" required> <br>
              <label for="">Mô tả:</label> <br>
              <input type="text" name="mota" value="<?php echo $capnhat['mota'] ?>" required> <br>
              <label for="">Tọa độ X:</label> <br>
              <input type="number" name = "toadoxsach" value="<?php echo $capnhat['toadox'] ?>" required> <br>
              <label for="">Tọa độ Y:</label> <br>
              <input type="number" name = "toadoysach" value="<?php echo $capnhat['toadoy'] ?>" required> <br> <br>
              <input type="submit" name="capnhat" value="Cập nhật"> 
            </form >
        </div>

        <?php }}else{ ?>


        <div class="col-sm-3">
          <form action="quanlysach/thaotac.php" method="post">
            <legend>Thêm sách</legend>
              <label for="">Mã số:</label> <br>
              <input type="number" name="mass" required> <br>
              <label for="">Tên sách:</label> <br>
              <input type="text" name="tensach" required> <br>
              <label for="">Trạng thái:</label> <br>
              <input type="text" name="trangthai" required> <br>
              <label for="">Mô tả:</label> <br>
              <input type="text" name="mota" required> <br>
              <label for="">Tọa độ X:</label> <br>
              <input type="number" name = "toadoxsach" required> <br>
              <label for="">Tọa độ Y:</label> <br>
              <input type="number" name = "toadoysach" required> <br> <br>
              <input type="submit" name="themsach" value="Thêm"> 
          </form >
        </div>

        <?php } ?>
        <div class="col-sm-9">
            <table class="table">
            <div class="row mb-2">
                <legend class="col-sm-9"  >Danh sách Tài Liệu</legend> 
                <div class="p-10 col-sm-3">
                  <strong>Page <?= $page_no; ?> of <?=$total_no_of_pages; ?></strong>
                </div>
                
            </div>
              <thead class="thead-light">
                <tr>
                  <th scope="col">MS</th>
                  <th scope="col">Tên Sách</th>
                  <th scope="col">Tọa Độ X</th>
                  <th scope="col">Tọa Độ Y </th>
                  <th scope="col">Trạng Thái</th>
                  <th scope="col" style="width: 300px">Mô Tả</th>
                  <th scope="col" >Thao Tác</th>
                  <!-- <th scope="col">Thao Tác</th> -->
                </tr>
              </thead>
              <tbody>
                
                <!-- show tất cả sách trong csdl -->
                <?php
                  foreach ($dataPagination as $document) {
                ?>
                <tr>
                  <th scope="row"><?php echo $document["mass"]; ?></th>
                  <td><?php echo $document["tensach"]; ?></td>
                  <td><?php echo $document["toadox"]; ?></td>
                  <td><?php echo $document["toadoy"]; ?></td>
                  <td><?php echo $document["trangthai"]; ?></td>
                  <td><?php echo $document["mota"]; ?></td>
                  <td><a  href="./quanlysach/thaotac.php?xoasach=<?php echo $document['mass'];?>"></i>Xóa
                  || <a href="?capnhatsach=<?php echo $document['mass'];?>&page_no=<?php echo $_SESSION['page'];?>">Cập nhật</a></td>
                </tr>
                <?php 
                  }
                ?>

              </tbody>
            </table>
            <nav aria-label="...">
              <ul class="pagination">
                
                <li class="page-item"><a class="page-link <?= ($page_no <= 1)? 
                'disabled' : ''; ?>"<?= ($page_no > 1) ? 'href=?page_no=' . 
                $previous_page : ''; ?>>Previous</a></li>

                <?php
                  for ($counter =1 ; $counter <= $total_no_of_pages; $counter++)
                  { ?>
                    <?php if ($page_no != $counter){ ?>
                      <li class="page-item"><a class="page-link" href="?page_no=<?= $counter; ?>"><?=$counter; ?></a></li>
                    <?php } else { ?>
                      <li class="page-item active"><a class="page-link " ><?= $counter; ?></a></li>
                   <?php } ?>
                <?php } ?>

                <li class="page-item"><a class="page-link <?= ($page_no >= $total_no_of_pages)? 
                'disabled' : ''; ?>"<?= ($page_no < $total_no_of_pages) ? 'href=?page_no=' . 
                $next_page : ''; ?> href="#">Next</a></li>
              </ul>
            </nav>
        </div>
        </div>
      </div>
    </section>

 

  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.5
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="dist/js/demo.js"></script>
<script src="dist/js/pages/dashboard3.js"></script>
</body>
</html>
