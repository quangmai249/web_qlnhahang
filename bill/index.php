<!DOCTYPE html>
<html>
<body>

<?php
    $url="item.json";
    $listItem = (array) callAPI("GET", $url);
    $url="users.json";
    $listUser = (array) callAPI("GET", $url);
    $url="order.json";
    $orders = (array) callAPI("GET", $url);
    $url="table.json";
	$listTable = (array)callAPI("GET", $url);
	foreach($orders as $key => $listOrder) {
		$name = ((array)$listTable[$key])['name'];
        $room = ((array)$listTable[$key])['room'];
        $name = 'Phòng '. $room.' Bàn '. $name;
          foreach($listOrder as $keyRD => $rowRD) {
            $rowRD = (array) $rowRD;
              if($rowRD['status'] == 1) {
                // get waiter info
                $waiter = $rowRD['waiter'];
                $keyWaiter = $waiter;
                $waiter = (array) $listUser[$waiter];
                echo '<h3>'.$name.'</h3>';
                echo '<h3>Phục vụ: '.$waiter['name'].'</h3>';
                echo '<h3>Mã hóa đơn: '.$rowRD['id'].'</h3>';
                echo '<h3>Ngày tạo: '.date( "h:i d/m/Y", $rowRD['id'] / 1000).'</h3>';
                $sum = 0;
                // get item info
                ?>
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-primary">
                        <th style="font-size: 15pt;">
                          Tên sản phẩm
                        </th>
                        <th style="font-size: 15pt">
                          Số lượng
                        </th>
                        <th style="font-size: 15pt">
                          Giá
                        </th>
                      </thead>
                      <tbody>
                        <?php
                          $items = (array) $rowRD['items'];
                          foreach($items as $keyItem => $item) {
                            $itemOrder = (array) $item;
                            $itemId = $itemOrder['id'];
                            // $itemGroup = $itemOrder['group'];
                            // $itemGroup = (array)$listItem[$itemGroup];
                            // $item = (array)$itemGroup[$itemId];
                            $path = "order/$key/$keyRD/items/$keyItem.json";
                            $count = $itemOrder['count'];
                            $price = $itemOrder['price'];
                            $status = $itemOrder['status'];
                            $note = isset($itemOrder['note']) ? $itemOrder['note'] : "-";
                            if(isset($itemOrder['reason'])) {
                              $reason = $itemOrder['reason'];
                            } else {
                              $reason = "-";
                            }
                            if($status != -1) {
                              $sum += $price * $count;
                            }
                            render_row($path, (array)$item, $count, $price);
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                  <form method="post">
                    <div class="form-group" style="text-align: right;">
                      <h4>
                        Tổng tiền: <?php echo formatPrice($sum);?>
                      </h4>
                    </div>
                  </form>
                <?php
              }
          }
	}

  function render_row($key, $row, $count, $price){
    $name = $row['name'];
    $image = $row['images'][0];
    $price = formatPrice($price);
    echo "<tr>
            <td>
              $name
            </td>
            <td>
              $count
            </td>
            <td>
              $price
            </td>
          </tr>";
  }
?>
</body>
</html>