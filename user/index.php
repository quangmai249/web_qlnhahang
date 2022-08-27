<?php
  if (isset($_POST['delete'])) {
    $id = $_POST['delete'];
    $url = "users/".$id."/.json";

		$data = callAPI("DELETE", $url);
		if ($data != 200) {
			echo "<script type='text/javascript'>alert('Delete fail');</script>";
		}else{
			echo "<script type='text/javascript'>alert('Delete success');</script>";
			echo '<meta http-equiv="refresh" content="0">';
		}
  }
  $r = "";
  if(isset($_POST['role'])) {
    $r = $_POST['role'];
  }
  function user_rows($key, $user_name, $pass, $name, $phone, $address, $role){
    echo "<tr>
            <td>
              $user_name
            </td>
            <td>
              $name
            </td>
            <td>
              $phone
            </td>
            <td>
              $address
            </td>
            <td>
              $role
            </td>
            <td>
              <form method='post'>
                <button type='submit' class='btn-control' class='btn-control' name='edit' value='$key'><i class='fa fa-edit'></i></button>
                <button type='submit' class='btn-control' class='btn-control' name='delete' value='$key'><i class='fa fa-trash'></i></button>
            </form>
            </td>
          </tr>";
  }
?>

<form id="report" method="post">
	<div id="material-tabs" style="padding-bottom: 10px">
	    <div class="btn-report" style="background-color: white; height: 50px; padding: 0x; text-align: left">
			<label>Loại tài khoản</label> 
			<select class="form-control add-control" style="height: 35px" name="role" required>
        <?php
          for($i = 0; $i < count($ROLE); $i++ ) {
            ?>
              <?php
								for($i = 0; $i < count($ROLE); $i++ ) {
									$selected = "";
									if($i == $r) {
										$selected = "selected";
									}
									?>
										<option value="<?php echo $i?>" <?php echo $selected?>><?php echo $ROLE[$i]?></option>
									<?php
								}
							?>
            <?php
          }
        ?>
      </select>
		</div>
		<button type='submit' name="filter" class='btn-report' style="height: 50px; padding: 0px; margin-left: 30px; width: 200px">Tìm kiếm</button>"
	</div>
	<div class="report-div">
	<div class="table-responsive">
  <table class="table table-hover">
    <thead class="text-primary">
      <th style="font-size: 15pt">
        Tên đăng nhập
      </th>
      <th style="font-size: 15pt">
        Họ tên
      </th>
      <th style="font-size: 15pt">
        Số điện thoại
      </th>
      <th style="font-size: 15pt">
        Địa chỉ
      </th>
      <th style="font-size: 15pt">
        Quyền
      </th>
      <!-- <th style="font-size: 15pt">
        Mật khẩu
      </th> -->
      <th width="100px"></th>
    </thead>
    <tbody>
      <?php
        $url="users.json";
        $listUser = callAPI("GET", $url);
        if($listUser) {
          foreach($listUser as $key => $row) {
            $row = (array) $row;
            $role = $row['role'];
            if($role != $r && $r != "") continue;
            $username = $row['username'];
            $password = $row['password'];
            $name = $row['name'];
            $phone = $row['phone'];
            $address = $row['address'];
            $role = $ROLE[$row['role']];
            user_rows($key, $username, $password, $name, $phone, $address,$role);
          }
        }
      ?>
    </tbody>
  </table>
</div>
	</div>
</form>
<?php
  include("add.php");
  include("alter.php");
?>