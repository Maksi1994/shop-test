<div class="container list x-auto mt-5">
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-lg">Search</span>
        </div>
        <input type="text" class="form-control options-search-input" aria-label="Sizing example input"
               aria-describedby="inputGroup-sizing-lg">
    </div>
    <div class="border p-5 mt-5">
        <h3 class="d-block text-center">Found:</h3>
        <div class="list  mt-5 list-group"></div>
    </div>

    <? if (count(self::$data['mostPopular']) > 0) { ?>
        <div class="list mt-5 border p-5">
            <h3 class="text-center">Most Popular:</h3>
            <? foreach (self::$data['mostPopular'] as $option) { ?>
                <a href="/controllOptions/getOne/<?= $option['id'] ?>"
                   class="list-group-item list-group-item-action mt-5"><?= $option['name'] ?></a>
            <? } ?>
        </div>
    <? } ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const seaechInput = document.body.querySelector('.options-search-input');
        const listContain = document.body.querySelector('.list-group');
        let querySearch = '<?=self::$routerParams->queryParams['searchText']?>';
        let debounceTimerId;
        let searchText = querySearch || '';

        doSearch(searchText);

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

        function renderFoundedOptions(list) {
            let html = '';

            list.forEach(item => {
                html += ` <a href="/controllOptions/getOne/${item.option_id}" class="list-group-item list-group-item-action">${item.option_name}</a>`
            });

            listContain.innerHTML = html;
        }


        function doSearch(searchText) {
            if (searchText.length > 2) {
                renderFoundedOptions([]);
                debounceTimerId = setTimeout(() => {
                    const formData = new FormData();
                    debounceTimerId = null;
                    formData.append('searchText', searchText);

                    history.pushState({}, 'Search options', `<?$_SERVER['REQUEST_URI']?>?searchText=${searchText}`);

                    fetch('/controllOptions/searchOptions', {body: formData, method: 'POST'})
                        .then(rez => rez.text())
                        .then((rez) => {
                            renderFoundedOptions(JSON.parse(rez));
                        }).catch((err) => {
                        console.log(err);
                    });

                }, 300);
            }
        }
    });
</script>

