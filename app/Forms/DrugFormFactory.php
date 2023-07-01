<?php
namespace App\Forms;

// this will include the Form class, for working with Nette component Form
use Nette\Application\UI\Form;
// including BootstrapForm class, for the styles of Bootstrap form
use Contributte\FormsBootstrap\BootstrapForm;
// including the Enums class that is used to store some enumaration values from Bootsrap (version,styles etc...)
use Contributte\FormsBootstrap\Enums;

class DrugFormFactory
{
//create form is static function that will return the instance of the createForm
    public static function createForm($action, $drugID = null): Form
    {
        BootstrapForm::switchBootstrapVersion(Enums\BootstrapVersion::V5);
        $form = new BootstrapForm;
// the raw creation of the form
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
