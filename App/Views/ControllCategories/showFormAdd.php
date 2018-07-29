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
            <label class="d-block w-100 mb-2" for="exampleInputFile">Choose categoty photo</label>
            <button type="button w-100" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                Select
            </button>
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

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
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
