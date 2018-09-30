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
                        <a href="/products/getProducts/<?= self::$data['page'] ?>/<?= self::$data['category']['id'] ?>/<?= self::$data['filter'] === 'priceDESC' ? 'priceASC' : 'priceDESC' ?>"
                           class="item <?= (self::$data['filter'] === 'priceDESC' || self::$data['filter'] === 'priceASC') ? 'active' : '' ?>">
                            <i class="fas fa-dollar-sign"></i>

                            <? if (self::$data['filter'] === 'priceASC') { ?>
                                <i class="fas fa-arrow-down"></i>
                            <? } elseif (self::$data['filter'] === 'priceDESC') { ?>
                                <i class="fas fa-arrow-up"></i>
                            <? } else { ?>
                                <i class="fas fa-arrow-down"></i>
                            <? } ?>
                        </a>

                        <a href="/products/getProducts/<?= self::$data['page'] ?>/<?= self::$data['category']['id'] ?>/<?= self::$data['filter'] === 'newestASC' ? 'newestDESC' : 'newestASC' ?>"
                           class="item <?= (self::$data['filter'] === 'newestDESC' || self::$data['filter'] === 'newestASC') ? 'active' : '' ?>">
                            <i class="fas fa-fire"></i>
                            <? if (self::$data['filter'] === 'newestASC') { ?>
                                <i class="fas fa-arrow-down"></i>
                            <? } else if (self::$data['filter'] === 'newestDESC') { ?>
                                <i class="fas fa-arrow-up"></i>
                            <? } else { ?>
                                <i class="fas fa-arrow-down"></i>
                            <? } ?>
                        </a>


                        <a href="/products/getProducts/<?= self::$data['page'] ?>/<?= self::$data['category']['id'] ?>/<?= self::$data['filter'] === 'popularASC' ? 'popularDESC' : 'popularASC' ?>"
                           class="item <?= (self::$data['filter'] === 'popularDESC' || self::$data['filter'] === 'popularASC') ? 'active' : '' ?>">
                            <i class="fas fa-truck-loading"></i>

                            <? if (self::$data['filter'] === 'popularASC') { ?>
                                <i class="fas fa-arrow-down"></i>
                            <? } else if (self::$data['filter'] === 'popularDESC') { ?>
                                <i class="fas fa-arrow-up"></i>
                            <? } else { ?>
                                <i class="fas fa-arrow-down"></i>
                            <? } ?>
                        </a>
                    </div>
                </div>
            </div>
            <? foreach (self::$data['products'] as $product) { ?>
                <!-- Product Single -->
                <div class="col-md-4 col-sm-6 col-xs-6">
                    <div class="product product-single">
                        <div class="product-thumb">
                            <a class="main-btn quick-view"
                               href="/products/getProduct/<?= $product['id'] ?>/<?= $product['promotionId'] ?>">View</a>
                            <img src="/assets/images/products/<?= $product['photo'] ?>" alt="">
                            <div class="product-label">
                                <span>New</span>
                                <? if ($product['promotionPercent']) { ?>
                                    <span class="sale">-<?= $product['promotionPercent'] ?>%</span>
                                <? } ?>
                            </div>
                        </div>
                        <div class="product-body">
                            <h3 class="product-price">$ <?= $product['newPrice'] ?? $product['price'] ?></h3>
                            <h2 class="product-name"><a href="#"><?= $product['name'] ?></a></h2>
                            <div class="product-btns">
                                <? if (USER['auth'] && empty($product['inCart'])) { ?>
                                    <button class="primary-btn add-to-cart"
                                            data-id="<?= $product['id'] ?>"
                                            data-user-id="<?= USER['id'] ?>"
                                            data-promotion="<?= $product['promotionId'] ?>"
                                            ><i class="fa fa-shopping-cart"></i> Add to Cart</button>
                                <? } ?>
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
    <? for ($i = 1;
            $i < self::$data['countPages'] + 1;
            $i++) { ?>
        <a class="item <?= $i == self::$data['page'] ? 'active' : '' ?>"
           href="/products/getProducts/<?= $i ?>/<?= self::$data['category']['id'] ?>/<?= self::$data['filter'] ?>"><?= $i ?></a>
    <? } ?>
</div>
