<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Models\NewsFacade;
final class HomePresenter extends Nette\Application\UI\Presenter
{

    /**
     * @inject
     * @var NewsFacade
     */
    public $facade;


    public function renderWelcome(): void
    {
        $this->template->news = $this->facade
            ->getNewsSorted();

    }


}
