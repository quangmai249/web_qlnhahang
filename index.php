<?php
include('header.php');
$page = 'request';
if (isset($_GET['page'])) {
  $page = $_GET['page'];
}
?>
<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple">
      <div class="logo" style="background: #fff">
        <a href="/<?php echo $root_host?>" class="simple-text logo-normal">
          <?php
          echo $_SESSION['name'];
          ?>
        </a>
      </div>
      <div class="sidebar-wrapper" style="background: #fff">
        <ul class="nav">
          <?php
          include('menu.php');
          ?>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <h2>
            <?php
              switch($page) {
                case 'user': echo "Quản lý nhân viên";
                break;
                case 'table': echo "Quản lý bàn";
                break;
                case 'group': echo "Quản lý danh mục";
                break;
                case 'group': echo "Quản lý danh mục";
                break;
                case 'request': echo "Quản lý đơn đặt";
                break;
                case 'bill': echo "Quản lý hóa đơn";
                break;
                case 'report': echo "Quản lý thống kê";
                break;
                default : echo "Quản lý món ăn";
                break;
              }
            ?>
          </h2>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <!-- <div class="collapse navbar-collapse justify-content-end">
            <form class="navbar-form" method="post">
              <div class="input-group no-border">
                <input type="text" value="<?php echo $key?>" name="key" class="input-search form-control" placeholder="Search...">
                <button type="submit" style="margin-left: 10px; background-color: #8e24aa; color: white" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form>
          </div> -->
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">

          <div class="card">
            <div>
              <?php
              switch ($page) {
                case 'guess':
                case 'bill':
                case 'request':
                case 'report':
                break;
                default:
                echo "<button type='button' id='add' class='card-header-primary btn' data-toggle='modal' data-target='#insert'>Add</button>";
                break;
              }
              ?>
            </div>
            <div class="card-body">
              <?php
              switch ($page) {
                case 'user':
                include("user/index.php");
                break;
                case 'table':
                  include("table/index.php");
                  break;
                case 'group':
                include("group/index.php");
                break;
                case 'request':
                include("request/index.php");
                break;
                case 'bill':
                  include("bill/index.php");
                break;
                case 'report':
                  include("report/index.php");
                break;
                default:
                include("item/index.php");
                break;
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <?php
        //include('footer.php');
      ?>
    </div>
  </div>
</div>
</body>
</html>
