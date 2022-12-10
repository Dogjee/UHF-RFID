<?php 
  include "include/header.php";
  include "mohinh/mongodb.php";
?>

<?php 
  // if(isset($_POST['timkiemsach'])){
  //   $tukhoa=$_POST['tukhoa'];
  //   $tableSach = $db->sach;
  //   $cursor = $tableSach->find(['tensach'=> new MongoDB\BSON\Regex($tukhoa, 'i')]);
  // }
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
                Quản Lý 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                
                <a href="./index2.php" class="nav-link active">
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
                <a href="./index3.php" class="nav-link">
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
                <a href="./index5.php" class="nav-link">
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
          <div class="col-sm-4">
            <h1 class="m-0 text-dark">Danh sách tài liệu</h1>
          </div><!-- /.col -->
          <div class="col-sm-4">
             <form class="form-inline ml-3" method="POST">
                <div class="input-group input-group-sm">
                  <input class="form-control form-control-navbar" name="tukhoa"   placeholder="Tìm kiếm..." aria-label="Search">
                  <div class="input-group-append">
                  <!-- <input type="submit"  value="Tìm" name='timkiemsach'> -->
                    <button class="btn btn-outline-primary" name="timkiemsach" type="submit">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
              </form>
          </div><!-- /.col -->
          <div class="col-sm-4">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Tra cứu tài liệu</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Content Wrapper. Contains page content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <table class="table">
              <thead class="thead-light">
                <tr>
                  <th scope="col">MSS</th>
                  <th scope="col">Tên Sách</th>
                  <th scope="col" style = "width: 700px">Mô Tả</th>
                  <th scope="col">Trạng Thái</th>
                  <!-- <th scope="col">Thao Tác</th> -->
                </tr>
              </thead>
              <tbody>
                
                <?php 
                  if(isset($_POST['timkiemsach'])){
                    $tukhoa=$_POST['tukhoa'];
                    $tableSach = $db->sach;
                    $cursor = $tableSach->find(['tensach'=> new MongoDB\BSON\Regex($tukhoa, 'i')]);
                    foreach ($cursor as $kq) {
                 
                ?>
                <tr>
                  <th scope="row"><?php echo $kq["mass"]; ?></th>
                  <td><?php echo $kq["tensach"]; ?></td>
                  <td><?php echo $kq["mota"]; ?></td>
                  <td><?php echo $kq["trangthai"]; ?></td>
                </tr>
                <?php 
                  }}else{
                ?>
                <!-- show tất cả sách trong csdl -->
                <?php 
                  $tableSach = $db->sach;
                  $cursor1 = $tableSach->find(); 
                  foreach ($cursor1 as $document) {
                ?>
                <tr>
                  <th scope="row"><?php echo $document["mass"]; ?></th>
                  <td><?php echo $document["tensach"]; ?></td>
                  <td><?php echo $document["mota"]; ?></td>
                  <td><?php echo $document["trangthai"]; ?></td>
                </tr>
                <?php 
                  }}
                ?>

              </tbody>
            </table>
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
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="dist/js/pages/dashboard2.js"></script>
</body>
</html>
