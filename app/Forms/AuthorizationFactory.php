<?php

namespace App\Forms;
use Nette;

// Class: AuthorizationFactory
// Třída která zajišťuje v podstatě ACL zde definujeme kdo kam může a kdo kam nemůže
class AuthorizationFactory
{
    //Function: create
    // zde definujeme 3 základní věci Role,Resources a allow nebo deny následně vrátíme ACL list na který se můžeme dotazovat jinde v kódu
    public static function create() :Nette\Security\Permission
    {
        $acl = new Nette\Security\Permission;
        $acl->addRole('user');
        $acl->addRole('doctor');
        $acl->addResource('tablecontents');
        $acl->addResource('patientcontents');

        $acl->allow('user', 'tablecontents');
        $acl->deny('user', 'patientcontents');

        $acl->deny('doctor', 'tablecontents');
        $acl->allow('doctor', 'patientcontents');

        return $acl;
    }
}