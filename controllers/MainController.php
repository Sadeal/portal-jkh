<?php
require_once "BaseTwigController.php";

class MainController extends BaseTwigController
{
    public $template = "main.twig";
    public $title = "Главная";

    public function getContext(): array
    {
        $context = parent::getContext();


        $size = $this->pdo->query("SELECT count(id) FROM news");

        $context['size'] = $size->fetchAll()[0][0] / 10;

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if ($page && is_numeric($page)) {
            if ($page - 1 > $context['size'] || $page <= 0) {
                header("Location: /?page=1");
                exit;
            }
        } else {
            header("Location: /?page=1");
            exit;
        }
        $first = $page * 10 - 10;

        $query = $this->pdo->query("SELECT * FROM news ORDER BY id desc LIMIT $first, 10");

        $context['news'] = $query->fetchAll();
        $context['is_admin'] = $_SESSION['is_logged_admin'];
        $context['title'] = 'Главная';

        return $context;
    }
}
