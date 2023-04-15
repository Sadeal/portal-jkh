<?php
require_once "BaseController.php";

class TwigBaseController extends BaseController
{
    public $title = "";
    public $template = "";
    public $urlTitle = "";
    public $image = "";
    public $info = "";
    protected \Twig\Environment $twig;

    public function setTwig($twig)
    {
        $this->twig = $twig;
    }

    public function getContext(): array
    {
        $context = parent::getContext();

        $isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));
        $isTab = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "tablet"));

        $context['template'] = $this->template;
        $context['is_logged'] = $_SESSION['is_logged'];
        $context['is_admin'] = $_SESSION['is_logged_admin'];
        $context['user_login'] = $_SESSION['login'];
        $context['is_mob'] = $isMob;
        $context['is_tab'] = $isTab;

        return $context;
    }

    public function get(array $context)
    {
        echo $this->twig->render($this->template, $context);
    }
}
