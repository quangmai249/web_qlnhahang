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
<?php
  include("add.php");
  include("alter.php");
?>