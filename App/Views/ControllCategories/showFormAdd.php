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
                $tree .= " </optgroup>";
            }
        }
    } else return null;

    return $tree;
}

?>
<div class="controll-categories">
    <form method="post" action="/controllCategories/addCategory" enctype="multipart/form-data"
          class="d-block mt-5 w-50 mx-auto">

        <div class="form-group">
            <label for="exampleInputFile">Category photo</label>
            <input name="photo" type="file" class="form-control-file">
            <small class="form-text text-muted">This photo will show all customers</small>
        </div>

        <input name="default_parent_id" value="0" type="hidden">

        <div class="form-group">
            <label for="formGroupExampleInput">Name</label>
            <input type="text" name="name" required class="form-control" id="formGroupExampleInput"
                   placeholder="Name..">
        </div>

        <select class="form-control" name="parent_id">
            <option disabled selected value></option>
            <?= build_tree_options(self::$data['allCategrories'], 0) ?>
        </select>

        <button type="submit" class="btn w-25 mx-auto d-block mt-5 btn-primary">Save</button>
    </form>
</div>