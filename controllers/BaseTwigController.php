<?php

class BaseTwigController extends TwigBaseController
{
	public function getContext(): array
	{
		$context = parent::getContext();

		return $context;
	}
}
