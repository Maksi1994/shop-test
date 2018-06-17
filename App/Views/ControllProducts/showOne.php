<section class="container mx-auto">
    <div class="row mt-5">
        <div class="col-3 mr-auto">
            <h5 class="pl-1 card-title text-uppercase"><?= self::$data['product']['name'] ?></h5>

            <div class="mt-5 border p-3">
                <img src="<?="/assets/images/products/".self::$data['product']['photo']?>" class="img-fluid "
                     alt="Responsive image">
            </div>
            <a href="/controllProducts/deleteOne/<?= self::$data['product']['id'] ?>" class="mt-5 w-100 btn btn-danger"
               tabindex="-1" role="button"
               aria-disabled="true">Delete product</a>
        </div>
        <div class="col-6">
            <form method="post" action="/controllProducts/updateProduct">
                <input type="hidden" name="id" value="<?= self::$data['product']['id'] ?>" class="form-control">

                <div class="form-group">
                    <label for="exampleFormControlInput1">Name</label>
                    <input type="text" name="name" value="<?= self::$data['product']['name'] ?>" class="form-control"
                           id="exampleFormControlInput1"
                           placeholder="name@example.com">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Price ($)</label>
                    <input required value="<?= self::$data['product']['price'] ?>" type="number" name="price" min="0"
                           max="10000.00" step="0.01" class="form-control number" id="formGroupExampleInput2"
                           placeholder="$">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Category</label>
                    <select name="categoryId" class="form-control" id="exampleFormControlSelect1">
                        <? foreach (self::$data['allCategories'] as $category) { ?>
                            <option value="<?= $category['id'] ?>" <?=$category['id'] == self::$data['product']['category_id'] ? "selected" : ""?>> <?= $category['name']?></option>
                        <? } ?>
                    </select>
                </div>
                <div class="form-group mt-5">
                    <label for="exampleFormControlSelect2 text-bold">Active Promotions</label>
                    <ul class="mt-2 list-group list-group-flush">
                        <? foreach (self::$data['allPromotions'] as $promotion) { ?>
                            <div class="list-group-item pr-0 d-flex justify-content-between align-items-center">
                                <p><?= $promotion['name'] ?></p>
                                <input name="<?="promotion={$promotion['id']}" ?>"
                                       type="checkbox" <?= $promotion['active'] ? 'checked' : '' ?>
                                       value="<?= $promotion['id']?>" id="defaultCheck1">
                            </div>
                        <? } ?>
                    </ul>
                </div>

                <div class="row border-top mt-5 mx-1">
                    <button class="mt-5 w-100 btn-lg btn btn-success">Save</button>
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