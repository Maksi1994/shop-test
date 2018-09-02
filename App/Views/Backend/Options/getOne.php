<div class="list-group w-25 mx-auto mt-5">
    <div class="input-group mb-5">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon1">Name:</span>
        </div>
        <input type="text" value="<?= self::$data['option']['name'] ?>" class="form-control mr-2 param-name"
               placeholder="Option name"
               aria-label="Username" aria-describedby="basic-addon1">

        <button type="button" class="btn btn-primary btn-lg mx-auto ml-3 d-block save-name-btn">Save</button>
    </div>

    <div class="list-wrap">
        <? foreach (self::$data['values'] as $value) { ?>
            <a href="#" class="list-group-item list-group-item-action d-flex text-left option-item"
               data-id="<?= $value['id'] ?>"><?= $value['name'] ?>
                <button type="button" data-id="<?= $value['id'] ?>"
                        class="btn btn-outline-warning edit ml-auto d-block">
                    Edit
                </button>
                <button type="button" data-id="<?= $value['id'] ?>" class="btn btn-outline-danger delete ml-2 d-block">
                    Delete
                </button>
            </a>
        <? } ?>
    </div>
    <div class="input-group input-group-lg mt-5">
        <input type="text" class="form-control input-field" aria-label="Sizing example input"
               aria-describedby="inputGroup-sizing-lg">
    </div>
    <button type="button" class="btn btn-primary btn-lg mx-auto mt-3 save">Add one</button>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const listWrapElement = document.body.querySelector('.list-wrap');
        const inputField = document.body.querySelector('.input-field');
        const inputParamName = document.body.querySelector('.param-name');
        const saveBtn = document.body.querySelector('.save');
        let optionName = "<?=self::$data['option']['name']?>";
        let optionId = <?=self::$data['option']['id']?>;

        let parameters = <?=json_encode(self::$data['values'])?>;
        let editingField;
        let activeEditedField;

        document.body.addEventListener('click', (event) => {

            if (event.target.classList.contains('btn') && event.target.dataset.id) {
                if (event.target.classList.contains('edit') && !activeEditedField) {
                    saveBtn.innerHTML = `Save`;
                    event.target.textContent = 'Reverte';
                    editingField = parameters.find(item => item.id == event.target.dataset.id);

                    activeEditedField = document.body.querySelector(`.option-item[data-id='${event.target.dataset.id}']`);
                    activeEditedField.querySelector('.delete').classList.add('disabled');
                    inputField.value = editingField.name;
                } else if (event.target.classList.contains('edit') && activeEditedField) {
                    activeEditedField.querySelector('.delete').classList.remove('disabled');
                    activeEditedField.querySelector('.edit').textContent = 'Edit';
                    saveBtn.innerHTML = `Add One`;
                    inputField.value = '';

                    activeEditedField = null;
                } else if (event.target.classList.contains('btn') && !activeEditedField) {
                    fetch(`/controllOptions/deleteOne/${event.target.dataset.id}`)
                        .then(() => {
                            refreshList();
                            inputField.value = '';
                            saveBtn.innerHTML = `Add One`;
                            activeEditedField = null;
                        }).catch((err) => {
                        console.log(err);
                    });
                }
            }
        });

        document.body.addEventListener('input', (event) => {
            if (event.target.classList.contains('param-name')) {
                if (event.target.value.length > 0 && event.target.value !== optionName) {
                    document.body.querySelector('.save-name-btn').classList.add('btn-warning');
                } else {
                    document.body.querySelector('.save-name-btn').classList.remove('btn-warning');
                }
            }
        });

        document.body.addEventListener('click', (event) => {

            if (event.target.classList.contains('save')) {
                if (activeEditedField) {
                    const formData = new FormData();

                    formData.append('optionId', <?=json_encode(self::$data['option']['id'])?>);
                    formData.append('valueId', editingField.id);
                    formData.append('value', inputField.value);

                    fetch('/controllOptions/editOptionValue', {body: formData, method: 'POST'})
                        .then(() => {
                            refreshList();
                            inputField.value = '';
                            saveBtn.innerHTML = `Add One`;
                            activeEditedField = null;
                        }).catch((err) => {
                        console.log(err);
                    });

                } else if (!activeEditedField) {
                    const formData = new FormData();

                    if (inputField.value.length) {
                        formData.append('optionId', optionId);
                        formData.append('value', inputField.value);

                        fetch('/controllOptions/addValueToOption', {body: formData, method: 'POST'})
                            .then(() => {
                                refreshList();
                                inputField.value = '';
                            }).catch((err) => {
                            console.log(err);
                        });
                    }
                }
            } else if (event.target.classList.contains('save-name-btn')) {
                const formData = new FormData();
                formData.append('optionId', optionId);
                formData.append('name', inputParamName.value);

                if (formData.get('name').length) {
                    fetch('/controllOptions/editParamName', {body: formData, method: 'POST'})
                        .then(() => {
                            document.body.querySelector('.save-name-btn').classList.remove('btn-warning');
                        }).catch((err) => {
                        console.log(err);
                    });
                }
            }
        });


        function refreshList() {
            const formData = new FormData();
            let html = '';

            formData.append('id', optionId);
            fetch('/controllOptions/getOptionValue', {body: formData, method: 'POST'})
                .then(rez => rez.text())
                .then((rez) => {
                    parameters = JSON.parse(rez);

                    parameters.forEach(value => {
                        html += `
        <a href="#" class="list-group-item list-group-item-action d-flex text-left option-item"
           data-id="${value.id}">${value.name}
            <button type="button" data-id="${value.id}" class="btn btn-outline-warning edit ml-auto d-block">
                Edit
            </button>
            <button type="button" data-id="${value.id}" class="btn btn-outline-danger delete ml-2 d-block">
                Delete
            </button>
        </a>`;
                        listWrapElement.innerHTML = html;
                    });
                }).catch((err) => {
                console.log(err);
            });

            listWrapElement.innerHTML
        }
    });
</script>