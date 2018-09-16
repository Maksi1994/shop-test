<!-- section -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h2 class="title"><?=self::$data['category']['name']?></h2>
                </div>
            </div>
            <? foreach (self::$data['products'] as $product) { ?>
                <!-- Product Single -->
                <div class="col-md-4 col-sm-6 col-xs-6">
                    <div class="product product-single">
                        <div class="product-thumb">
                            <a class="main-btn quick-view" href="/products/getProduct/<?=$product['id']?>">View</a>
                            <img src="/assets/images/products/<?= $product['photo'] ?>" alt="">
                            <div class="product-label">
                                <span>New</span>
                                <? if ($product['promotionPercent']) { ?>
                                    <span class="sale">-20%</span>
                                <? } ?>
                            </div>
                        </div>
                        <div class="product-body">
                            <h3 class="product-price">$ <?= $product['price'] ?></h3>
                            <h2 class="product-name"><a href="#"><?= $product['name'] ?></a></h2>
                            <div class="product-btns">
                                <button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
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
