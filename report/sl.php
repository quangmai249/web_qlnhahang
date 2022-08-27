<div class="table-responsive">
    <table class="table">
    <thead class="text-primary">
        <th style="font-size: 15pt;">
        Tên sản phẩm
        </th>
        <th style="font-size: 15pt">
            Số lượng
        </th>
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
                    </tr>
                <?php
            }
        ?>
    </tbody>
    </table>
</div>