<section class="d-block px-3 mt-5 products-controll">
    <table class="table table-sm">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Percent</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Edit</th>
        </tr>
        </thead>
        <? foreach (self::$data['promotions'] as $index => $promotion) { ?>
            <tr>
                <td><?=$index?></td>
                <td><?= $promotion['percent'] ?></td>
                <td><?= $promotion['name'] ?></td>
                <td><?= $promotion['description'] ?></td>
                <td> <a href="/controllPromotions/showOne/<?=$promotion['id']?>">Edit</a></td>
            </tr>
        <? } ?>
        <tbody>
        </tbody>
    </table>
</section>

<? if ((int)self::$data['count'] > 1) { ?>
    <nav class="mt-5 " aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <? if (self::$data['page'] - 1 > 0) { ?>
                <li class="page-item">
                    <a class="page-link" aria-label="Previous"
                       href="/controllPromotions/showAll/<?= self::$data['page'] - 1 ?>">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
            <? } ?>

            <? for ($i = 0; $i < self::$data['count']; $i++) { ?>
                <li class="page-item"><a class="page-link"
                                         href="/controllPromotions/showAll/<?= $i + 1 ?>"><?= $i + 1 ?></a>
                </li>
            <? } ?>

            <? if ((int)self::$data['page'] < self::$data['count']) { ?>
                <li class="page-item">
                    <a class="page-link" href="/controllPromotions/showAll/<?= self::$data['page'] + 1 ?>"
                       aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            <? } ?>
        </ul>
    </nav>
<? } ?>


<a class="controll-add-btn bg-primary" href="/controllPromotions/showFormAdd">+</a>