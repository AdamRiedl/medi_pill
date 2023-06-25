<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Models\NewsFacade;
use Nette;
final class HomePresenter extends Nette\Application\UI\Presenter
{

    private $facade;

    public function __construct(NewsFacade $facade)
    {
        $this->facade = $facade;
    }


    public function renderWelcome(): void
    {
        $this->template->news = $this->facade
            ->getNewsSorted();

    }


}
