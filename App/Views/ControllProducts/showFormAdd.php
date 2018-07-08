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
        <div class="d-flex justify-content-center mb-5">
          <img class="imagePreview" src="" alt="">
        </div>
        <div class="form-group">
            <label for="exampleInputFile">Product photo</label>
            <input name="photo" type="file" class="form-control-file">
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

        <button type="submit" class="btn w-25 mx-auto d-block mt-5 btn-primary">Publish</button>
    </form>
</div>

<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    var fileInput = document.body.querySelector('input[name=photo]');
    var imagePreview = document.body.querySelector('.imagePreview');

    fileInput.addEventListener('change', function() {
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
