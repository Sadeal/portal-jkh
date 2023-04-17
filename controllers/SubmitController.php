<?php
require_once "BaseTwigController.php";

class SubmitController extends BaseTwigController
{
	public $template = "submit.twig";


	public function getContext(): array
	{
		$context = parent::getContext();

		$query = $this->pdo->query("SELECT date FROM counts WHERE account = " . $_SESSION['account']);
		$arr = $query->fetchAll();
		$last_date = $arr[sizeof($arr) - 1][0];

		$currentDate = strtotime(date('Y-m-d H:i:s', time() + 18000));
		$userLastActivity = strtotime($last_date);
		if (round(abs($currentDate - $userLastActivity) / 60) < 5) {
			$context['message'] = 'Слишком много запросов, зайдите позже!';
			$context['type'] = 'info';
		} else {
			$context['city'] = $_SESSION['city'];

			$query = $this->pdo->query("SELECT city FROM citys");

			$context['regions'] = $query->fetchAll();
			$context['title'] = "Подача показаний";
		}

		return $context;
	}

	public function post(array $context)
	{
		$query = $this->pdo->query("SELECT date FROM counts WHERE account = " . $_SESSION['account']);
		$arr = $query->fetchAll();
		$last_date = $arr[sizeof($arr) - 1][0];

		$currentDate = strtotime(date('Y-m-d H:i:s', time() + 18000));
		$userLastActivity = strtotime($last_date);
		if (round(abs($currentDate - $userLastActivity) / 60) < 5) {
			$context['message'] = 'Слишком много запросов, зайдите позже!';
			$context['type'] = 'info';
		} else {

			$cold = $_POST['cold'];
			$hot = $_POST['hot'];

			while ($cold[0] == '0') {
				$cold = substr($cold, 1);
			}

			while ($hot[0] == '0') {
				$hot = substr($hot, 1);
			}

			if (is_numeric($cold) and is_numeric($hot)) {
				$account = $_SESSION['account'];
				$city = $_SESSION['city'];
				$address = $_SESSION['address'];
				$name = $_SESSION['name'];
				$date = date('Y-m-d H:i:s', time() + 18000);

				$sql = <<<EOL
INSERT INTO counts (account, name, hot, cold, city, address, date)
VALUES (:account, :name, :hot, :cold, :city, :address, :date)
EOL;

				$query = $this->pdo->prepare($sql);
				$query->bindValue("account", $account);
				$query->bindValue("name", $name);
				$query->bindValue("hot", $hot);
				$query->bindValue("cold", $cold);
				$query->bindValue("city", $city);
				$query->bindValue("address", $address);
				$query->bindValue("date", $date);

				$query->execute();

				$context['message'] = 'Вы успешно подали данные!';
				$context['type'] = 'info';
				$context['id'] = $this->pdo->lastInsertId();
			} else {
				$context['message'] = 'Введенны некоректные данные';
				$context['type'] = 'danger';
			}
		}

		$this->get($context);
	}
}
