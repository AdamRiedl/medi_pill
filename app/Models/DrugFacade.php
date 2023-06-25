<?php


namespace App\Models;

use Nette;

final class DrugFacade
{
    //first of all we create an instance of the database explorer using constructor injection
    public function __construct(
        private Nette\Database\Explorer $database,
    )
    {
    }

    public function getAllDrugs()
    {
        return $this->database
            ->table('drug');
    }
}