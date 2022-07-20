<?php
  if (isset($_POST['delete'])) {
    $id = $_POST['delete'];
    $url = "group/".$id."/.json";

		$data = callAPI("DELETE", $url);
		if ($data != 200) {
			echo "<script type='text/javascript'>alert('Delete fail');</script>";
		}else{
			echo "<script type='text/javascript'>alert('Delete success');</script>";
			echo '<meta http-equiv="refresh" content="0">';
		}
  }
  function user_rows($key,$name){
    echo "<tr>
            <td>
              $name
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
        Tên danh mục
      </th>
      <th width="100px"></th>
    </thead>
    <tbody>
      <?php
        $url="group.json";
        $listItem = callAPI("GET", $url);
        if($listItem) {
          foreach($listItem as $key => $row) {
            $row = (array) $row;
            $name = $row['name'];
            user_rows($key,$name);
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