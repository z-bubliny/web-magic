<?php

namespace App\Presenters;

use App\Forms;
use ZBubliny\Model\Entity\Notification;
use Nette\Application\UI;

class SearchPresenter extends BasePresenter
{
    /** @var Forms\SearchFormFactory */
    private $searchFormFactory;

    public function __construct(Forms\SearchFormFactory $searchFormFactory)
    {
        $this->searchFormFactory = $searchFormFactory;
    }

    public function actionDefault($input) {
        $input = str_replace(' ',',', $input);
        $keywords = explode(',',$input);

        $this->template->input = $input;
        $this->template->keywords = $keywords;
    }

    protected function createComponentSearchForm(): UI\Form
    {
        return $this->searchFormFactory->create(function ($input) {
            $this->redirect('Search:', ['input' => $input]);
        });
    }

}
