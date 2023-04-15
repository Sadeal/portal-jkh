<?php
require_once "BaseTwigController.php";

class ContactsController extends BaseTwigController
{
	public $template = "contacts.twig";


	public function getContext(): array
	{
		$context = parent::getContext();
		$context['title'] = "Контакты";

		return $context;
	}

	public function post(array $context)
	{
		$this->get($context);
	}
}
