<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;
use Tracy\Debugger;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		$router[] = new Route('<presenter>[/<action>[/<id>]]', [
			'presenter' => 'Menu',
			'action' => 'default',
			'id' => NULL
		]);

		if ($_SERVER['SERVER_NAME'] != 'localhost') {
			Debugger::barDump('turning default secured flasgs on');
			Route::$defaultFlags = Route::SECURED;
		}

		return $router;
	}

}
