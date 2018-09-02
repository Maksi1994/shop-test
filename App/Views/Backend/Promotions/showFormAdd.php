<div class="">
    <form method="post" action="/controllPromotions/addOne" enctype="multipart/form-data"
          class="d-block mt-5 w-50 mx-auto">

        <div class="form-group">
            <label for="formGroupExampleInput">Name</label>
            <input type="text" name="name" required class="form-control" id="formGroupExampleInput"
                   placeholder="Name..">
        </div>

        <div class="form-group">
            <label for="exampleSelect1">Percent</label>
            <input required type="number" name="percent" min="0" max="10000.00" step="0.01" class="form-control number"
                id="formGroupExampleInput2" placeholder="%">
        </div>

        <div class="form-group">
            <label for="exampleTextarea">Description</label>
            <textarea required class="form-control" placeholder=".." name="description" id="exampleTextarea" rows="3"></textarea>
        </div>

        <button type="submit" class="btn w-25 mx-auto d-block mt-5 btn-primary">Publish</button>
    </form>
</div>