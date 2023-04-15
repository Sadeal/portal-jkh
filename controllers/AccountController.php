<?php
require_once "BaseTwigController.php";

class AccountController extends BaseTwigController
{
    public $template = "account.twig";
    public $title = "Личный кабинет";

    public function getContext(): array
    {
        $context = parent::getContext();

        $context['title'] = 'Личный кабинет';

        return $context;
    }
}
