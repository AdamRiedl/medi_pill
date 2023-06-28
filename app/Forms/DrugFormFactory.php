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

    public static function createDeleteForm($drugID = null) : Form
    {
        BootstrapForm::switchBootstrapVersion(Enums\BootstrapVersion::V5);
        $form = new BootstrapForm;

        $form->addButton('cancel','Cancel')
            ->setHtmlAttribute('hx-post','/drug/cancelled/')
            ->setOmitted();
        //TODO i cannot do the cancel button in delete.latte as <a></a> the cancel is normal and can be styled but the delete doesnt have any text
        $form->addButton('delete')
            ->setHtmlAttribute('hx-post','/drug/delete?drugID='.$drugID)
            ->setOmitted();

        return $form;
    }
}
