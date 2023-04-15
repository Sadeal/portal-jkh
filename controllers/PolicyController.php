<?php
require_once "BaseTwigController.php";

class PolicyController extends BaseTwigController
{
	public $template = "policy.twig";


	public function getContext(): array
	{
		$context = parent::getContext();
		$context['title'] = "Политика конфиденциальности и пользовательское соглашение";

		return $context;
	}

	public function post(array $context)
	{
		$this->get($context);
	}
}
