<?php

namespace App\Presenters;
use Nette;
use Nette\Application\UI\Form;
use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums;
use App\Forms\DrugFormFactory;
use App\Repositories\DataRepository;
use App\Model\MediPillAuthenticator;
use App\Presenters\BasePresenter;



class DrugPresenter extends \App\Presenters\BasePresenter {


    /**
     * @inject
     * @var DataRepository
     */
    public DataRepository $dataRepository;

    /**
     * @inject
     * @var DrugFormFactory
     */

    public DrugFormFactory $drugFormFactory;


    private MediPillAuthenticator $authenticator;
    public function __construct(MediPillAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }


    public function renderTableContents(): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            // Redirect unauthenticated users to the login page or display an error message
            $this->flashMessage('You must be logged in to access this page.');
            $this->redirect('Sign:in'); // Adjust to your login page route
        } else {
            $user = $this->getUser();
            $userId = $user->getId();


            $userRoles = $this->authenticator->getUserRoleById($userId);

            foreach ($userRoles as $userRole) {

                if ($userRole->name === 'admin') {
                    $this->template->drugs = $this->dataRepository->getAllDrugs();
                    break;
                } elseif ($userRole->name === 'user') {
                    $this->template->drugs = $this->dataRepository->getAllDrugsByAccountId($userId);
                    break;
                }
            }
        }
    }

    public function renderShow($drugID): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            // Redirect unauthenticated users to the login page or display an error message
            $this->flashMessage('You must be logged in to access this page.');
            $this->redirect('Sign:in'); // Adjust to your login page route
        }else {
            $this->template->drugs = $this->dataRepository->getDrugById($drugID);
        }
    }

    public function actionAdd(): void
    {
        $form = $this->getComponent('drugForm');
        $form->onSuccess[] = [$this, 'addFormSucceeded'];
    }

    public function actionEdit(int $drugID): void
    {
        $drug = $this->dataRepository->getDrugById($drugID);
        $form = $this->getComponent('drugForm');
        $form->setDefaults($drug);
        $form->onSuccess[] = [$this, 'editFormSucceeded'];
    }

    //TODO nefunkcni confirm box udelat pres sweetjs

    public function actionDelete(int $drugID): void
    {
        $confirmed = isset($_SERVER['HTTP_X_CONFIRMED']); // Check if the confirmation header is set

        if ($confirmed) {
            $this->dataRepository->deleteDrug($drugID);
            $this->flashMessage('Drug successfully deleted.', 'success');
        } else {
            $this->flashMessage('Drug deletion canceled.', 'info');
        }

        $this->redirect('Drug:tablecontents');
    }


    protected function createComponentDrugForm(): Form
    {
      return $this->drugFormFactory->createForm($this->getAction(), $this->getParameter('drugID'));
    }


    public function addFormSucceeded(Form $form, array $data): void
    {
        $this->dataRepository->addDrug($data); // add record to database
        $drugId = $this->dataRepository->getDrugByName($data['name']);
        $user = $this->getUser();
        $this->dataRepository->addDrugAccountById($user->getId(),$drugId);
        $this->flashMessage('Successfully added');
        $this->forward('Drug:tablecontents');
    }



    public function editFormSucceeded(Form $form, array $data): void
    {
        $drugID = (int) $this->getParameter('drugID');
        $this->dataRepository->updateDrug($drugID,$data);
        $this->flashMessage('Succesfully updated');
        $this->forward('Drug:tablecontents');
    }

    public function actionCancelled(): void
    {
        $this->forward('Drug:tablecontents');
    }


}