<?php
require_once "BaseTwigController.php";

class Controller404 extends BaseTwigController
{
    public $template = "404.twig";
    public $title = "Страница не найдена";

    public function get(array $context)
    {
        http_response_code(404);
        parent::get($context);
    }
}
