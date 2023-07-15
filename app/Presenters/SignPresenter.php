<?php

namespace App\Presenters;

use App\Repositories\DataRepository;
use Nette;
use Nette\Application\AbortException;
use Nette\Application\UI\Form;
use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums;
use App\Model\MediPillAuthenticator;
use Nette\Application\UI\Presenter;
use Nette\Security\AuthenticationException;
use App\Repositories\DatabaseRepository;
use App\Forms\SignFormFactory;

final class SignPresenter extends Nette\Application\UI\Presenter
{
    private MediPillAuthenticator $authenticator;

    public function __construct(MediPillAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * @inject
     * @var DataRepository
     */

    public DataRepository $dataRepository;

    /**
     * @inject
     * @var SignFormFactory
     */

    public SignFormFactory $signFormFactory;



    protected function createComponentSignInForm(): Form
    {
        $form = $this->signFormFactory->createSignInForm();
        $form->onSuccess[] = [$this, 'signInFormSucceeded'];
        return $form;

    }

    public function signInFormSucceeded(Form $form, \stdClass $data):void
    {

        try{
            $this->getUser()->setAuthenticator($this->authenticator)
                ->login($data->email, $data->password);
            $user = $this->getUser();
            $userId = $user->getId();

            $userRoles = $this->authenticator->getUserRoleById($userId);
            foreach ($userRoles as $userRole) {
                if ($userRole->name === 'doctor') {
                    $this->redirect('Doctor:pacientcontents');
                }
                elseif ($userRole->name === 'user') {
                    $this->redirect('Home:welcome');

                }
            }

        }catch (AuthenticationException $e) {
            $form->addError("Incorrect Email of Password");
        }
    }

    protected function createComponentSignUpForm(): Form
    {
        $form = $this->signFormFactory->createSignUpForm();
        $form->onSuccess[] = [$this, 'signUpFormSucceeded'];
        return $form;
    }

    public function signUpFormSucceeded(array $data):void
    {
        $this->authenticator->createUser($data['first_name'], $data['second_name'], $data['email'],$data['login_name'],$data['password'] ,$data['phone_primary']);
        $this->authenticator->addUserRoleById($data['login_name']);
        $this->flashMessage('Welcome you are signed up', 'success');
        $this->redirect('Home:welcome');
    }


     public function actionOut(): void
     {
         $this->getUser()->logout();
         $this->flashMessage('You have been logged out');
         $this->redirect('Home:welcome');
     }


}