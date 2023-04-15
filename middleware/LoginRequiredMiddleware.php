<?php

class LoginRequiredMiddleware extends BaseMiddleware
{
	public function apply(BaseController $controller, array $context)
	{
		if ($_SESSION['is_logged'])
			return;
		else {
			header('Location: /login');
			exit;
		}
	}
}
