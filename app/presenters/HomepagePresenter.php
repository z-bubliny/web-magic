<?php

namespace App\Presenters;

use Nette\Application\UI;
use App\Forms;

class HomepagePresenter extends BasePresenter
{

    /** @var Forms\SearchFormFactory */
    private $searchFormFactory;

    public function __construct(Forms\SearchFormFactory $searchFormFactory)
    {
        $this->searchFormFactory = $searchFormFactory;
    }

    public function actionDefault() {

    }

    protected function createComponentSearchForm(): UI\Form
    {
        return $this->searchFormFactory->create(function ($input) {
            $this->redirect('Search:', ['input' => $input]);
        });
    }

}
