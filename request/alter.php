<?php
	if (isset($_POST['submit-edit-row'])) {
		$path = $_POST['path'];
		$count = (int)$_POST['count'] - 1;
		$reason = $_POST['reason'];
		$param = json_encode(array("count" => $count, "reason" => $reason));
		$data = callAPI("PATCH", $path, $param);
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
				<h4 class="modal-title">Chỉnh sửa số lượng</h4>
			</div>
			<div class="modal-body">
				<form method="post">
					<?php
						if(isset($_POST['remove'])){
							$id = $_POST['remove'];
							$count = $_POST['count'];
					?>
                    <input type="hidden" class="form-control add-control" name="path" value="<?php echo $id;?>" required>
					<input type="hidden" class="form-control add-control" name="count" value="<?php echo $count;?>" required>
                    <div class="form-group">
						<label>Lý do</label> <input
							type="text" class="form-control add-control" name="reason" required>
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