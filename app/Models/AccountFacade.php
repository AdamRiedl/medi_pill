<?php


namespace App\Models;
use Nette;



final class AccountFacade
{
    public function __construct(
        private Nette\Database\Explorer $database,
    )
    {
    }


    public function getAllAccounts(){
        return $this->database
            ->table('account')
            ->select('*')
            ->fetchAll();
    }
}