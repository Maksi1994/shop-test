<?php
function build_tree_options($cats, $parent_id, $catId)
{
    $tree = '';
    if (is_array($cats) and isset($cats[$parent_id])) {
        foreach ($cats[$parent_id] as $cat) {
                $catName = ucfirst($cat['name']);
                $checked  = $cat['id'] == $catId ? 'selected' : '';
                $tree .= "<option $checked  value='{$cat['id']}'>" . $catName . "</option>";

                if (is_array($cats[$cat['id']])) {
                    $tree .= "<optgroup label='$catName Subcategories'>";
                    $tree .=  build_tree_options($cats, $cat['id'], $catId);
                    $tree .= " </optgroup>";
                }
        }
    } else return null;

    return $tree;
}


function build_tree($cats, $parent_id, $catId)
{
    if (is_array($cats) and isset($cats[$parent_id])) {
        $tree = '<ul class="m-0 d-table ml-auto">';
        foreach ($cats[$parent_id] as $cat) {
            $btnStyle = $cat['id'] === $catId ? 'btn-warning text-white' : 'btn-primary';
            $tree .= "<li> <a href='/controllCategories/showOne/{$cat['id']}' class='btn  mb-2 active $btnStyle' role='button' aria-pressed='true'>{$cat['name']}</a>";
            $tree .= build_tree($cats, $cat['id'], $catId);

            $tree .= '</li>';
        }

        $tree .= '</ul>';
    } else return null;

    return $tree;
}

?>
<div class="container controll-categories x-auto mt-5">
    <div class="row edition-form">
        <form method="post" action="/controllCategories/editOne" class="col-3 input-group mb-3 row">
            <input name="catId" type="hidden" value="<?=self::$data['category']['id']?>">
            <div class="form-group w-100">
                <label for="exampleFormControlInput1">Name</label>
                <input name="name" type="text" value="<?= self::$data['category']['name'] ?>" class="form-control"
                       id="exampleFormControlInput1" placeholder="Name">
            </div>


            <div class=" w-100 form-group">
                <label for="exampleFormControlInput1">Parent</label>
                <select class="form-control" name="parentId">
                    <option <?=(!empty(self::$data['category']['parent_id']) ? '' : 'selected')?>></option>
                    <?=build_tree_options(self::$data['possibleParents'], 0, self::$data['category']['parent_id'])?>
                </select>
            </div>
            <div class=" w-100 row mt-5 mx-1">
                <button class=" w-100 mt-5 btn-lg btn btn-success d-block text-white">Save</button>
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




