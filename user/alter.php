<?php
	if (isset($_POST['submit-edit-row'])) {
		$key = $_POST['key'];
		$username = $_POST['user_name'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$role = $_POST['role'];

		$param = json_encode(array("username" => $username, "password" => $password, "name" => $name, "phone" => $phone, "address" => $address, "role" => $role));
		$url = "users/$key.json";
		$data = callAPI("PATCH", $url, $param);
		if ($data != 200) {
			echo "<script type='text/javascript'>alert('Update fail');</script>";
		}else{
			echo "<script type='text/javascript'>alert('Update success');</script>";
			echo '<meta http-equiv="refresh" content="0">';
		}
	}
?>
<div id="update-row" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Cập nhập quản trị</h4>
			</div>
			<div class="modal-body">
				<form method="post">
					<?php
						if(isset($_POST['edit'])){
							$id = $_POST['edit'];
							foreach($listUser as $key => $row) {
								if($key == $id) {
									$row = (array) $row;
									break;
								}
							}
					?>
					<div class="form-group">
						<input type="text" style="width:0px; height: 0px; display: none;" class="form-control add-control" value="<?php echo $id;?>" readonly="readonly" name="key" required>
						<label>Tên đăng nhập</label> <input
							type="text" class="form-control add-control" value="<?php echo $row['username'];?>" readonly="readonly" name="user_name" required>
					</div>
					<div class="form-group">
						<label>Mật khẩu</label> <input
							type="password" class="form-control add-control" value="<?php echo $row['password'];?>" name="password" required>
					</div>
					<div class="form-group">
						<label>Họ tên</label> <input
							type="text" class="form-control add-control" name="name" value="<?php echo $row['name'];?>" required>
					</div>
					<div class="form-group">
						<label>Địa chỉ</label> <input
							type="text" class="form-control add-control" name="address" value="<?php echo $row['address'];?>" required>
					</div>
					<div class="form-group">
						<label>Số điện thoại</label> <input
							type="text" class="form-control add-control" name="phone" value="<?php echo $row['phone'];?>" required>
					</div>
					<div class="form-group">
						<label>Quyền</label> 
						<select class="form-control add-control" style="height: 35px" name="role" required>
							<?php
								for($i = 0; $i < count($ROLE); $i++ ) {
									$selected = "";
									if($i == $row['role']) {
										$selected = "selected";
									}
									?>
										<option value="<?php echo $i?>" <?php echo $selected?>><?php echo $ROLE[$i]?></option>
									<?php
								}
							?>
						</select>
					</div>
					<div class="form-group" style="text-align: right;">
						<input type="submit" class="btn btn-primary" name="submit-edit-row" value="Ok"/>
					</div>
					<script type="text/javascript">
						$('#update-row').modal('show');
					</script>
					<?php 
						}
					?>
				</form>
			</div>
		</div>

	</div>
</div>