<?
function build_tree_options($cats, $parent_id)
{
    $tree = '';
    if (is_array($cats) and isset($cats[$parent_id])) {
        foreach ($cats[$parent_id] as $cat) {
            $catName = ucfirst($cat['name']);

            $tree .= "<option value='{$cat['id']}'>" . $catName . "</option>";

            if (is_array($cats[$cat['id']])) {
                $tree .= "<optgroup label='$catName Subcategories'>";
                $tree .= build_tree_options($cats, $cat['id']);
                $tree .= "</optgroup>";
            }
        }
    } else return null;

    return $tree;
}

?>
<div class="products-controll">
    <form method="post" action="/controllProducts/addOne" enctype="multipart/form-data"
          class="d-block mt-5 w-50 mx-auto">

        <div class="form-group">
            <label for="exampleInputFile">Product photo</label>
            <input name="photo" type="file" class="form-control-file">
            <small class="form-text text-muted">This photo will show all customers</small>
        </div>

        <div class="form-group">
            <label for="formGroupExampleInput">Name</label>
            <input type="text" name="name" required class="form-control" id="formGroupExampleInput"
                   placeholder="Name..">
        </div>

        <div class="form-group">
            <label for="exampleSelect1">Categories</label>
            <select name="category_id" class="form-control">
                <?= build_tree_options(self::$data['categories'], 0) ?>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleTextarea">Small description</label>
            <textarea required class="form-control" placeholder=".." name="description" id="exampleTextarea"
                      rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="formGroupExampleInput2">Price for one in US ($)</label>
            <input required type="number" name="price" min="0" max="10000.00" step="0.01" class="form-control number"
                   id="formGroupExampleInput2" placeholder="$">
        </div>

        <div class="form-group">
            <label for="formGroupExampleInput">Quantity</label>
            <input required type="number" name="count" value="1" min="0" step="1" class="form-control number"
                   id="formGroupExampleInput">
        </div>

        <button type="submit" class="btn w-25 mx-auto d-block mt-5 btn-primary">Publish</button>
    </form>
</div>


