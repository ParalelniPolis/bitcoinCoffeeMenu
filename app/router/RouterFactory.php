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
		if ($_SERVER['SERVER_NAME'] != 'localhost') {
			Debugger::barDump('turning default secured flags on');
			Route::$defaultFlags = Route::SECURED;
		}

		$router = new RouteList;
		$router[] = new Route('<presenter>[/<action>[/<id>]]', [
			'presenter' => 'Menu',
			'action' => 'default',
			'id' => NULL
		]);

		return $router;
	}

}
