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


final class SignPresenter extends Nette\Application\UI\Presenter
{
    private $authenticator;

    public function __construct(MediPillAuthenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * @inject
     * @var DataRepository
     */

    public DataRepository $dataRepository;


    public function startup(): void
    {
        parent::startup();

        if (!$this->getUser()->isLoggedIn() && !$this->presenter->isLinkCurrent('Sign:in'))
        {
            $this->flashMessage('This section is forbidden until logged');
            $this->redirect("Sign:in");
        }
    }

    //TODO factory
    protected function createComponentSigninForm(): Form
    {
        BootstrapForm::switchBootstrapVersion(Enums\BootstrapVersion::V5);
        $form = new BootstrapForm;
        $form->addEmail('email', 'email')
            ->setRequired('Please enter your email');
        $form->addPassword('password','Password')
            ->setRequired('Please enter your password');

        $form->addSubmit('send','Sign In');

        $form->onSuccess[] = [$this, 'signInFormSucceeded'];
        return $form;
    }


    public function signInFormSucceeded(Form $form, \stdClass $data):void
    {
        try{
            $this->getUser()->setAuthenticator($this->authenticator)
                ->login($data->email, $data->password);
            $this->redirect('Home:welcome');

        }catch (AuthenticationException $e) {
            $form->addError("Incorrect Email of Password");
        }
    }

    //TODO factory

    protected function createComponentSignupForm(): Form
    {
        BootstrapForm::switchBootstrapVersion(Enums\BootstrapVersion::V5);
        $form = new BootstrapForm;
        $form->addText('first_name', 'First Name: ')
            ->setRequired();
        $form->addText('second_name', 'Last Name: ')
            ->setRequired();
        $form->addEmail('email', 'Email: ')
            ->setRequired();
        $form->addText('login_name', 'Username: ')
            ->setRequired();
        $form->addText('phone_primary', 'Phone number: ')
            ->setRequired();
            $passwordInput = $form->addPassword('password', 'Password')
                ->setRequired('Please Enter a Password');
            $form->addPassword('pwd2', 'Password (verify)')->setRequired('Please Enter a password for verification')
                ->addRule($form::EQUAL, 'Password verification failed. Passwords do not match', $passwordInput);
            $form->addSubmit('send', 'Submit');
            $form->onSuccess[] = [$this, 'signupFormSucceeded'];
            return $form;
    }

    public function signupFormSucceeded(array $data):void
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