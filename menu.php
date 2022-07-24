<?php
  $role = $_SESSION['role'];
  if($role == 0) {
    ?>
      <li class="nav-item <?php if($page == 'user') echo 'active' ?>">
          <a class="nav-link" href="?page=user">
            <i class="material-icons">person</i>
            <p>Quản trị</p>
          </a>
      </li>
      <li class="nav-item <?php if($page == 'table') echo 'active' ?>">
        <a class="nav-link" href="?page=table">
          <i class="material-icons">group</i>
          <p>Bàn</p>
        </a>
      </li>
      <li class="nav-item <?php if($page == 'group') echo 'active' ?>">
        <a class="nav-link" href="?page=group">
          <i class="material-icons">group</i>
          <p>Danh mục</p>
        </a>
      </li>

      <button style="border: none; outline: none" class="collapsible">
        <i class="material-icons">group</i>
        <p>Món ăn</p>
      </button>
      <div class="content-menu" style="padding: 0px">
        <?php
              $url="group.json";
              $listItemGroup = callAPI("GET", $url);
              if($listItemGroup) {
                foreach($listItemGroup as $key => $row) {
                  $row = (array) $row;
                  $name = $row['name'];
                  ?>
              <li class="nav-item <?php if($page == $key) echo 'active' ?>">
                <a class="nav-link" href="?page=<?php echo $key?>">
                  <p style="margin-left: 48px"><?php echo $name;?></p>
                </a>
              </li>
            <?php
                }
              }
          ?>
      </div>
    <?php
  }
?>
<li class="nav-item <?php if($page == 'request') echo 'active' ?>">
	<a class="nav-link" href="?page=request">
		<i class="material-icons">group</i>
		<p>Đơn đặt</p>
	</a>
</li>
<?php
  if($role == 0) {
    ?>
      <li >
        <a class="nav-link" >
          <i class="material-icons">group</i>
          <p>Thống kê</p>
        </a>
        <li class="nav-item <?php if($page == $key) echo 'active' ?>">
          <a class="nav-link" href="?page=report-count">
            <p style="margin-left: 48px">Thống kê doanh thu</p>
          </a>
        </li>
        <li class="nav-item <?php if($page == $key) echo 'active' ?>">
          <a class="nav-link" href="?page=report-amount">
            <p style="margin-left: 48px">Thống kê sản phẩm</p>
          </a>
        </li>
      </li>
    <?php
  }
?>
<li class="nav-item">
	<a class="nav-link" href="login.php?logout=logout">
		<i class="material-icons">exit_to_app</i>
		<p>Đăng xuất</p>
	</a>
</li>

<style>
.collapsible {
  background: #fff;
  cursor: pointer;
  padding: 10px 14px 10px 14px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
}

.collapsible:hover {
  background-color: #eee;
}

.content-menu {
  padding: 0px;
  /* display: none; */
  /* overflow: hidden; */
  background-color: #f1f1f1;
}
</style>

<!-- <script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script> -->