<?php

namespace App\Presenters;
use Nette;
use Nette\Application\UI\Form;
use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums;
use App\Forms\DrugFormFactory;
use App\Models\DrugFacade;


class DrugPresenter extends Nette\Application\UI\Presenter{


    /**
     * @inject
     * @var DrugFacade
     */

    public $facade;


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

    public function actionEdit(int $drugID): void
    {
        $drug = $this->facade->getAllDrugs()->get($drugID);
        $form = $this->getComponent('drugForm');
        $form->setDefaults($drug);
        $form->onSuccess[] = [$this, 'editFormSucceeded'];
    }

    public function actionDelete(int $drugID): void
    {
        $drug = $this->facade->getAllDrugs()->get($drugID);
        $form = $this->getComponent('drugForm');
        $form->setDefaults($drug->toArray());
        $form->onSuccess[] = [$this, 'deleteFormSucceeded'];
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

    public function editFormSucceeded(Form $form, array $data): void
    {
        $drugID = (int) $this->getParameter('drugID');
        $this->facade->getAllDrugs()->get($drugID)->update($data);
        $this->flashMessage('Succesfully updated');
        $this->forward('Drug:tablecontents');
    }

    protected function createComponentDeleteForm(): Form
    {
        //TODO factory doesnt work (without factory working as intended)
        return DrugFormFactory::createDeleteForm($this->getParameter('drugID'));
    }

    public function renderDelete(int $drugID): void
    {
        $drug = $this->facade->getAllDrugs()->get($drugID);


        if (!$drug) {
            $this->error('Podcast not found');
        }
        $this->template->drug = $drug;
        $this->getComponent('deleteForm')
            ->setDefaults($drug->toArray());
    }

    public function deleteFormSucceeded(Form $form, array $data): void
    {
        $drugID = (int) $this->getParameter('drugID');

        if ($drugID) {
            $drug = $this->facade->getAllDrugs()->get($drugID);
            $drug->delete();


            $this->flashMessage('Drug has been deleted.');
        }
        else{
            $this->flashMessage('Drug not found.');
        }
        $this->forward('Drug:tablecontents');
    }

    public function actionCancelled(): void
    {
        $this->forward('Drug:tablecontents');
    }


}