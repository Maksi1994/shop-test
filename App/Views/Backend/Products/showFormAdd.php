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

        <div class="form-group w-25">
            <label for="formGroupExampleInput">Count</label>
                <input type="number" name="count" required class="form-control" id="formGroupExampleInput"
                       value="1">
        </div>

        <div class="p-3 border mb-3">
            <h5>Product options:</h5>
            <div class="list mb-5 list-added-options"></div>
        </div>

        <div class="p-3 border">
            <div class="input-group input-group-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-sm">Searching options for products</span>
                </div>
                <input type="text" class="form-control options-search-input" aria-label="Sizing example input"
                       aria-describedby="inputGroup-sizing-sm">
            </div>

            <div class="list list-group"></div>
        </div>


        <button type="submit" class="btn w-25 mx-auto d-block mt-5 btn-primary">Publish</button>
    </form>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.body.querySelector('input[name=photo]');
        const imagePreview = document.body.querySelector('.imagePreview');

        const seaechInput = document.body.querySelector('.options-search-input');
        const listContain = document.body.querySelector('.list-group');
        const productOptionsList = document.body.querySelector('.product-options');
        const listAddedOptions = document.body.querySelector('.list-added-options');
        let foundedOptions = [];
        let addedOptions = [];
        let debounceTimerId;
        let searchText = '';

        fileInput.addEventListener('change', function () {
            const reader = new FileReader();

            reader.readAsDataURL(fileInput.files[0]);

            reader.onload = function () {
                imagePreview.src = reader.result;
                imagePreview.classList.add('show');
            };

            reader.onerror = function (error) {
                console.log('Error: ', error);
            };
        });


        seaechInput.addEventListener('keyup', (event) => {
            const searchVal = event.target.value.replace(/\s/g, '');

            if (searchVal === searchText) {
                return;
            }

            searchText = searchVal;

            if (debounceTimerId) {
                clearTimeout(debounceTimerId);
            }

            doSearch(searchText);
        });

        function renderFoundedOptions(res) {
            let html = '';
            console.log(res);
            res.forEach(item => {
                html += `<a data-id="${item.option_id}" class="list-group-item list-group-item-action align-items-center d-flex p-2 mt-5 option-item founded-option">${item.option_name}` +
                    `<button type="button" data-id="${item.option_id}" class="btn btn-primary btn-sm ml-auto d-block add-option-btn">Add</button>` +
                    '</a>';
            });

            listContain.innerHTML = html;
        }

        document.body.addEventListener('click', (event) => {
            if (event.target.classList.contains('add-option-btn')) {
                const optionId = event.target.dataset.id;
                const option = foundedOptions.find(option => option.option_id = optionId);
                const valuesHtml  = getOptionHtml(option);

                addedOptions.push(option);
                listAddedOptions.innerHTML = listAddedOptions.innerHTML + `
                    <a  data-id="${option.option_id}" class="added-option list-group-item list-group-item-action align-items-center d-flex p-2 mt-5 flex-wrap text-capitalize">${option.option_name}
                    <button type="button" data-id="${option.option_id}" class="btn btn-danger btn-sm ml-auto d-block delete-option-btn">Remove</button>
                        <div class="d-flex justify-content-center flex-column w-100 mt-5"> ${valuesHtml}</div>
                    </a>`;

                document.body.querySelector(`.option-item.founded-option[data-id="${option.option_id}"]`).remove();
            } else if (event.target.classList.contains('delete-option-btn')) {
                document.body.querySelector(`.added-option[data-id="${event.target.dataset.id}"]`).remove();
                addedOptions = addedOptions.filter(option => option.option_id !== event.target.dataset.id);

                doSearch(searchText);
            }
        });

        function getOptionHtml(option) {
            let html = '';

            option.values.forEach(val => {
                html+=`<p class="p-0 mb-2 text-lowercase"><input class="mr-3" name="option_id=${option.option_id}" type="radio" value="${val.id}">${val.option_value}</p> </br>`;
            });

            return html;
        }


        function doSearch(searchText) {
            if (searchText.length > 2) {
                renderFoundedOptions([]);
                debounceTimerId = setTimeout(() => {
                    const formData = new FormData();
                    debounceTimerId = null;
                    formData.append('searchText', searchText);

                    fetch('/controllProducts/searchOptions', {body: formData, method: 'POST'})
                        .then(rez => rez.text())
                        .then((rez) => {
                            foundedOptions = JSON.parse(rez).filter(option => {
                                return addedOptions.findIndex(addedOption => addedOption.option_id === option.option_id) === -1;
                            });
                            renderFoundedOptions(foundedOptions);
                        }).catch((err) => {
                        console.log(err);
                    });

                }, 300);
            }
        }


    });
</script>
