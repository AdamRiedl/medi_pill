<?php


namespace app\presenters;

use Nette;



class DoctorPresenter extends Nette\Application\UI\Presenter{

    protected function startup(): void
    {
        parent::startup();
        if (!$this->getUser()->isAllowed('pacientcontents')) {
            $this->error('Forbidden', 403);
        }
    }


}