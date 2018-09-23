<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a>Products</a></li>
            <li>
                <a href="/products/getProducts/1/<?= self::$data['product']['categoryId'] ?>"><?= self::$data['product']['categoryName'] ?></a>
            </li>
            <li class="active"><?= self::$data['product']['name'] ?></li>
        </ul>
    </div>
</div>
<div class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!--  Product Details -->
            <div class="product product-details clearfix">
                <div class="col-md-6">
                    <div id="product-main-view">
                        <div class="product-view">
                            <img src="/assets/images/products/<?= self::$data['product']['photo'] ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-body">
                        <div class="product-label">
                            <? if (self::$data['product']['promotionName']) { ?>
                                <span class="sale">-<?= self::$data['product']['promotionPercent'] ?>%</span>
                            <? } ?>
                        </div>
                        <h2 class="product-name"><?= self::$data['product']['name'] ?></h2>

                        <? if (self::$data['product']['promotionName']) { ?>
                            <h3 class="product-price">
                                $<?= self::$data['product']['newPrice'] ?>
                                <del class="product-old-price">$ <?= self::$data['product']['price'] ?></del>
                            </h3>
                        <? } else { ?>
                            <h3 class="product-price">$<?= self::$data['product']['price'] ?></h3>
                        <? } ?>

                        <div class="product-options">
                            <? if (self::$data['product']['promotionName'] === 'size') { ?>
                                <? require_once $_SERVER['DOCUMENT_ROOT'] . '/App/Views/+shared/product-parameters/size.php' ?>
                            <? } ?>

                            <? if (self::$data['product']['promotionName'] === 'color') { ?>
                                <? require_once $_SERVER['DOCUMENT_ROOT'] . '/App/Views/+shared/product-parameters/color.php' ?>
                            <? } ?>
                        </div>

                        <? if (USER['auth']) { ?>
                            <div class="product-btns">
                                <div class="qty-input">
                                    <span class="text-uppercase">QTY: </span>
                                    <input class="input product-quantity"
                                           data-id="<?= self::$data['product']['id'] ?>"
                                           data-user-id="<?= USER['id'] ?>"
                                           value="1" type="number">
                                </div>
                                <button class="primary-btn add-to-cart-btn"><i class="fa fa-shopping-cart"></i> Add to
                                    Cart
                                </button>
                            </div>
                        <? } ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="product-tab">
                        <ul class="tab-nav">
                            <li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane fade in active">
                                <p><?= self::$data['product']['description'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /Product Details -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>