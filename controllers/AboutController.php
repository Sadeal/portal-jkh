<?php
require_once "BaseTwigController.php";

class AboutController extends BaseTwigController
{
	public $template = "about.twig";


	public function getContext(): array
	{
		$context = parent::getContext();
		$context['title'] = "О нас";

		return $context;
	}

	public function post(array $context)
	{
		$this->get($context);
	}
}
