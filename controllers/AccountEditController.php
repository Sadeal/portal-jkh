<?php
require_once "BaseTwigController.php";

class AccountEditController extends BaseTwigController
{
    public $template = "account_edit.twig";
    public $title = "Редактирование";

    public function getContext(): array
    {
        $context = parent::getContext();

        $login = $_SESSION['login'];

        $sql = <<<EOL
SELECT name, account, city, address, email, phone
FROM users
WHERE login = :login
EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindValue("login", $login);
        $query->execute();
        $context['edit'] = $query->fetch();
        $query = $this->pdo->query("SELECT city FROM citys");
        $context['regions'] = $query->fetchAll();

        $context['title'] = 'Редактирование';

        return $context;
    }

    public function post(array $context)
    {

        $name = $_POST['name'];
        $account = $_POST['account'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $sql = <<<EOL
UPDATE users
SET name = :name, account = :account, city = :city, address = :address, email = :email, phone = :phone
WHERE login = :login
EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindvalue("name", $name);
        $query->bindValue("login", $_SESSION['login']);
        $query->bindvalue("account", $account);
        $query->bindvalue("city", $city);
        $query->bindvalue("address", $address);
        $query->bindvalue("email", $email);
        $query->bindvalue("phone", $phone);
        $query->execute();

        $context['message'] = 'Данные успешно обновлены';

        $this->get($context);
    }
}
