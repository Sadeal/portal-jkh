<?php
require_once "BaseTwigController.php";

class NewsEditController extends BaseTwigController
{
	public $template = "news_edit.twig";


	public function getContext(): array
	{
		$context = parent::getContext();

		$context['title'] = 'Редактирование';

		$id = $this->params['id'];

		$query = $this->pdo->prepare("SELECT * FROM news WHERE id = :id");
		$query->bindValue("id", $id);
		$query->execute();
		$context['editObj'] = $query->fetch();

		return $context;
	}

	public function post(array $context)
	{
		$id = $this->params['id'];
		$title = $_POST['title'];
		$info = $_POST['info'];
		$update_date = date('Y-m-d H:i:s', time() + 18000);

		$image_tmp_url = $_FILES['image']['tmp_name'];
		$image_name =  $_FILES['image']['name'];
		if ($image_name) {
			$image_url = "/images/news/$image_name";

			move_uploaded_file($image_tmp_url, "../public/images/news/$image_name");

			$sql = <<<EOL
UPDATE news
SET title = :title, image = :image_url, info = :info, update_date = :update_date
WHERE id = :id
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("title", $title);
			$query->bindValue("image_url", $image_url);
			$query->bindValue("info", $info);
			$query->bindValue('update_date', $update_date);
			$query->bindValue("id", $id);

			$query->execute();
		} else {
			$sql = <<<EOL
UPDATE news
SET title = :title, info = :info, update_date = :update_date
WHERE id = :id
EOL;
			$query = $this->pdo->prepare($sql);
			$query->bindValue("title", $title);
			$query->bindValue("info", $info);
			$query->bindValue('update_date', $update_date);
			$query->bindValue("id", $id);

			$query->execute();
		}

		$context['message'] = 'Вы успешно обновили новость';
		$context['id'] = $this->pdo->lastInsertId();

		$this->get($context);
	}
}
