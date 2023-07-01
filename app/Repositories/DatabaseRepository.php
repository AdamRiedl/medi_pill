<?php
namespace App\Repositories;

use Nette;




interface DataRepository
{
    public function getAllDrugs(): array;

    //TODO i guess not ideal
    public function getDrugById($drugID): Nette\Database\Table\ActiveRow;

    public function addDrug(array $data): void;

    public function updateDrug($drugID, array $data): void;

    public function deleteDrug($drugID): void;
}



class DatabaseRepository implements DataRepository
{
    public function __construct(
        private Nette\Database\Explorer $database,
    )
    {
    }
    public function getAllDrugs(): array
    {
        return $this->database
            ->table('drug')
            ->select('*')
            ->fetchAll();
    }

    public function getDrugById($drugID): Nette\Database\Table\ActiveRow
    {
        return $this->database
            ->table('drug')
            ->where('id_drug', $drugID)
            ->fetch();
    }

    public function addDrug(array $data): void
    {
        $this->database->table('drug')->insert($data);
    }

    public function updateDrug($drugID, array $data): void
    {
        $this->database->table('drug')
            ->where('id_drug',$drugID)
            ->update($data);
    }

    public function deleteDrug($drugID): void
    {
        $this->database->table('drug')
            ->where('id_drug', $drugID)
            ->delete();
    }



}