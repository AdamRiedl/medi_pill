<?php

namespace App\Model;
use Nette;

class MediPillAuthenticator implements Nette\Security\Authenticator
{
    private Nette\Database\Explorer $database;
    private Nette\Security\Passwords $passwords;
    public function __construct(
        Nette\Database\Explorer $database,
        Nette\Security\Passwords $passwords
    ){
        $this->database = $database;
        $this->passwords = $passwords;
    }

    public function authenticate(string $email, string $password): \Nette\Security\SimpleIdentity
    {
        $row = $this->database->query(
            "select account.id_account,account.email,account.password,role.name from account
                join account_role on (account.id_account = account_role.id_account)
                join role on (account_role.id_role = role.id_role)
                where account.email = ? ",$email)->fetch();


        if (!$row){
            throw new Nette\Security\AuthenticationException('User not found');
        }
        if (!$this->passwords->verify($password, $row->password)){
            throw new \Nette\Security\AuthenticationException('Invalid Password');
        }

        return new \Nette\Security\SimpleIdentity(
            $row->id_account,
            $row->name,
            ['name' => $row->email]
        );
    }

    public function createUser(string $first_name,string $second_name,string $email,string $login_name, string $password, string $phone_number){

        $this->database
            ->table('account')
            ->insert(['first_name' => $first_name, 'second_name' => $second_name,'email'=>$email,'login_name' => $login_name, 'password' => $this->passwords->hash($password), 'phone_primary'=>$phone_number]);

        return $email;
    }
    public function getUserRoleById($aid): array
    {
        return $this->database->query("
            select role.name from role
            join account_role on (account_role.id_role  = role.id_role)
            join account  on (account_role.id_account = account.id_account)
            where account.id_account = ? ",$aid)->fetchAll();
    }

    public function addUserRoleById($login_name)
    {
        $id_account = $this->database
            ->table('account')
            ->select('id_account')
            ->where('login_name', $login_name)
            ->fetch();


        $this->database
            ->table('account_role')
            ->insert([
                'id_role' => 1,
                'id_account' => $id_account,
            ]);
    }

}