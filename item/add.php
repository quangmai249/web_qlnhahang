<?php
if (isset($_POST['add-row'])) {
    $images = array();
    if (isset($_FILES['images'])){
        $myFile = $_FILES['images'];
        $fileCount = count($myFile["name"]);
        for ($i = 0; $i < $fileCount; $i++) {
            $uploadfile = 'img/item/'.$myFile['name'][$i];
            move_uploaded_file($myFile['tmp_name'][$i], $uploadfile);
            $images[] = $uploadfile;
        }
    }

    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $param = json_encode(array("name" => $name, "desc" => $desc, "price" => $price, "group" => $page, "images" => $images, "available" => "Có sẵn"));
    $url = "item/$page/.json";
    $data = callAPI("POST", $url, $param);
    if ($data != 200) {
        echo "<script type='text/javascript'>alert('Insert fail');</script>";
    }else{
        echo "<script type='text/javascript'>alert('Insert success');</script>";
        echo '<meta http-equiv="refresh" content="0">';
    }
}
?>
<div id="insert" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm sản phẩm</h4>
            </div>
            <div class="modal-body">
                <form id="fr-add-alphabet" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Tên sản phẩm</label> <input
                        type="text" maxlength="100" class="form-control add-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Giá</label>
                        <br/>
                        <input type="number" class="form-control add-control" required name="price">
                    </div>
                    <div class="form-group">
                        <label>Mô tả</label>
                        <br/>
                        <textarea name="desc"  id="content"></textarea>
                        <script type="text/javascript">CKEDITOR.replace('content'); </script>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                    </div>
                    <input accept="image/*" type="file" name="images[]" multiple required />
                    <div class="form-group" style="text-align: right;">
                        <input type="submit" class="btn btn-primary" name="add-row" value="Ok"/>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>