<?php

namespace App\Presenters;

use Nette;
use App\Models\DrugFacade;
use App\Models\NewsFacade;
use Nette\Application\Application;

final class NewsPresenter extends Nette\Application\UI\Presenter
{


    /**
     * @inject
     * @var NewsFacade
     */
    public $facade;



    public function renderShow($newsID): void
    {
        $this->template->news = $this->facade
            ->getAllNews()->get($newsID);

    }
}