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
            ->table('news');
    }

    public function getNewsSorted(){
        return $this->database
            ->table('news')
            ->order('date_of_news DESC')
            ->limit(3);
    }
















}