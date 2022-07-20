<?php
	if (isset($_POST['submit-edit-row'])) {
		$key = $_POST['key'];
		$name = $_POST['name'];
		$room = $_POST['room'];
		$param = json_encode(array("name" => $name, "room" => $room));
		$url = "table/$key.json";
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
				<h4 class="modal-title">Cập nhập bàn</h4>
			</div>
			<div class="modal-body">
				<form method="post">
					<?php
						if(isset($_POST['edit'])){
							$id = $_POST['edit'];
							foreach($listItem as $key => $row) {
								if($key == $id) {
									$row = (array) $row;
									break;
								}
							}
					?>
					<div class="form-group">
						<input type="text" style="width:0px; height: 0px; display: none;" class="form-control add-control" value="<?php echo $id;?>" readonly="readonly" name="key" required>
						<label>Số bàn</label> <input
							type="text" class="form-control add-control" name="name" value="<?php echo $row['name'];?>" required>
					</div>
					<div class="form-group">
						<label>Phòng</label> <input
							type="text" class="form-control add-control" name="room" value="<?php echo $row['room'];?>" required>
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