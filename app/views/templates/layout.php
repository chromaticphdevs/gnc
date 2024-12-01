<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title><?php echo $pageTitle?? 'Breakthrough-e| Cash Advance'?></title>
  <meta content="<?php echo HEADING_META['keywords']?>" name="keywords">
  <meta content="<?php echo HEADING_META['description']?>" name="description">
  <meta content="width=device-width" name="viewport" type="image/x-icon">
  <meta content="website" property="og:type">
  <meta content="<?php echo HEADING_META['og:url']?>" property="og:url">
  <meta content="<?php echo HEADING_META['og:title']?>" property="og:title">
  <meta content="<?php echo HEADING_META['og:description']?>" property="og:description">
  <meta content="<?php echo HEADING_META['og:image']?>" property="og:image">

  <link rel="icon" href="<?php echo HEADING_META['favicon']?>">
  <!-- Custom fonts for this template-->
  <link href="<?php echo _path_tmp('ui-main/vendor/fontawesome-free/css/all.min.css')?>" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo _path_tmp('ui-main/css/sb-admin-2.min.css')?>" rel="stylesheet">
  <link href="<?php echo _path_tmp('ui-main/css/custom.css')?>" rel="stylesheet">
  <link href="<?php echo _path_tmp('ui-main/vendor/datatables/dataTables.bootstrap4.min.css')?>" rel="stylesheet">

  <?php produce('headers') ?>
  <?php produce('styles') ?>

  <style>
    #accordionSidebar{
      background-color: #243954;
    }

    #accordionSidebar, 
    #accordionSidebar li a {
      color: #fff;
    }

    #accordionSidebar .sidebar-heading {

    }

    #accordionSidebar .dropdown  a.dropdown-item{
      color: #fff;
    }

    #accordionSidebar .dropdown  a.dropdown-item:hover{
      background-color: orange;
    }

  </style>
</head>
    
<body id="page-top" class="sidebar-toggled">
  <?php $navHelper = new NavigationHelper(); ?>
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar accordion toggled" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center mt-3" href="">
        <div class="sidebar-brand-icon">
          <img src="<?php echo _path_upload_get('logo-circle.png')?>" alt="" id="system-logo">
        </div>
      </a>
        <div class="mt-3"><?php echo $navHelper->getNavsHTML()?></div>
        <div class="text-center d-none d-md-inline">
          <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>
        <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow py-1 px-3">
          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Alerts -->
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-lg-inline text-gray-600 small"><?php echo userVerfiedText(whoIs())?> <?php echo whoIs('firstname')?></span>
                <?php
                  $selfie = trim(whoIs('selfie'));
                  $selfie = empty($selfie) ? URL.DS.'uploads/main_user_icon.png' : GET_PATH_UPLOAD.DS.'profile'.DS.$selfie;
                ?>
                <img class="img-profile rounded-circle border" src="<?php echo $selfie?>">
              </a>

              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/AccountProfile/index"><i class="fas fa-user-alt fa-sm fa-fw mr-2 text-gray-400"></i>Profile</a>
                
                <?php if(isEqual(whoIs('type'), USER_TYPES['MEMBER'])) :?>
                <a class="dropdown-item" href="javascript:void(0)">
                  <?php echo wReferralLink(createReferralLink())?>
                </a>
                <?php endif?>
                
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>

        <?php if(empty(userVerfiedText(whoIs())) && !isEqual($_GET['url'], 'LoanController/requirements')) :?>
          <div class="container-fluid">
            <div class="alert alert-warning">
              <div class="text-align-center">
                <p>Your account is not yet verified, Get Approved faster by Completing 
                  <a href="/LoanController/requirements"><?php echo WordLib::get('cashAdvance')?> requirements.</a>
                </p>
              </div>
            </div>
          </div>
        <?php endif?>

        <?php produce('content') ?>
        <!-- End of Topbar -->
      </div>
      <?php echo wDivider()?>
      <div style="background-color: #fff;">
            <p class="text-center" style="padding: 10px;">
                <span class="highlight">
                    <a href="<?php echo SITE_NAME?>"><?php echo COMPANY_NAME?></a></span> 
                Discover our 
                <span class="highlight">
                    <?php echo APP_NAME?> 
                </span>
            </p>
        </div>
      <!-- End of Content Wrapper -->
      </div>
      <!-- End of Page Wrapper -->
      <!-- Scroll to Top Button-->
      <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
      </a>
      <!-- Logout Modal-->
      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog rounded-0 modal-dialog-centered" role="document">
          <div class="modal-content rounded-0">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
              <button class="btn btn-secondary btn-sm rounded-0" type="button" data-dismiss="modal">Cancel</button>
              <a class="btn btn-primary btn-sm rounded-0" href="/users/logout"><i class="fa fa-sign-out-alt"></i> Logout</a>
            </div>
          </div>
        </div>
      </div>
      <!-- Bootstrap core JavaScript-->
      <script src="<?php echo _path_tmp('ui-main/vendor/jquery/jquery.min.js')?>"></script>
      <script src="<?php echo _path_tmp('ui-main/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
      <!-- Core plugin JavaScript-->
      <script src="<?php echo _path_tmp('ui-main/vendor/jquery-easing/jquery.easing.min.js')?>"></script>

      <!-- Custom scripts for all pages-->
      <script src="<?php echo _path_tmp('ui-main/js/sb-admin-2.min.js')?>"></script>

       <!-- Page level plugins -->
      <script src="<?php echo _path_tmp('ui-main/vendor/datatables/jquery.dataTables.min.js')?>"></script>
      <script src="<?php echo _path_tmp('ui-main/vendor/datatables/dataTables.bootstrap4.min.js')?>"></script>

      <script src="<?php echo URL?>/js/core/conf.js"></script>
      <script src="<?php echo URL?>/js/scripts.js"></script>
      <script src="<?php echo URL.DS?>/js/customs.js"></script>
      <script src="<?php echo URL.DS?>/js/core/global.js"></script>

      <script>
        $(document).ready(function(){
          $('#dataTable').DataTable();
          $('#dataTable').find('td').addClass('p-1 align-middle');
          $('#dataTable').find('td:nth-child(1)').addClass('text-center');
        });
      </script>
      <?php produce('scripts') ?>
      </body>
</html>