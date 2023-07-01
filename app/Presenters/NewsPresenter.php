<?php

namespace App\Presenters;

use App\Repositories\NewsRepository;
use Nette;

final class NewsPresenter extends Nette\Application\UI\Presenter
{


    /**
     * @inject
     * @var NewsRepository
     */

    public NewsRepository $newsRepository;

    public function renderShow($newsID): void
    {
        $this->template->news = $this->newsRepository->getNewsById($newsID);
    }
}