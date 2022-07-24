<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.collapsible-order {
  background-color: #ccc;
  color: black;
  cursor: pointer;
  padding: 10px 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none !important;
  font-size: 15px;
}

.active, .collapsible-order:hover {
  background-color: #ccc;
}

.content-order {
  padding: 0 18px;
  /* display: none; */
  overflow: hidden;
  background-color: #f1f1f1;
}
</style>
<script>
  // Initialize Firebase
  var config = {
    apiKey: "AIzaSyAfX29iF39W6ASS8FSrEHqMzjc7G9OYJ9c",
    authDomain: "ql-nha-hang-3475b.firebaseapp.com",
    databaseURL: "https://ql-nha-hang-3475b-default-rtdb.firebaseio.com",
    projectId: "ql-nha-hang-3475b",
    storageBucket: "ql-nha-hang-3475b.appspot.com",
    messagingSenderId: "24031695094",
    appId: "1:24031695094:web:f2608abed7fe64096d1cd7",
    measurementId: "G-BJ3E035D6L"
  };
  var change = 0;
  firebase.initializeApp(config);
  firebase.database().ref('order').on('value', function(dataSnapshot) {
    change += 1;
    if(change > 1) {
      document.getElementById('notify').style.display = 'block';
    }
  });
</script>

</head>
<body>

<div id="notify" style="display: none" class="alert alert-primary" role="alert">
  <h4>Có thay đổi mới vui lòng load lại trang<h4>
</div>

