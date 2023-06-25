<?php

namespace App\Presenters;
use Nette;
use Nette\Application\UI\Form;
use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums;
use App\Models\DrugFacade;


class DrugPresenter extends Nette\Application\UI\Presenter{
    private $facade;
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
        BootstrapForm::switchBootstrapVersion(Enums\BootstrapVersion::V5);
        $form = new BootstrapForm;

        $form->addText('name', 'Title:')
            ->setRequired();
        $form->addTextArea('description', 'Content:')
            ->setRequired();
        $form->addTextArea('side_effects', 'Side Effects:')
            ->setRequired();

        if ($this->getAction() === 'add'){

            $form->addButton('placeholder','Save')
                ->setHtmlAttribute('hx-post','/drug/add/')
                ->setHtmlAttribute('style', '
                    padding: 12.5px 30px;
    border: 0;
    border-radius: 100px;
    background-color: #4926F9;
    color: #ffffff;
    font-weight: Bold;
    transition: all 0.5s;
    -webkit-transition: all 0.5s;
                ')                ->setOmitted();

        } elseif ($this->getAction() === 'edit'){

            $form->addButton('placeholder','Save changes')
                ->setHtmlAttribute('hx-post','/drug/edit?drugID='.$this->getParameter('drugID'))
                ->setOmitted();

        }


        return $form;
    }

    public function addFormSucceeded(Form $form, array $data): void
    {
        $podcast = $this->facade->getAllDrugs()->insert($data); // add record to database
        $this->flashMessage('Successfully added');
        $this->forward('Drug:tablecontents');
    }


}