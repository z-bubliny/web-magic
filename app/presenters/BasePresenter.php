<?php

namespace App\Presenters;

use Nette;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{

    /** @var \Kdyby\Doctrine\EntityManager @inject */
    public $em;

}
