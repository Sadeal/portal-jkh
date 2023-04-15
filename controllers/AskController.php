<?php
require_once "BaseTwigController.php";

class AskController extends BaseTwigController
{
	public $template = "ask.twig";


	public function getContext(): array
	{
		$context = parent::getContext();
		// $query = $this->pdo->query("SELECT * FROM types");
		// $context['allTypes'] = $query->fetchAll();
		$context['title'] = "Задать вопрос";

		return $context;
	}

	public function post(array $context)
	{
		$login = $_SESSION['login'];

		$check = $this->pdo->prepare('SELECT phone, email, name, account FROM users WHERE login = :login');
		$check->bindValue("login", $login);
		$check->execute();
		$result = $check->fetch();

		$title = $_POST['title'];
		$info = $_POST['info'];
		$phone = $result['phone'];
		$email = $result['email'];
		$name = $result['name'];
		$account = $result['account'];
		$date = date('Y-m-d H:i:s', time() + 28800);

		// $tmp_name = $_FILES['image']['tmp_name'];
		// $name =  $_FILES['image']['name'];
		// move_uploaded_file($tmp_name, "../public/images/$name");
		// $image_url = "/images/$name";

		$sql = <<<EOL
INSERT INTO questions (title, info, phone, email, name, account, date)
VALUES (:title, :info, :phone, :email, :name, :account, :date)
EOL;

		$query = $this->pdo->prepare($sql);
		$query->bindValue("title", $title);
		// $query->bindValue("image_url", $image_url);
		$query->bindValue("info", $info);
		$query->bindValue("phone", $phone);
		$query->bindValue("email", $email);
		$query->bindValue("name", $name);
		$query->bindValue("account", $account);
		$query->bindValue("date", $date);

		$query->execute();

		$context['message'] = 'Вы успешно задали вопрос, вам ответят звонком на телефон или письмом на почту';

		$this->get($context);
	}
}
