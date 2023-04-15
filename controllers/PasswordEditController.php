<?php
require_once "BaseTwigController.php";

class PasswordEditController extends BaseTwigController
{
    public $template = "pass_edit.twig";
    public $title = "Редактирование";

    public function getContext(): array
    {
        $context = parent::getContext();

        $context['temp_pass_old'] = $_SESSION['pass_old'];
        $context['temp_pass_new'] = $_SESSION['pass_new'];
        $context['temp_pass_new_repeat'] = $_SESSION['pass_new_repeat'];

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
                $_SESSION['pass_old'] = '';
                $_SESSION['pass_new'] = '';
                $_SESSION['pass_new_repeat'] = '';
            } else {
                $context['message'] = 'Новые пароли не совпадают';
                $context['color'] = 'warning';
                $_SESSION['pass_old'] = $old_pass;
                $_SESSION['pass_new'] = $new_pass;
                $_SESSION['pass_new_repeat'] = $new_pass_repeat;
            }
        } else {
            $context['message'] = 'Текущий пароль не совпадает';
            $context['color'] = 'danger';
            $_SESSION['pass_old'] = $old_pass;
            $_SESSION['pass_new'] = $new_pass;
            $_SESSION['pass_new_repeat'] = $new_pass_repeat;
        }

        $this->get($context);
    }
}
