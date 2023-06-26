<?php
namespace App\Forms;

use Nette\Application\UI\Form;
use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums;

class DrugFormFactory
{
//TODO the bootstrap and the form has stopped working
    public static function createForm($action, $drugID = null): Form
    {
        BootstrapForm::switchBootstrapVersion(Enums\BootstrapVersion::V5);
        $form = new BootstrapForm;

        $form->addText('name', 'Title:')
            ->setRequired();
        $form->addTextArea('description', 'Content:')
            ->setRequired();
        $form->addTextArea('side_effects', 'Side Effects:')
            ->setRequired();

        if ($action === 'add') {
            $form->addButton('placeholder', 'Save')
                ->setHtmlAttribute('hx-post', '/drug/add/')
                ->setOmitted();
        } elseif ($action === 'edit') {
            $form->addButton('placeholder', 'Save changes')
                ->setHtmlAttribute('hx-post', '/drug/edit?drugID=' . $drugID)
                ->setOmitted();
        }

        return $form;
    }
}
