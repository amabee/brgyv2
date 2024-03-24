<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Brgy Health Center</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->

  <link rel="stylesheet" href="../../assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

  
  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

  <!-- DataTables JavaScript -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
        .error {
            color: red;
        }
    </style>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

 

  <!-- Navbar -->
  <nav class="main-header  navbar-expand navbar-white navbar-light " style="padding: 5px !important;z-index: 1">
  <!-- Left navbar links -->


     <div class="row mx-0">
          <div class="col-sm-1">
            <a class="nav-link " data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color: gray"></i></a>
          </div>

          <div class="col-sm-5">
            <h4 style="font-weight: bold" class="mt-1"><h4 style="font-weight: bold;"><?= $pageTitle ?></h4></h4>
          </div>

          <div class="col-sm-3">
            <div class="input-group input-group-sm" >



            </div>
          </div>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" >
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <center>

      <img src="../../assets/images/h.png" alt="" style ="height:100px; width:100px;">
      </center>
      <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" >
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../../assets/images/l.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin/Doctor</a>
        </div>
      </div>

   

      <!-- Sidebar Menu -->
      <nav class="mt-2" style="height:700px;">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
            <a href="../dashboard/dashboard.php" class="nav-link">
              <i class="fas fa-tachometer-alt "></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

   
              
          <li class="nav-item <?php
  if (
    strpos($_SERVER['REQUEST_URI'], '/brgyv2/admin/consultation/consultation.php') !== false ||
    strpos($_SERVER['REQUEST_URI'], '/brgyv2/admin/consultation/done_consultation.php') !== false
  ) {
    echo 'menu-open';
  }
?>">
  <a href="" class="nav-link">
    <i class="fas fa-file-prescription fa-lg" aria-hidden="true"></i>
    <p>
    Checkup
      <i class="fas fa-angle-left right"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
    <a href="../consultation/consultation.php" class="nav-link <?php if ($_SERVER['REQUEST_URI'] === '/brgyv2/admin/consultation/consultation.php') echo 'active'; ?>">
  <i class="fas fa-user-edit fa-lg nav-icon"></i>
  <p>Pending</p>
</a>
    </li>
    <li class="nav-item">
      <a href="../consultation/done_consultation.php" class="nav-link <?php if ($_SERVER['REQUEST_URI'] === '/brgyv2/admin/consultation/done_consultation.php') echo 'active'; ?>">
        <i class="fas fa-user-edit fa-lg nav-icon"></i>
        <p>Done</p>
      </a>
    </li>
  </ul>
</li>

       
                  
          <li class="nav-item">
            <a href="../status/status.php" class="nav-link">
              <i class="fas fa-vial fa-lg "></i>
              <p>
              Status
              </p>
            </a>
          </li>

           
    
          <li class="nav-item">
            <a href="../report/report.php" class="nav-link">
              <i class="fa fa-book fa-lg "></i>
              <p>
              Report
              </p>
            </a>
          </li>
          
          <li class="nav-item <?php
  if (
    strpos($_SERVER['REQUEST_URI'], '/brgyv2/admin/admin/admin.php') !== false ||
    strpos($_SERVER['REQUEST_URI'], '/brgyv2/admin/nurse/nurse.php') !== false ||
    strpos($_SERVER['REQUEST_URI'], '/brgyv2/admin/superadmin/superadmin.php') !== false ||
    strpos($_SERVER['REQUEST_URI'], '/brgyv2/admin/staff/staff.php') !== false
  ) {
    echo 'menu-open';
  }
?>">
  <a href="" class="nav-link">
    <i class="fa fa-cog fa-lg" aria-hidden="true"></i>
    <p>
      Settings
      <i class="fas fa-angle-left right"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">
    <li class="nav-item">
    <a href="../admin/admin.php" class="nav-link <?php if ($_SERVER['REQUEST_URI'] === '/brgyv2/admin/admin/admin.php') echo 'active'; ?>">
  <i class="fas fa-user-edit fa-lg nav-icon"></i>
  <p>Admin</p>
</a>
    </li>
    <li class="nav-item">
      <a href="../superadmin/superadmin.php" class="nav-link <?php if ($_SERVER['REQUEST_URI'] === '/brgyv2/admin/superadmin/superadmin.php') echo 'active'; ?>">
        <i class="fas fa-user-edit fa-lg nav-icon"></i>
        <p>Superadmin</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="../nurse/nurse.php" class="nav-link <?php if ($_SERVER['REQUEST_URI'] === '/brgyv2/admin/nurse/nurse.php') echo 'active'; ?>">
        <i class="fas fa-user-nurse fa-lg nav-icon"></i>
        <p>Nurses</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="../staff/staff.php" class="nav-link <?php if ($_SERVER['REQUEST_URI'] === '/brgyv2/admin/staff/staff.php')  echo 'active'; ?>">
        <i class="fas fa-user-edit fa-lg nav-icon"></i>
        <p>Staff</p>
      </a>
    </li>
  </ul>
</li>


          <li class="nav-item">
            <a href="../action/logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt "></i>
              <p>
              Logout
              </p>
            </a>
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
        <?php include $contentTemplate; ?>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->


<script src="../../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../assets/dist/js/adminlte.js"></script>



<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="../../assets/dist/js/pages/dashboard.js"></script> -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>


</body>
</html>
