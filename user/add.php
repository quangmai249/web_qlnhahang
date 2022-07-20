<?php
	if (isset($_POST['add-row'])) {
		$username = $_POST['user_name'];
		if($listUser) {
			foreach($listUser as $key => $row) {
			  $row = (array) $row;
			  $u = $row['username'];
			  if($u == $username) {
				echo "<script type='text/javascript'>alert('User name is existed');</script>";
				return;
			  }
			}
		}
		$password = $_POST['password'];
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$role = $_POST['role'];

		$param = json_encode(array("username" => $username, "password" => $password, "name" => $name, "phone" => $phone, "address" => $address, "role" => $role));
		$url = "users.json";
		$data = callAPI("POST", $url, $param);
		if ($data != 200) {
			echo "<script type='text/javascript'>alert('Insert fail');</script>";
		}else{
			echo "<script type='text/javascript'>alert('Insert success');</script>";
			echo '<meta http-equiv="refresh" content="0">';
		}
	}
?>
<div id="insert" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Thêm quản trị</h4>
			</div>
			<div class="modal-body">
				<form method="post">
					<div class="form-group">
						<label>Tên đăng nhập</label> <input
							type="text" class="form-control add-control" name="user_name" required>
					</div>
					<div class="form-group">
						<label>Mật khẩu</label> <input
							type="password" class="form-control add-control" name="password" required>
					</div>
					<div class="form-group">
						<label>Họ tên</label> <input
							type="text" class="form-control add-control" name="name" required>
					</div>
					<div class="form-group">
						<label>Địa chỉ</label> <input
							type="text" class="form-control add-control" name="address" required>
					</div>
					<div class="form-group">
						<label>Số điện thoại</label> <input
							type="text" class="form-control add-control" name="phone" required>
					</div>
					<div class="form-group">
						<label>Quyền</label> 
						<select class="form-control add-control" style="height: 35px" name="role" required>
							<?php
								for($i = 0; $i < count($ROLE); $i++ ) {
									?>
										<option value="<?php echo $i?>"><?php echo $ROLE[$i]?></option>
									<?php
								}
							?>
						</select>
					</div>
					<div class="form-group" style="text-align: right;">
						<input type="submit" class="btn btn-primary" name="add-row" value="Ok"/>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>