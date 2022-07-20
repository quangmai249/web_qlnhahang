<script language="javascript" src="ckeditor/ckeditor.js"></script>
<?php
  $page = $_GET['page'];
  if (isset($_POST['delete'])) {
    $id = $_POST['delete'];
    $url = "item/$page/$id/.json";

		$data = callAPI("DELETE", $url);
		if ($data != 200) {
			echo "<script type='text/javascript'>alert('Delete fail');</script>";
		}else{
			echo "<script type='text/javascript'>alert('Delete success');</script>";
			echo '<meta http-equiv="refresh" content="0">';
		}
  }
  function render_row($key, $row){
    $image = $row['images'][0];
    $name = $row['name'];
    $available = $row['available'];
    $price = formatPrice($row['price']);
    echo "<tr>
            <td style=width:150px>
              <img  width=100 height=100 src='$image'>
            </td>
            <td>
              $name
            </td>
            <td>
              $available
            </td>
            <td>
              $price
            </td>
            <td>
              <form method='post'>
                <button type='submit' class='btn-control' name='edit' value='$key'><i class='fa fa-edit'></i></button>
                <button type='submit' class='btn-control' name='delete' value='$key'><i class='fa fa-trash'></i></button>
            </form>
            </td>
          </tr>";
  }
?>
<div class="table-responsive">
  <table class="table">
    <thead class="text-primary">
      <th style="font-size: 15pt;">
        Hình ảnh
      </th>
      <th style="font-size: 15pt;">
        Tên sản phẩm
      </th>
      <th style="font-size: 15pt">
        Trạng thái
      </th>
      <th style="font-size: 15pt">
        Giá
      </th>
      <th width="100px"></th>
    </thead>
    <tbody>
      <?php
        $url="item/$page/.json";
        $listItem = callAPI("GET", $url);
        if($listItem) {
          foreach($listItem as $key => $row) {
            $row = (array) $row;
            render_row($key, $row);
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