<?php


namespace App\Models;

use Nette;

final class DrugFacade
{
    public function __construct(
        private Nette\Database\Explorer $database,
    )
    {
    }

    public function getAllDrugs()
    {
        return $this->database
            ->table('drug')
            ->select('*');

    }
}