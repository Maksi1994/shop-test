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

        <div class="d-flex justify-content-center mb-5">
            <img class="imagePreview" src="" alt="">
        </div>

        <div class="form-group">
            <label for="exampleInputFile">Category photo</label>
            <input name="photo" type="file" class="form-control-file">
        </div>

        <input name="default_parent_id" value="0" type="hidden">

        <div class="form-group">
            <label for="formGroupExampleInput">Name</label>
            <input type="text" name="name" required class="form-control" id="formGroupExampleInput"
                   placeholder="Name..">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">Parent</label>
            <select class="form-control" name="parent_id">
                <option disabled selected value></option>
                <?= build_tree_options(self::$data['allCategrories'], 0) ?>
            </select>
        </div>

        <button type="submit" class="btn w-25 mx-auto d-block mt-5 btn-primary">Save</button>
    </form>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        var fileInput = document.body.querySelector('input[name=photo]');
        var imagePreview = document.body.querySelector('.imagePreview');

        fileInput.addEventListener('change', function () {
            var reader = new FileReader();

            reader.readAsDataURL(fileInput.files[0]);

            reader.onload = function () {
                imagePreview.src = reader.result;
                imagePreview.classList.add('show');
            };

            reader.onerror = function (error) {
                console.log('Error: ', error);
            };
        });
    });
</script>
