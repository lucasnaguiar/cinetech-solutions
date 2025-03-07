<?php

namespace App\Controllers;

use App\Models\LotofacilPossibility;
use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter;

class DefaultController
{
	public function home(): string
	{
		// implement
		return sprintf('DefaultController -> index (?fun=%s)', input('fun'));
	}

	public function contact()
	{
		$game = new LotofacilPossibility();

		return json_encode($game->findById(2));
	}

	public function companies(): string
	{
		$request = SimpleRouter::request();
		$data = $request->getInputHandler()->all();

		$config = require __DIR__ . '/../../config/database.php';

		return json_encode($config);
	}

	public function notFound(): string
	{
		return 'Page not found';
	}
}
