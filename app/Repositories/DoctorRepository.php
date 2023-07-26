<?php

namespace App\Repositories;


use Nette;



interface DoctorRepositoryInt
{
    public function getAllPatientsWithoutDoctor(): array;

    public function getAllPatientsWithCurrentDoctor($doi): array;

    public function getNumberOfPatients(): Nette\Database\Row;

    public function getNUmberOfAssignedPatients(): int;

    public function getNumberOfMyPatients(): int;
}



class DoctorRepository implements DoctorRepositoryInt
{
    public function __construct(
        private Nette\Database\Explorer $database
    ){

    }

    public function getAllPatientsWithoutDoctor(): array
    {
        return $this->database->query(
            "select * from account
                left join pacient_doctor on account.id_account = pacient_doctor.id_pacient 
                where pacient_doctor.id_pacient isnull "
        )->fetchAll();
    }

    public function getAllPatientsWithCurrentDoctor($doi): array
    {
        return $this->database->query(
            "select * from account
                 left join pacient_doctor on account.id_account = pacient_doctor.id_pacient                 
                 where pacient_doctor.id_pacient notnull and pacient_doctor.id_doctor = ? ",$doi
        )->fetchAll();
    }

    public function getNumberOfPatients(): Nette\Database\Row
    {
        return $this->database->query("
        select count(*) 
        from account
        join account_role on (account.id_account = account_role.id_account)
        where account_role.id_role = 1
    "   )->fetch();
    }


    public function getNUmberOfAssignedPatients(): int
    {
        // TODO: Implement getNUmberOfAssignedPatients() method.
        return true;
    }

    public function getNumberOfMyPatients(): int
    {
        return true;
        // TODO: Implement getNumberOfMyPatients() method.
    }

}