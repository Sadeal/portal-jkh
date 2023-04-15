<?php
require_once "BaseTwigController.php";

class RegisterController extends BaseTwigController
{
	public $template = "register.twig";


	public function getContext(): array
	{
		$context = parent::getContext();

		$query = $this->pdo->query("SELECT city FROM citys");

		$context['regions'] = $query->fetchAll();

		return $context;
	}

	public function post(array $context)
	{
		$login = $_POST['login'];
		$pass = $_POST['pass'];
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$city = $_POST['city'];
		$address = $_POST['address'];
		$account = $_POST['account'];
		$check = $_POST['check'];

		$sql = <<<EOL
SELECT login
FROM users
WHERE login = :login
EOL;
		$query = $this->pdo->prepare($sql);
		$query->bindValue("login", $login);
		$query->execute();

		$data = $query->fetch();
		if (!$data) {
			if ($login == '') {
				$context['message'] = 'Введите логин!';
			} else {
				if ($pass == '') {
					$context['message'] = 'Введите пароль!';
				} else {
					if ($name == '') {
						$context['message'] = 'Введите ФИО!';
					} else {
						if ($city == '') {
							$context['message'] = 'Введите название места проживания!';
						} else {
							if ($address == '') {
								$context['message'] = 'Введите адрес проживания!';
							} else {
								if ($account == '') {
									$context['message'] = 'Введите номер лицевого счёта!';
								} else {
									if (!$check) {
										$context['message'] = 'Примите соглашение об обработке персональных данных!';
									} else {
										$sql = <<<EOL
	INSERT INTO users (login, pass, name, phone, email, city, address, account, type)
	VALUES (:login, :pass, :name, :phone, :email, :city, :address, :account, :type)
	EOL;
										$query = $this->pdo->prepare($sql);
										$query->bindValue("login", $login);
										$query->bindValue("pass", $pass);
										$query->bindValue("name", $name);
										$query->bindValue("phone", $phone);
										$query->bindValue("email", $email);
										$query->bindValue("city", $city);
										$query->bindValue("address", $address);
										$query->bindValue("account", $account);
										$query->bindValue("type", 'user');
										$query->execute();
										$context['message'] = null;
										header("Location: /login");
									}
								}
							}
						}
					}
				}
			}
		} else {
			$context['message'] = 'Данный пользователь уже существует!';
		}
		$context['regData'] = [$login, $pass, $name, $phone, $email, $city, $address, $account];
		$this->get($context);
	}
}
