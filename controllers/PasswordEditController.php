<?php
require_once "BaseTwigController.php";

class PasswordEditController extends BaseTwigController
{
    public $template = "pass_edit.twig";
    public $title = "Редактирование";

    public function getContext(): array
    {
        $context = parent::getContext();

        return $context;
    }

    public function post(array $context)
    {
        $old_pass = $_POST['old'];
        $new_pass = $_POST['new'];
        $new_pass_repeat = $_POST['repeat'];
        $login = $_SESSION['login'];

        $query = $this->pdo->prepare('SELECT pass FROM users WHERE login = :login AND pass = :pass');
        $query->bindvalue("login", $login);
        $query->bindvalue("pass", $old_pass);
        $query->execute();
        $context['data'] = $query->fetch();

        if ($context['data']) {
            if ($new_pass == $new_pass_repeat && $new_pass != '' && $new_pass_repeat != '') {
                $sql = <<<EOL
UPDATE users
SET pass = :pass
WHERE login = :login
EOL;

                $query = $this->pdo->prepare($sql);
                $query->bindvalue("pass", $new_pass);
                $query->bindvalue("login", $login);
                $query->execute();

                $context['message'] = 'Пароль успешно изменён';
                $context['color'] = 'success';
            } else {
                $context['message'] = 'Новые пароли не совпадают';
                $context['color'] = 'warning';
            }
        } else {
            $context['message'] = 'Текущий пароль не совпадает';
            $context['color'] = 'danger';
        }

        $this->get($context);
    }
}
