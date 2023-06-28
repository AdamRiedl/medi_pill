<?php


namespace App\Models;
use Nette;


final class NewsFacade
{
    public function __construct(
        private Nette\Database\Explorer $database,
    ){

    }

    public function getAllNews(){
        return $this->database
            ->table('news')
            ->select('*');

    }

    //this is used at the homepage for the first 3 news (news is not connected to any tables because it is used purely by devs)
    public function getNewsSorted(){
        return $this->database
            ->table('news')
            ->select('*')
            ->order('date_of_news DESC')
            ->limit(3);

    }
















}