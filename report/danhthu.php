<div class="table-responsive">
    <table class="table">
    <thead class="text-primary">
        <th style="font-size: 15pt;">
            Hóa đơn
        </th>
        <th style="font-size: 15pt">
            Tổng tiền
        </th>
    </thead>
    <tbody>
        <?php
            $url="order.json";
            $orders = (array) callAPI("GET", $url);
            $total = 0;
            foreach($orders as $key => $listOrder) {
                foreach($listOrder as $keyRD => $rowRD) {
                    $rowRD = (array) $rowRD;
                    $date = date('Y-m-d', $rowRD['id']/1000);
                    if($date >= $timeF && $date <= $timeT) {
                        $id = $rowRD['id'];
                        if($rowRD['status'] == 1) {
                            $sum = 0;
                            $id = "";
                            $items = (array) $rowRD['items'];
                            foreach($items as $keyItem => $item) {
                                $itemOrder = (array) $item;
                                $count = $itemOrder['count'];
                                $price = $itemOrder['price'];
                                $status = $itemOrder['status'];
                                if($status != -1) {
                                    $sum += $price * $count;
                                }
                            }
                            $total += $sum;
                            ?>
                                <tr>
                                    <td>
                                    <?php echo $rowRD['id'];?>
                                    </td>
                                    <td>
                                    <?php echo formatPrice($sum);?>
                                    </td>
                                </tr>
                            <?php    
                        }
                    }
                }
            }
        ?>
    </tbody>
    </table>
    <div class="form-group" style="text-align: right;">
        <h4>
        Tổng tiền: <?php echo formatPrice($total);?>
        </h4>
    </div>
</div>

