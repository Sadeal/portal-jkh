<?php

class LoginRequiredUserMiddleware extends BaseMiddleware
{
	public function apply(BaseController $controller, array $context)
	{
		if ($_SESSION['is_logged'])
			if (!$_SESSION['is_logged_admin'])
				return;
			else {
				header('Location: /');
				exit;
			}
		else {
			header('Location: /login');
			exit;
		}
	}
}
