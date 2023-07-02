<?php
namespace App\Repositories;

use Nette;




interface DataRepository
{
    public function getAllDrugs(): array;

    public function getAllDrugsByAccountId($aid):array;

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

    public function getAllDrugsByAccountId($aid): array
    {
        return $this->database->query(
            "select drug.id_drug, drug.name, drug.description, drug.side_effects
                from drug
                join account_drug on (drug.id_drug  = account_drug.id_drug)
                join account on (account_drug.id_account = account.id_account)
                where account.id_account = '".$aid."' "
        )
            ->fetchAll();
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

    //TODO pridat account ID a zapsat do tabulky je nutnost to osetrit pro to kdo to vytvoril
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