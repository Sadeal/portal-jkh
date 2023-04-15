<?php
require_once "BaseTwigController.php";

class HistoryController extends BaseTwigController
{
	public $template = "history.twig";
	public $title = "История показаний";


	public function getContext(): array
	{
		$context = parent::getContext();

		$query = $this->pdo->prepare("SELECT city, hot, cold, date FROM counts WHERE account = :account");
		$query->bindValue("account", $_SESSION['account']);
		$query->execute();
		$context['counts'] = $query->fetchAll();

		return $context;
	}

	public function get(array $context)
	{
		$context['title'] = "История показаний";
		parent::get($context);
	}

	public function post(array $context)
	{
		$this->get($context);
	}
}
