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
SELECT name, city, address, email, phone
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
        $city = $_POST['city'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $sql = <<<EOL
UPDATE users
SET name = :name, city = :city, address = :address, email = :email, phone = :phone
WHERE login = :login
EOL;

        $query = $this->pdo->prepare($sql);
        $query->bindvalue("name", $name);
        $query->bindValue("login", $_SESSION['login']);
        $query->bindvalue("city", $city);
        $query->bindvalue("address", $address);
        $query->bindvalue("email", $email);
        $query->bindvalue("phone", $phone);
        $query->execute();

        $_SESSION['phone'] = $phone;
        $_SESSION['email'] = $email;
        $_SESSION['city'] = $city;
        $_SESSION['address'] = $address;
        $_SESSION['name'] = $name;

        $context['message'] = 'Данные успешно обновлены';

        $this->get($context);
    }
}
