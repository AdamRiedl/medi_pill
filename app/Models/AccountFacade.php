<?php


namespace App\Models;

use Nette;



final class AccountFacade
{

    /*
     * @inject
     * @var Explorer
     */
    private $database;


    public function getAllAccounts(){
        return $this->database
            ->table('account');
    }
}