<!-- section -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h2 class="title"><?= self::$data['category']['name'] ?></h2>

                    <div class="tools-bar">
                        <div class="item"><i class="fas fa-dollar-sign"></i> <i class="fas fa-arrow-down"></i></div>
                        <div class="item"><i class="fas fa-fire"></i> <i class="fas fa-arrow-down"></i></div>
                        <div class="item"><i class="fas fa-dollar-sign"></i> <i class="fas fa-arrow-down"></i></div>
                    </div>
                </div>
            </div>
            <? foreach (self::$data['products'] as $product) { ?>
                <!-- Product Single -->
                <div class="col-md-4 col-sm-6 col-xs-6">
                    <div class="product product-single">
                        <div class="product-thumb">
                            <a class="main-btn quick-view" href="/products/getProduct/<?= $product['id'] ?>">View</a>
                            <img src="/assets/images/products/<?= $product['photo'] ?>" alt="">
                            <div class="product-label">
                                <span>New</span>
                                <? if ($product['promotionPercent']) { ?>
                                    <span class="sale">-<?=$product['promotionPercent']?>%</span>
                                <? } ?>
                            </div>
                        </div>
                        <div class="product-body">
                            <h3 class="product-price">$ <?= $product['newPrice'] ?? $product['price'] ?></h3>
                            <h2 class="product-name"><a href="#"><?= $product['name'] ?></a></h2>
                            <div class="product-btns">
                                <button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Product Single -->
            <? } ?>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<!-- /section -->
<div class="pagination-wrap">
    <? for ($i = 1; $i < self::$data['countPages'] + 1; $i++) { ?>
        <a class="item <?=$i == self::$data['page'] ? 'active': ''?>" href="/products/getProducts/<?=$i?>/<?=self::$data['category']['id']?>"><?=$i?></a>
    <? } ?>
</div>
