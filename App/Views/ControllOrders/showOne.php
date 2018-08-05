<section class="container mx-auto">
    <div class="row mt-5 ">
        <div class="col-12 mb-5">
            <h5 class="pl-1 card-title text-uppercase">Order Number: <?= self::$data['order_id']?></h5>
            <h5 class="pl-1 card-title text-uppercase">Date: <?= date('D, d M Y H:i', self::$data['ts_create'])?></h5>
            <a href="/controllOrders/deleteOne/<?= self::$data['order_id'] ?>" class="mt-5 w-25 ml-auto d-block btn btn-danger"
               tabindex="-1" role="button"
               aria-disabled="true">Delete order</a>
        </div>
        <div class="col-12">
            <form method="post" action="/controllOrders/updateOrder">
                <input type="hidden" name="id" value="<?= self::$data['order_id'] ?>" class="form-control">

                <div class="form-group">
                    <p>Customer Name: <?= self::$data['customer_name'] ?></p>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Customer Email</label>
                    <input type="text" name="customer_email" value="<?= self::$data['customer_email'] ?>" class="form-control"
                           id="exampleFormControlInput1">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Status</label>
                    <select name="status" class="form-control" id="exampleFormControlSelect1">
                        <option value="p" <?=self::$data['curr_status'] === 'p' ? 'selected' : ''?>>Pending</option>
                        <option value="d" <?=self::$data['curr_status'] === 'd' ? 'selected' : ''?>>Done</option>
                    </select>
                </div>
                <div class="form-group mt-5">
                <div class="form-group mt-5">
                    <label for="exampleFormControlSelect2 text-bold">Products:</label>

                    <div class="order-products-list d-flex flex-column">
                        <? foreach (self::$data['products'] as $product) { ?>
                            <div class="mb-3 pr-3  w-100 pr-0 d-flex align-items-center">
                                <div class="mr-5">
                                    <?=$product['count']?>
                                </div>
                                <img class="product-img mr-5" src="/assets/images/products/<?=$product['photo']?>" alt="">
                                <p class="my-0"><?= $product['name'] ?></p>
                                <div class="ml-auto mr-5">
                                    <?=$product['full_price']?> $
                                </div>
                                <input class="ml-5"
                                       checked
                                       name="<?="product={$product['id']}" ?>"
                                       type="checkbox"
                                       value="<?= $product['id']?>" id="defaultCheck1">
                                <input class="ml-5"
                                       checked
                                       name="<?="productCount={$product['id']}" ?>"
                                       type="hidden"
                                       value="<?= $product['count']?>" id="defaultCheck1">
                                <input class="ml-5"
                                       checked
                                       name="<?="productPrice={$product['id']}" ?>"
                                       type="hidden"
                                       value="<?= $product['price_for_one']?>" id="defaultCheck1">
                            </div>
                        <? } ?>
                    </div>
                </div>

                <div class="row border-top mt-5 mx-1">
                    <button class="mt-5 w-25 btn-lg btn btn-success d-block ml-auto">Save</button>
                </div>

            </form>
        </div>
        <div class="row">
            <? if (!empty(self::$data['errorMessage'])) { ?>
                <div class="alert alert-danger w-100" role="alert">
                    <?= self::$data['errorMessage'] ?>
                </div>
            <? } ?>
        </div>
    </div>
</section>