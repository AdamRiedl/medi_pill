<?php

namespace App\Forms;

use Nette\Application\UI\Form;
use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums;

/*
Class: SignFormFactory
Třída která má za účel vytvářet formuláře pro sign-in a sign-on
*/
class SignFormFactory
{

    //Function: createSignInForm
    // funkce vrací Form který se zkládá pouze z hesla a emailu protože nic jiného taky na login není potřeba
    public static function createSignInForm() : Form
    {
        //TODO add forgot password
        BootstrapForm::switchBootstrapVersion(Enums\BootstrapVersion::V5);
        $form = new BootstrapForm;
        $form->addEmail('email', 'email')
            ->setRequired('Please enter your email');
        $form->addPassword('password','Password')
            ->setRequired('Please enter your password');

        $form->addSubmit('send','Sign In');

        return $form;
    }


    //Function: createSignUpForm
    //vrací Form který obsahuje všechny nutné věci pro úspěšnou registraci
    public static function createSignUpForm(): Form
    {
        BootstrapForm::switchBootstrapVersion(Enums\BootstrapVersion::V5);
        $form = new BootstrapForm;
        $form->addText('first_name', 'First Name: ')
            ->setRequired();
        $form->addText('second_name', 'Last Name: ')
            ->setRequired();
        //TODO unique using ajax
        $form->addEmail('email', 'Email: ')
            ->setRequired();
        //TODO unique using ajax
        $form->addText('login_name', 'Username: ')
            ->setRequired();
        $form->addText('phone_primary', 'Phone number: ')
            ->setRequired();
        $passwordInput = $form->addPassword('password', 'Password')
            ->setRequired('Please Enter a Password');
        $form->addPassword('pwd2', 'Password (verify)')->setRequired('Please Enter a password for verification')
            ->addRule($form::EQUAL, 'Password verification failed. Passwords do not match', $passwordInput);
        $form->addSubmit('send', 'Submit');


        return $form;
    }

}


