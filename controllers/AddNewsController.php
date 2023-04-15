<?php
require_once "BaseTwigController.php";

class AddNewsController extends BaseTwigController
{
	public $template = "add_news.twig";


	public function getContext(): array
	{
		$context = parent::getContext();
		// $query = $this->pdo->query("SELECT * FROM types");
		// $context['allTypes'] = $query->fetchAll();
		$context['title'] = "Добавить новость";

		return $context;
	}

	public function post(array $context)
	{
		$title = $_POST['title'];
		$info = $_POST['info'];
		$date = date('Y-m-d H:i:s', time() + 28800);
		$image_tmp_url = $_FILES['image']['tmp_name'];
		$image_name =  $_FILES['image']['name'];
		$image_url = "/images/news/$image_name";

		move_uploaded_file($image_tmp_url, "../public/images/news/$image_name");

		// $tmp_name = $_FILES['image']['tmp_name'];
		// $name =  $_FILES['image']['name'];
		// move_uploaded_file($tmp_name, "../public/images/$name");
		// $image_url = "/images/$name";

		$sql = <<<EOL
INSERT INTO news (title, image, info, date)
VALUES (:title, :image_url, :info, :date)
EOL;

		$query = $this->pdo->prepare($sql);
		$query->bindValue("title", $title);
		$query->bindValue("image_url", $image_url);
		$query->bindValue("info", $info);
		$query->bindValue("date", $date);

		$query->execute();

		$context['message'] = 'Вы успешно добавили новость';
		$context['id'] = $this->pdo->lastInsertId();

		$this->get($context);
	}
}
