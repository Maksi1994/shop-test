<div class="container controll-categories x-auto mt-5">
    <div class="row edition-form">
        <form method="post" action="/controllCategories/editOne" class="col-3 input-group mb-3 row">
            <input name="catId" type="hidden" value="<?=self::$data['promotion']['id']?>">

            <div class="form-group w-100">
                <label for="exampleFormControlInput1">Name</label>
                <input name="name" type="text" value="<?=self::$data['promotion']['name'] ?>"
                class="form-control" id="exampleFormControlInput1" placeholder="Name">
            </div>

            <div class="form-group w-100">
                <label for="exampleSelect1">Percent</label>
                <input required type="number" value="<?=self::$data['promotion']['percent'] ?>"
                name="percent" min="0" max="10000.00" step="0.01" class="form-control number"
                    id="formGroupExampleInput2" placeholder="%">
            </div>

            <div class="form-group w-100">
                <label for="exampleTextarea">Description</label>
                <textarea required value="<?=self::$data['promotion']['description']?>"
                class="form-control" placeholder=".." name="description" id="exampleTextarea" rows="3"></textarea>
            </div>

            <div class=" w-100 row mx-1">
                <a class="mt-5 w-100 d-block btn-lg btn btn-danger" href="/controllCategories/deleteOne/<?=self::$data['category']['id']?>" role="button" aria-disabled="true">Delete</a>
            </div>

        </form>
        <div class="col-9">
            <h1 class="mb-5 text-right">Map</h1>
            <?= build_tree(self::$data['allCategories'], 0, self::$data['category']['id']) ?>
        </div>
    </div>

</div>
