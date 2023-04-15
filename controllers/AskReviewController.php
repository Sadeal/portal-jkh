<?php
require_once "BaseTwigController.php";

class AskReviewController extends BaseTwigController
{
	public $template = "ask_review.twig";
	public $title = "Показания";


	public function getContext(): array
	{
		$context = parent::getContext();

		$sql = <<<EOL
SELECT id, title, info, phone, email, name, account, date
FROM questions
WHERE answer = 0
EOL;

		$query = $this->pdo->query($sql);

		$context['result'] = $query->fetchAll();

		return $context;
	}

	public function get(array $context)
	{
		$context['title'] = "Вопросы населения";
		parent::get($context);
	}

	public function post(array $context)
	{
		$id = $_POST['id'];

		$sql = <<<EOL
UPDATE questions
SET answer = 1
WHERE id = :id
EOL;

		$query = $this->pdo->prepare($sql);
		$query->bindValue("id", $id);
		$query->execute();

		header("Location: /askreview");
		exit;

		$this->get($context);
	}
}
