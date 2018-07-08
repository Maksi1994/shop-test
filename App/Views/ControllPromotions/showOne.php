<div class="container controll-categories x-auto mt-5">
    <div class="row edition-form">
        <form method="post" action="/controllPromotions/editOne" class="col-8 mx-auto input-group mb-3 row">
            <input name="id" type="hidden" value="<?=self::$data['promotion']['id']?>">

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
                <textarea required class="form-control" placeholder=".." name="description" id="exampleTextarea" rows="3"><?=self::$data['promotion']['description']?></textarea>
            </div>

            <div class=" w-100 row mx-1">
                <button class="mt-5 mx-auto w-50 btn-lg btn btn-success">Save</button>
            </div>

            <div class=" w-100 row mx-1">
                <a class="mt-5 w-50 mx-auto d-block btn-lg btn btn-danger" href="/controllPromotions/deleteOne/<?=self::$data['promotion']['id']?>" aria-disabled="true">Delete</a>
            </div>

        </form>
    </div>

</div>
