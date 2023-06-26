<?php

namespace App\Presenters;
use Nette;
use Nette\Application\UI\Form;
use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums;
use App\Forms\DrugFormFactory;
use App\Models\DrugFacade;


class DrugPresenter extends Nette\Application\UI\Presenter{
    private $facade;
    //TODO DI instead of constructor
    public function __construct(DrugFacade $facade)
    {
        $this->facade = $facade;
    }

    public function renderTableContents(): void
    {
        $this->template->drugs = $this->facade
            ->getAllDrugs();
    }

    public function renderShow($drugID): void
    {
        $this->template->drugs = $this->facade
            ->getAllDrugs()->get($drugID);
    }

    public function actionAdd(): void
    {
        $form = $this->getComponent('drugForm');
        $form->onSuccess[] = [$this, 'addFormSucceeded'];
    }


    protected function createComponentDrugForm(): Form
    {
        return DrugFormFactory::createForm($this->getAction(), $this->getParameter('drugID'));
    }


    public function addFormSucceeded(Form $form, array $data): void
    {
        $drug = $this->facade->getAllDrugs()->insert($data); // add record to database
        $this->flashMessage('Successfully added');
        $this->forward('Drug:tablecontents');
    }


}