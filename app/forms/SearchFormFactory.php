<?php
declare(strict_types=1);

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;

class SearchFormFactory
{
    use Nette\SmartObject;

    /** @var FormFactory */
    private $factory;

    public function __construct(FormFactory $factory)
    {
        $this->factory = $factory;
    }

    public function create(callable $onSuccess): Form
    {
        $form = $this->factory->create();
        $form->addText('input')
            ->setRequired('Please enter your search term.')
            ->getControlPrototype()
            ->setAttribute('class', 'form-control');
        $form->addSubmit('submit', 'Search now!')
            ->getControlPrototype()
            ->setAttribute('class', 'btn btn-primary btn-lg');
        $form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
            $onSuccess($values->input);
        };

        return $form;
    }
}