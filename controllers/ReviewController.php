<?php
require_once "BaseTwigController.php";

class ReviewController extends BaseTwigController
{
	public $template = "review.twig";
	public $title = "Показания";


	public function getContext(): array
	{
		$context = parent::getContext();

		$query = $this->pdo->query("SELECT city FROM citys");
		$context['regions'] = $query->fetchAll();

		$context['company']  = $_GET['company'];
		$city = $_GET['city'];
		$start = $_GET['start'];
		$end = $_GET['end'];
		$account = $_GET['account'];
		$name = $_GET['name'];
		if ($start == '') $start = '2000-01-01';
		if ($end == '') $end = '2100-12-31';


		if ($city == '' && $account == '' && $name == '')
			$context['message'] = 'Заполните хотя бы одно из полей';
		elseif ($city == '' && $account == '' && $name != '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE name = :name and date BETWEEN :start
AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("name", $name);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		} elseif ($city == '' && $account != '' && $name == '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE account = :account and date BETWEEN :start
AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("account", $account);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		} elseif ($city != '' && $account == '' && $name == '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE city = :city and date BETWEEN :start
AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("city", $city);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		} elseif ($city == '' && $account != '' && $name != '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE account = :account and name = :name and date BETWEEN :start
AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("account", $account);
			$query->bindValue("name", $name);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		} elseif ($city != '' && $account == '' && $name != '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE city = :city and name = :name and date BETWEEN :start
AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("city", $city);
			$query->bindValue("name", $name);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		} elseif ($city != '' && $account != '' && $name == '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE city = :city and account = :account and date BETWEEN :start
AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("city", $city);
			$query->bindValue("account", $account);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		} elseif ($city != '' && $account != '' && $name != '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE city = :city and account = :account and name = :name and date
BETWEEN :start AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("city", $city);
			$query->bindValue("account", $account);
			$query->bindValue("name", $name);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		}

		return $context;
	}

	public function get(array $context)
	{
		$context['title'] = "Показания";
		parent::get($context);
	}

	public function post(array $context)
	{

		$city = $_GET['city'];
		$start = $_GET['start'];
		$end = $_GET['end'];
		$account = $_GET['account'];
		$name = $_GET['name'];
		if ($start == '') $start = '2000-01-01';
		if ($end == '') $end = '2100-12-31';


		if ($city == '' && $account == '' && $name == '')
			$context['message'] = 'Заполните хотя бы одно из полей';
		elseif ($city == '' && $account == '' && $name != '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE name = :name and date BETWEEN :start
AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("name", $name);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		} elseif ($city == '' && $account != '' && $name == '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE account = :account and date BETWEEN :start
AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("account", $account);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		} elseif ($city != '' && $account == '' && $name == '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE city = :city and date BETWEEN :start
AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("city", $city);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		} elseif ($city == '' && $account != '' && $name != '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE account = :account and name = :name and date BETWEEN :start
AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("account", $account);
			$query->bindValue("name", $name);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		} elseif ($city != '' && $account == '' && $name != '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE city = :city and name = :name and date BETWEEN :start
AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("city", $city);
			$query->bindValue("name", $name);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		} elseif ($city != '' && $account != '' && $name == '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE city = :city and account = :account and date BETWEEN :start
AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("city", $city);
			$query->bindValue("account", $account);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		} elseif ($city != '' && $account != '' && $name != '') {
			$sql = <<<EOL
SELECT account, hot, cold, city, address, date
FROM counts
WHERE city = :city and account = :account and name = :name and date
BETWEEN :start AND :end
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("city", $city);
			$query->bindValue("account", $account);
			$query->bindValue("name", $name);
			$query->bindValue("start", $start);
			$query->bindValue("end", $end);
			$query->execute();
			$context['result'] = $query->fetchAll();
		}

		header("Content-Disposition: attachment; filename=\"Показания.xls\"");
		header("Content-Type: application/vnd.ms-excel;");
		header("Pragma: no-cache");
		header("Expires: 0");

		function filterCustomerData(&$str)
		{
			$str = preg_replace("/\t/", "\\t", $str);
			$str = preg_replace("/\r?\n/", "\\n", $str);
			if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
		}

		$column_names = false;
		// run loop through each row in $customers_data
		foreach ($context['result'] as $row) {
			if (!$column_names) {
				echo implode("\t", array_keys($row)) . "\n";
				$column_names = true;
			}
			// The array_walk() function runs each array element in a user-defined function.
			array_walk($row, 'filterCustomerData');
			echo implode("\t", array_values($row)) . "\n";
		}

		// $out = fopen("php://output", 'w');
		// foreach ($context['result'] as $data) {
		// 	fputcsv($out, $data, "\t");
		// }
		// fclose($out);

		$this->get($context);
	}
}
