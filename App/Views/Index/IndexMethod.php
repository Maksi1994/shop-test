<!-- HOME -->
<div id="home">
    <!-- container -->
    <div class="container">
        <!-- home wrap -->
        <div class="home-wrap">
            <!-- home slick -->
            <div id="home-slick">
                <!-- banner -->
                <? foreach (self::$data['promotions'] as $promotion) { ?>
                    <div class="banner banner-1 promotion-banner">
                        <div class="banner-caption text-center">
                            <h1><?=$promotion['name']?></h1>
                            <h3 class="font-weak">Discount <?=ceil($promotion['percent'])?>%</h3>
                            <h3 class="font-weak"> <?= $promotion['description']?></h3>
                            <button class="primary-btn">Shop Now</button>
                        </div>
                    </div>
                <? } ?>
                <!-- /banner -->
            </div>
            <!-- /home slick -->
        </div>
        <!-- /home wrap -->
    </div>
    <!-- /container -->
</div>
<!-- /HOME -->


<!-- section -->
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- section title -->
            <div class="col-md-12">
                <div class="section-title">
                    <h2 class="title">Recent Additions</h2>
                </div>
            </div>
            <!-- section title -->
            <? foreach (self::$data['products'] as $product) { ?>
                <!-- Product Single -->
                <div class="col-md-4 col-sm-6 col-xs-6">
                    <div class="product product-single">
                        <div class="product-thumb">
                            <button class="main-btn quick-view"><i class="fa fa-search-plus"></i> Quick view</button>
                            <img src="assets/images/products/<?= $product['photo'] ?>" alt="">
                            <div class="product-label">
                                <span>New</span>
                                <? if ($product['promotion_id']) { ?>
                                    <span class="sale">-20%</span>
                                <? } ?>
                            </div>
                        </div>
                        <div class="product-body">
                            <h3 class="product-price">$ <?= $product['price'] ?></h3>
                            <!--
                            <div class="product-rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o empty"></i>
                            </div>
                            -->
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