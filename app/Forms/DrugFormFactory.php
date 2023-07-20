<?php
namespace App\Forms;

// this will include the Form class, for working with Nette component Form
use Nette\Application\UI\Form;
// including BootstrapForm class, for the styles of Bootstrap form
use Contributte\FormsBootstrap\BootstrapForm;
// including the Enums class that is used to store some enumaration values from Bootsrap (version,styles etc...)
use Contributte\FormsBootstrap\Enums;

//Class: DrugFormFactory
//Třída která má za účel vytvářet formuláře abychom měli odděleno vytváření formulářů od presenteru
class DrugFormFactory
{
/*Function: createForm
Tahle funkce nám vrací formulář pro přidávání a přesměrování jednotlivých funkcí formuláře jako je add a edit, delete tam není z důvodu toho že pro delete formulář vlastně nepotřebujeme stačí nám jenom handler který se nám o deleting postará

    Parameters:
        action - Pomocí tohoto parametru předáváme formu co má vlastně dělat jestli edit nebo add
        drugId - Musíme Formu také předat na jakém léku chceme operovat tudíž mu musíme předat ID léku
*/
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
