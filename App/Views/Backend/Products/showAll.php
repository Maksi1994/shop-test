<section class="d-block px-3 mt-5 products-controll">
    <table class="table table-sm">
        <thead>
        <tr>
            <th scope="col">№</th>
            <th scope="col">Name</th>
            <th scope="col">Photo</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col">Edit</th>
        </tr>
        </thead>
        <tbody>
        <? foreach (self::$data['list'] as $listIndex => $item) { ?>
            <tr class="<?=$item['status'] == 'e' ? '' : 'table-dark'?>">
                <td><?= ((self::$data['page'] - 1) * 10) + ($listIndex + 1) ?></td>
                <td><?= $item['name'] ?></td>
                <td>
                    <img class="product-image" src="<?= "/assets/images/products/" . $item['photo'] ?>" alt="">
                </td>
                <td><?= $item['description'] ?></td>
                <td><?= $item['price'] ?></td>
                <td>
                    <a href="/controllProducts/showOne/<?= $item['id'] ?>">Edit</a>
                </td>
            </tr>
        <? } ?>
        </tbody>
    </table>
</section>
<? if ((int)self::$data['count'] > 1) { ?>
    <nav class="mt-5 " aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <? if (self::$data['page'] - 1 > 0) { ?>
                <li class="page-item">
                    <a class="page-link" href="/controllProducts/showAll/<?= self::$data['page'] - 1 ?>"
                       aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            <? } ?>

            <? for ($i = 1; $i <= self::$data['count']; $i++) { ?>
                <li class="page-item <?=self::$data['page'] == $i ? 'active' : ''?>"><a class="page-link"
                                         href="/controllProducts/showAll/<?= $i ?>"><?= $i ?></a>
                </li>
            <? } ?>

            <? if (self::$data['page'] < self::$data['count']) { ?>
                <li class="page-item">
                    <a class="page-link" href="/controllProducts/showAll/<?= self::$data['page'] + 1 ?>"
                       aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            <? } ?>
        </ul>
    </nav>
<? } ?>

<a class="controll-add-btn bg-primary" href="/controllProducts/showFormAdd">+</a>
