<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\Backend\OptionsModel;

class OptionsController extends BaseController
{

    private $optionsModel;

    public function __construct($routerInfo)
    {
        parent::__construct($routerInfo);
        $this->optionsModel = new OptionsModel();
    }

    public function getSearchForm()
    {
        $mostPopular = $this->optionsModel->getMostPopular();

        return ['mostPopular' => $mostPopular];
    }

    public function getOne($id)
    {
        $option = $this->optionsModel->getOneOption($id);
        $values = $this->optionsModel->getOptionValues($id);

        return [
            "option" => $option,
            "values" => $values
        ];
    }

    public function getOptionValue()
    {
        $options = $this->optionsModel->getOptionValues($_POST['id']);
        echo json_encode($options);
        exit;
    }

    public function searchOptions()
    {
        header('Content-Type: application/json');
        echo json_encode($this->optionsModel->searchOptions($_POST['searchText']));
        exit;
    }

    public function addValueToOption()
    {
        $isSuccess = $this->optionsModel->addValueToOption($_POST);

        echo json_encode(['success' => $isSuccess]);
        exit;
    }

    public function editParamName()
    {
        $isSuccess = $this->optionsModel->editParamName($_POST);

        echo json_encode(['success' => $isSuccess]);
        exit;
    }

    public function editOptionValue()
    {
        $isSuccess = $this->optionsModel->editOptionValue($_POST);

        echo json_encode(['success' => $isSuccess]);
        exit;
    }

    public function deleteOne($id)
    {
        $isSuccess = $this->optionsModel->deleteOne($id);

        echo json_encode(['success' => $isSuccess]);
        exit;
    }


}
