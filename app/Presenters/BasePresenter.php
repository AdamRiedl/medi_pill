<?php


namespace App\Presenters;


use Nette;

class BasePresenter extends Nette\Application\UI\Presenter
{
    public function startup(): void
    {
        parent::startup();

        if (!$this->getUser()->isLoggedIn() && !$this->presenter->isLinkCurrent('Sign:in'))
        {
            $this->flashMessage('This section is forbidden until logged');
            $this->redirect("Sign:in");
        }
    }
}