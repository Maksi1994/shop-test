<section class="d-block px-3 mt-5">
    <table class="table table-sm">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Date</th>
            <th scope="col">Status</th>
            <th scope="col">Customer Name</th>
            <th scope="col">Customer Email</th>
            <th scope="col">Count Products</th>
            <th scope="col">Full Price</th>
            <th scope="col">Edit</th>
        </tr>
        </thead>
        <tbody>
        <?foreach (self::$data['list'] as $listIndex => $item) {?>
            <tr>
                <td><?=(self::$data['page'] - 1) > 0 ? ((self::$data['page'] - 1) * 10) + ++$listIndex : ++$listIndex?></td>
                <td><?=date('D, d M Y H:i', $item['ts_create'])?></td>
                <td><?=$item['curr_status']?></td>
                <td><?=$item['customer_name']?></td>
                <td><?=$item['customer_email']?></td>
                <td><?=$item['full_count_products']?></td>
                <td><?=$item['full_price']?> $</td>
                <td>
                    <a href="/controllOrders/showOne/<?=$item['order_id']?>">Edit</a>
                </td>
            </tr>
        <?}?>
        </tbody>
    </table>
</section>


<? if ((int)self::$data['count'] > 1) { ?>
    <nav class="mt-5 " aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <? if ((int)self::$data['page'] - 1 > 0) { ?>
                <li class="page-item">
                    <a class="page-link" href="/controllOrders/showAll/<?= self::$data['page'] - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            <? } ?>

            <? for ($i = 0; $i < (int)self::$data['count']; $i++) { ?>
                <li class="page-item <?=self::$data['page'] == ($i + 1)  ? 'active' : ''?>">
                    <a class="page-link"  href="/controllOrders/showAll/<?= $i + 1 ?>"><?= $i + 1 ?></a>
                </li>
            <? } ?>

            <? if ((int)self::$data['page'] < (int)self::$data['count']) { ?>
                <li class="page-item">
                    <a class="page-link" href="/controllOrders/showAll/<?= self::$data['page'] + 1 ?>"
                       aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            <? } ?>
        </ul>
    </nav>
<? } ?>
