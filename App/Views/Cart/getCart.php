<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active"><a href="/cart/getCart">Cart</a></li>
        </ul>
    </div>
</div>

<div class="section cart-page">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <form id="checkout-form" class="clearfix" enctype="multipart/form-data" method="post" action="/cart/makeOrder">
                <? if (count(self::$data['products'])) { ?>
                    <div class="customer-info">
                        <div class="billing-details">
                            <div class="section-title">
                                <h3 class="title">Billing Details</h3>
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" required name="first_name" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <input class="input" type="text" required name="last_name" placeholder="Last Name">
                            </div>
                            <div class="form-group">
                                <input class="input" type="email" required name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input class="input" type="tel" required name="tel" placeholder="Telephone">
                            </div>
                        </div>
                    </div>
                <? } ?>
                <div class="col-md-12">
                    <div class="order-summary clearfix">
                        <div class="section-title">
                            <h3 class="title">Order Review</h3>
                        </div>
                        <table class="shopping-cart-table table">
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th></th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total</th>
                                <th class="text-right"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <? foreach (self::$data['products'] as $product) { ?>
                                <tr class="product-line"
                                    data-id="<?= $product['id'] ?>"
                                    data-promotion="<?= $product['promotionId'] ?>"
                                    data-price="<?= $product['newPrice'] ?? $product['price'] ?>">
                                    <td class="thumb"><img src="/assets/images/products/<?= $product['photo'] ?>"
                                                           alt=""></td>
                                    <td class="details">
                                        <a href="#"><?= $product['name'] ?></a>
                                        <!--
                                        <ul>
                                            <li><span>Size: XL</span></li>
                                            <li><span>Color: Camelot</span></li>
                                        </ul>
                                        -->
                                    </td>
                                    <td class="price text-center">
                                        <strong>$ <?= $product['newPrice'] ?? $product['price'] ?></strong><br>
                                        <? if (!empty($product['promotionId'])) { ?>
                                            <del class="font-weak">
                                                <small>$ <?= $product['price'] ?></small>
                                            </del>
                                        <? } ?>
                                    </td>
                                    <td class="qty text-center">
                                        <input type="hidden" name="productpromotion=<?=$product['id']?>" value="<?=$product['promotionId']?>">

                                        <input min="0" class="input product-quantity" type="number"
                                               name="product=<?= $product['id'] ?>"
                                               value="<?= $product['count'] ?>">
                                    </td>
                                    <td class="total text-center">
                                        <strong class="primary-color">$<span
                                                    class="full-price"><?= ($product['newPrice'] ?? $product['price']) * $product['count'] ?></span></strong>
                                    </td>
                                    <td class="text-right">
                                        <div role="button" class="main-btn icon-btn delete-from-cart"
                                             data-id="<?= $product['id'] ?>"><i class="fa fa-close"></i></div>
                                    </td>
                                </tr>
                            <? } ?>
                            </tbody>
                            <tfoot>
                            <tr>
                            <tr>
                                <th class="empty" colspan="3"></th>
                                <th>TOTAL</th>
                                <th colspan="2" class="total">$<span
                                            class="cart-summ"><?= self::$data['fullPrice'] ?></span></th>
                            </tr>
                            </tfoot>
                        </table>
                        <? if (count(self::$data['products'])) { ?>
                            <div class="pull-right">
                                <button class="primary-btn">Place Order</button>
                            </div>
                        <? } ?>
                    </div>

                </div>
            </form>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>