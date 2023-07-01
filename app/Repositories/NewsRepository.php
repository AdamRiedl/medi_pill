<?php

namespace App\Repositories;


use Nette;


interface NewsInterface
{
    public function getNewsSorted(): array;

    //TODO i guess not ideal
    public function getNewsById($newsID): Nette\Database\Table\ActiveRow;

}


class NewsRepository implements NewsInterface
{
    public function __construct(
        private Nette\Database\Explorer $database,
    )
    {
    }

    public function getNewsSorted(): array
    {
        return $this->database
            ->table('news')
            ->select('*')
            ->order('date_of_news DESC')
            ->limit(3)
            ->fetchAll();
    }

    public function getNewsById($newsID): Nette\Database\Table\ActiveRow
    {
        return $this->database
            ->table('news')
            ->where('id_news', $newsID)
            ->fetch();
    }
}