<?php
  if (isset($_POST['pay'])) {
    $url = $_POST['pay'];
    $token = $_POST['token'];
    $item = $_POST['item'];
    $waiter = $_POST['waiter'];
    $table = $_POST['table'];
    $date = date("d/m/Y H:i");
    $param = json_encode(array("waiter" => $waiter, "message" => $item, "date" => $date));
    $data = callAPI("POST", "notify.json", $param);

    $param = json_encode(array("status" => 1));
		$data = callAPI("PATCH", $url, $param);
    if ($data != 200) {
      echo "<script type='text/javascript'>alert('Thanh toán thất bại');</script>";
    }else{
      sentNotify($token, $item);
      echo "<script type='text/javascript'>alert('Thanh toán thành công');</script>";
      echo '<meta http-equiv="refresh" content="0">';
    }
  } if (isset($_POST['reject'])) {
    $url = $_POST['reject'];
    $token = $_POST['token'];
    $item = $_POST['item'].' đã bị từ chối';
    $waiter = $_POST['waiter'];
    $table = $_POST['table'];
    $date = date("d/m/Y H:i");
    $param = json_encode(array("waiter" => $waiter, "message" => $item, "date" => $date));
    $data = callAPI("POST", "notify.json", $param);

    $param = json_encode(array("status" => -1));
		$data = callAPI("PATCH", $url, $param);
    if ($data != 200) {
      echo "<script type='text/javascript'>alert('Update fail');</script>";
    }else{
      sentNotify($token, $item);
      echo "<script type='text/javascript'>alert('Update success');</script>";
      echo '<meta http-equiv="refresh" content="0">';
    }
  } else if (isset($_POST['confirm'])) {
    $url = $_POST['confirm'];
    $token = $_POST['token'];
    $item = $_POST['item'].' đã được xác nhận';
    $waiter = $_POST['waiter'];
    $table = $_POST['table'];
    $date = date("d/m/Y H:i");
    $param = json_encode(array("waiter" => $waiter, "message" => $item, "date" => $date));
    $data = callAPI("POST", "notify.json", $param);

    $param = json_encode(array("status" => 1));
		$data = callAPI("PATCH", $url, $param);
    if ($data != 200) {
      echo "<script type='text/javascript'>alert('Update fail');</script>";
    }else{
      sentNotify($token, $item);
      echo "<script type='text/javascript'>alert('Update success');</script>";
      echo '<meta http-equiv="refresh" content="0">';
    }
  } else if (isset($_POST['done'])) {
    $url = $_POST['done'];
    $token = $_POST['token'];
    $item = $_POST['item'].' đã chế biến xong';
    $waiter = $_POST['waiter'];
    $table = $_POST['table'];
    $date = date("d/m/Y H:i");
    $param = json_encode(array("waiter" => $waiter, "message" => $item, "date" => $date));
    $data = callAPI("POST", "notify.json", $param);

    $param = json_encode(array("status" => 2));
		$data = callAPI("PATCH", $url, $param);
    if ($data != 200) {
      echo "<script type='text/javascript'>alert('Update fail');</script>";
    }else{
      sentNotify($token, $item);
      echo "<script type='text/javascript'>alert('Update success');</script>";
      echo '<meta http-equiv="refresh" content="0">';
    }
  }
  
  $url="item.json";
  $listItem = (array) callAPI("GET", $url);
  $url="users.json";
  $listUser = (array) callAPI("GET", $url);
	$url="order.json";
	$listOrder = (array) callAPI("GET", $url);
  $url="table.json";
	$listTable = callAPI("GET", $url);
	if($listTable) {
	  foreach($listTable as $key => $row) {
		$row = (array) $row;
    $sum = 0;
		$name = $row['name'];
    $room = $row['room'];
    $name = 'Phòng '. $room.' Bàn '. $name
		?>
			<button type="button" class="collapsible-order"><?php echo $name?></button>
			<div class="content-order">
        <?php
          if(isset($listOrder[$key])) {
            foreach($listOrder[$key] as $keyRD => $rowRD) {
              $rowRD = (array) $rowRD;
                if($rowRD['status'] == 0) {
                  // get waiter info
                  $waiter = $rowRD['waiter'];
                  $keyWaiter = $waiter;
                  $waiter = (array) $listUser[$waiter];
                  echo '<h3>Phục vụ: '.$waiter['name'].'</h3>';
                  if($role == 0) {
                    $token = $waiter['token'];
                    
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
                          <th style="font-size: 15pt">
                            Trạng thái
                          </th>
                          <th style="font-size: 15pt">
                            Ghi chú
                          </th>
                          <th style="font-size: 15pt">
                            Lý do giảm
                          </th>
                          <th width="100px"></th>
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
                              //render_row($path, (array)$item, $count, $price, $status, $role, $waiter['token'], $name, $keyWaiter, $reason, $note);
                              render_row($path, (array)$item, $count, $price, $status, $role, $waiter['token'], $name, $keyWaiter, $reason, $note);
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
                        <?php
                          ?>
                          <input type='hidden' name='item' value='Hóa đơn tại <?php echo $name;?> đã được thanh toán'>
                          <input type='hidden' name='waiter' value='<?php echo $keyWaiter;?>'>
                          <input type='hidden' name='table' value='<?php echo $name;?>'>
                          <input type='hidden' name='token' value='<?php echo $token;?>'>
                          <button type="submit" class="btn btn-primary" name="pay" value="<?php echo "order/$key/$keyRD.json"?>">
                            Thanh toán
                          </button>
                          <a class="btn btn-primary" href="report/bill.php?id=<?php echo "order/$key/$keyRD.json"?>&table=<?php echo $name?>" target="_blank">Hóa đơn</a>
                        <?php
                          
                        ?>
                        
                        
                      </div>
                    </form>
                  <?php
                    
                  }
                  // get item info
                  if($role == 1) {
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
                            <!-- <th style="font-size: 15pt">
                              Giá
                            </th> -->
                            <th style="font-size: 15pt">
                              Trạng thái
                            </th>
                            <th style="font-size: 15pt">
                              Ghi chú
                            </th>
                            <th style="font-size: 15pt">
                              Lý do giảm
                            </th>
                            <th width="100px"></th>
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
                                //render_row($path, (array)$item, $count, $price, $status, $role, $waiter['token'], $name, $keyWaiter, $reason, $note);
                                render_row($path, (array)$item, $count, $price, $status, $role, $waiter['token'], $name, $keyWaiter, $reason, $note);
                              }
                            ?>
                          </tbody>
                        </table>
                      </div>
                      <form method="post">
                        <div class="form-group" style="text-align: right;">
                          <!-- <h4>
                            Tổng tiền: <?php echo formatPrice($sum);?>
                          </h4> -->
                          <?php
                          ?>
                          
                        </div>
                      </form>
                    <?php
                  }
                }
            }
          }
          
        ?>
			</div>
		<?php
	  }
	}

  function render_row($key, $row, $count, $price, $status, $role, $token, $table, $waiter, $reason, $note){
    $name = $row['name'];
    $msg = $name . ' tại '.$table;
    $image = $row['images'][0];
    $price = formatPrice($price);
    $controll = "";
    if($role == 1) {
      if($status == 0) {
        $controll = "
                  <button type='submit' class='btn-control' name='confirm' value='$key'><i class='fa fa-check'></i></button>
                  <button type='submit' class='btn-control' name='reject' value='$key'><i class='fa fa-trash'></i></button>
                  ";
        if($count > 1) {
          $controll = "<button type='submit' class='btn-control' name='remove' value='$key'><i class='fa fa-window-minimize'></i></button>". $controll;
        }
      } else if($status == 1) {
        $controll = "<button type='submit' class='btn-control' name='done' value='$key'><i class='fa fa-cutlery'></i></button>";
      }
    }
    $status = getStatusActionOrder($status);
    if($role == 1){
      echo "<tr style=font-size: 25pt>
            <td >
              $name
            </td>
            <td>
              $count
            </td>
            
            <td>
              $status
            </td>
            <td>
              $note
            </td>
            <td>
              $reason
            </td>
            <td>
              <form method='post'>
                <input type='hidden' name='count' value='$count'>
                <input type='hidden' name='item' value='$msg'>
                <input type='hidden' name='waiter' value='$waiter'>
                <input type='hidden' name='table' value='$table'>
                <input type='hidden' name='token' value='$token'>
                $controll
              </form>
            </td>
          </tr>";
    }
    else{
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
            <td>
              $status
            </td>
            <td>
              $note
            </td>
            <td>
              $reason
            </td>
            <td>
              <form method='post'>
                <input type='hidden' name='count' value='$count'>
                <input type='hidden' name='item' value='$msg'>
                <input type='hidden' name='waiter' value='$waiter'>
                <input type='hidden' name='table' value='$table'>
                <input type='hidden' name='token' value='$token'>
                $controll
              </form>
            </td>
          </tr>";
    }
    
  }
?>

<script>
var coll = document.getElementsByClassName("collapsible-order");
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
</script>

</body>
</html>
<?php
  include "alter.php";
?>