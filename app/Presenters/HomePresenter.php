<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Repositories\NewsRepository;
use Nette;

final class HomePresenter extends Nette\Application\UI\Presenter
{


    /**
     * @inject
     * @var NewsRepository
     */

    public NewsRepository $newsRepository;


    public function renderWelcome($newsID): void
    {
        $this->template->news = $this->newsRepository->getNewsSorted();

    }

}
