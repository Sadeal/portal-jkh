<?php
require_once "BaseTwigController.php";

class AuthController extends BaseTwigController
{
	public $template = "auth.twig";


	public function getContext(): array
	{
		$context = parent::getContext();
		if ($_GET['action'] == 'exit') {
			$_SESSION['is_logged'] = false;
			$_SESSION['is_logged_admin'] = false;
			$_SESSION['user_login'] = '';
			$_SESSION['name'] = '';
			$_SESSION['account'] = '';
			$_SESSION['city'] = '';
			$_SESSION['phone'] = '';
			$_SESSION['email'] = '';
			$_SESSION['address'] = '';
			$_SESSION['login'] = '';
		} else if ($_SESSION['is_logged']) {
			header('Location: /');
		}
		return $context;
	}

	public function post(array $context)
	{
		$login = $_POST['login'];
		$pass = $_POST['pass'];

		$sql = <<<EOL
SELECT login, account, name, city, phone, email, address, type
FROM users
WHERE login = :login AND pass = :pass
EOL;
		$query = $this->pdo->prepare($sql);
		$query->bindValue("login", $login);
		$query->bindValue("pass", $pass);
		$query->execute();

		$data = $query->fetch();
		if ($login == '') {
			$context['message'] = 'Введите логин!';
		} else {
			if ($pass == '') {
				$context['message'] = 'Введите пароль!';
			} else {
				if ($data) {
					if ($data['type'] == "user") {
						$_SESSION['is_logged'] = true;
						$_SESSION['is_logged_admin'] = false;
						$_SESSION['name'] = $data['name'];
						$_SESSION['account'] = $data['account'];
						$_SESSION['city'] = $data['city'];
						$_SESSION['phone'] = $data['phone'];
						$_SESSION['email'] = $data['email'];
						$_SESSION['address'] = $data['address'];
						$_SESSION['login'] = $data['login'];
						$_SESSION['user_login'] = $data['login'];
						$context['message'] = null;
						header("Location: /account");
					} else {
						if ($data['type'] == "admin") {
							$_SESSION['is_logged'] = true;
							$_SESSION['is_logged_admin'] = true;
							$_SESSION['login'] = $data['login'];
							$_SESSION['user_login'] = $data['login'];
							$context['message'] = null;
							header("Location: /");
						}
					}
				} else {
					$_SESSION['is_logged'] = false;
					$_SESSION['is_logged_admin'] = false;
					$context['message'] = 'Неверный логин и/или пароль';
				}
			}
		}
		$context['logData'] = $login;
		$this->get($context);
	}
}
