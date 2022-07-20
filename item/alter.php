<?php
if (isset($_POST['submit-edit-row'])) {
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $available = $_POST['available'];
    $id = $_POST['id'];
    $images = array();
    if (isset($_FILES['images'])){
        $myFile = $_FILES['images'];
        $fileCount = count($myFile["name"]);
        for ($i = 0; $i < $fileCount; $i++) {
            if($myFile['name'][$i]) {
                $uploadfile = 'img/item/'.$myFile['name'][$i];
                move_uploaded_file($myFile['tmp_name'][$i], $uploadfile);
                $images[] = $uploadfile;
            }
        }
    }

    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    if(count($images) > 0) {
        $param = json_encode(array("name" => $name, "desc" => $desc, "price" => $price, "images" => $images, "available" => $available));
    } else {
        $param = json_encode(array("name" => $name, "desc" => $desc, "price" => $price, "available" => $available));
    }
    $url = "item/$page/$id/.json";

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
                <h4 class="modal-title">Sửa thông tin sản phẩm</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
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
                        <label>Mã sản phẩm</label> <input
                        type="text" maxlength="100" class="form-control add-control" value="<?php echo $id?>" name="id" readOnly>
                    </div>
                    <div class="form-group">
                        <label>Tên sản phẩm</label> <input
                        type="text" maxlength="100" class="form-control add-control" value="<?php echo $row['name']?>" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Giá</label>
                        <br/>
                        <input type="number" class="form-control add-control" value="<?php echo $row['price']?>" required name="price">
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <br/>
                        <textarea name="desc"  id="edit-content"><?php echo $row['desc']?></textarea>
                        <script type="text/javascript">CKEDITOR.replace('edit-content'); </script>
                    </div>

                    <div class="form-group">
                        <label>Trạng thái</label>
                        <br/>
                        <select name="available" class="form-control add-control" style="height:35px">
                            <option value="Có sẵn" <?php if($row['available'] == "Có sẵn") echo "selected"?>>Có sẵn</option>
                            <option value="Hết hàng" <?php if($row['available'] == "Hết hàng") echo "selected"?>>Hết hàng</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Hình ảnh</label>
                    </div>
                    <input accept="image/*" type="file" name="images[]" multiple />

                    <div class="form-group" style="text-align: right;">
                        <input type="submit" class="btn btn-primary" name="submit-edit-row" value="Ok"/>
                    </div>
                    <script type="text/javascript">
                      $('#update-row').modal('show');
                  </script>
              </form>
              <?php 
          }
          ?>
      </div>
  </div>

</div>
</div>