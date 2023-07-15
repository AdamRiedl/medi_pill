<?php

namespace App\Forms;
use Nette;

class AuthorizationFactory
{
    public static function create() :Nette\Security\Permission
    {
        $acl = new Nette\Security\Permission;
        $acl->addRole('user');
        $acl->addRole('doctor');
        $acl->addResource('tablecontents');
        $acl->addResource('pacientcontents');

        $acl->allow('user', 'tablecontents');
        $acl->deny('user', 'pacientcontents');

        $acl->deny('doctor', 'tablecontents');
        $acl->allow('doctor', 'pacientcontents');

        return $acl;
    }
}