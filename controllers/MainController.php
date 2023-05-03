<?php
require_once "BaseTwigController.php";

class MainController extends BaseTwigController
{
    public $template = "main.twig";
    public $title = "ПОРТАЛ ЖКХ";

    public function getContext(): array
    {
        $context = parent::getContext();


        $size = $this->pdo->query("SELECT count(id) FROM news");
        $size = $size->fetchAll()[0][0] / 10;

        $context['size'] = $size > floor($size) ? floor($size) + 1 : floor($size);


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
        if ($context['size'] > 7) {
            $start = $page - 3;
            $end = $page + 2;
            if ($end >= $context['size']) {
                $start = $start - ($end - $context['size']) - 1;
                $end = $context['size'] - 1;
            }
            $context['start'] = $start;
            $context['end'] = $end;
        }
        $context['page'] = $page;

        $query = $this->pdo->query("SELECT * FROM news ORDER BY id desc LIMIT $first, 10");

        $context['news'] = $query->fetchAll();
        $context['is_admin'] = $_SESSION['is_logged_admin'];
        $context['title'] = 'Портал ЖКХ';

        return $context;
    }

    public function post(array $context)
    {
        $this->get($context);
    }
}
