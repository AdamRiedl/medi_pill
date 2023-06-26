<?php

namespace App\Presenters;

use Nette;
use App\Models\DrugFacade;
use App\Models\NewsFacade;
use Nette\Application\Application;

final class NewsPresenter extends Nette\Application\UI\Presenter
{
    private $facade;
    //TODO DI instead of constructor


    public function __construct(NewsFacade $facade)
    {
        $this->facade = $facade;
    }


    public function renderShow($newsID): void
    {
        $this->template->news = $this->facade
            ->getAllNews()->get($newsID);

    }
}