<?php
$timeF = "";
$timeT = "";
$isCount = !isset($_POST['report-money']);

if (isset($_POST['time-from'])) {
    $timeF = $_POST['time-from'];
}
if (isset($_POST['time-to'])) {
    $timeT = $_POST['time-to'];
}
$total = 0;
?>

<form id="report" method="post">
	<div id="material-tabs" style="padding-bottom: 10px">
	    <div class="btn-report" style="background-color: white; height: 50px; padding: 0x;">
			<label>Thời gian bắt đầu</label>
			<input type="date" class="form-control add-control" value="<?php echo $timeF ?>" name="time-from">
		</div>
		<div class="btn-report" style="background-color: white; height: 50px; padding: 0x;">
			<label>Thời gian kết thúc</label>
			<input type="date" class="form-control" value="<?php echo $timeT ?>" name="time-to">
		</div>
		<button type='submit' name="report" class='btn-report' style="height: 50px; padding: 0px; margin-left: 12px; width: 200px">Thống kê doanh số</button>"
		<button type='submit' name="report-money" class='btn-report' style="height: 50px; padding: 0px; margin-left: 30px; width: 200px">Thống kê doanh thu</button>"
	</div>
	<div class="report-div">
	<?php
if ($isCount) {
    include "sl.php";
} else {
    include "danhthu.php";
}
?>
	</div>
</form>