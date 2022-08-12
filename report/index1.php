<?php
	$timeF = "";
    $timeT = "";
    if (isset($_POST['time-from'])) {
        $timeF = $_POST['time-from'];
    }
    if (isset($_POST['time-to'])) {
        $timeT = $_POST['time-to'];
    }
	$total = 0;
?>

<form id="report-amount" method="post">
	<div id="material-tabs">
	    <!-- <section class="report-group">
			<label>Thời gian bắt đầu</label> <label>Thời gian kết thúc</label> 
			<input type="date" class="form-control add-control" value="<?php echo $timeF?>" name="time-from">
			
			<input type="date" class="form-control" value="<?php echo $timeT?>" name="time-to">
		</section>
		<section class="report-group">
			
		</section> -->
		<table >
			<tr>
				<th class = 'th-control'><label>Thời gian bắt đầu</label>  </th>
				<th class = 'th-control'><label>Thời gian kết thúc</label></th>
				
			</tr>
			<tr>
				<td><input type="date" class="form-control add-control" value="<?php echo $timeF?>" name="time-from"></td>
				<td><input type="date" class="form-control" value="<?php echo $timeT?>" name="time-to"></td>
				<td><button type='submit' name="report" class='btn-report'>Thống kê</button></td>
			</tr>
		</table>
		
	</div>
	<div class="report-div">
	<div class="table-responsive">
		<table class="table">
		<thead class="text-primary">
			<th style="font-size: 15pt;">
			Tên sản phẩm
			</th>
			<th style="font-size: 15pt">
			Số lượng
			</th>
			<!-- <th style="font-size: 15pt">
			Đơn giá
			</th>
			<th style="font-size: 15pt">
			Tổng giá
			</th> -->
		</thead>
		<tbody>
			<?php
				$url="order.json";
				$listOrder = (array) callAPI("GET", $url);

				$countItem = array();
				$itemsObj = array();
				foreach($listOrder as $keyItem => $orders) {
					$orders = (array) $orders;
					foreach($orders as $keyOrder => $order) {
						$order = (array) $order;
						$date = date('Y-m-d', $order['id']/1000);
						if($date >= $timeF && $date <= $timeT) {
							$items = (array) $order['items'];
							foreach ($items as $i) {
								$i = (array) $i;
								$itemsObj[$i['id']] = $i;
								$countItem[$i['id']] = (isset($countItem[$i['id']]) == true ? $countItem[$i['id']] : 0) + $i['count'];
							}
						}
					}
				}

				arsort($countItem);

				foreach($countItem as $key => $count) {
					$item = (array) $itemsObj[$key];
					$total += $count * $item['price'];
					?>
						<tr>
							<td>
							<?php echo $item['name'];?>
							</td>
							<td>
							<?php echo $count;?>
							</td>
							<td>
							<!-- <?php echo formatPrice($item['price']);?>
							</td>
							<td>
							<?php echo formatPrice($count * $item['price']);?>
							</td> -->
						</tr>
					<?php
				}
			?>
		</tbody>
		</table>
	</div>
	<!-- <h4>Tổng thu nhập: <?php echo formatPrice($total)?></h4> -->
	</div>
</form>