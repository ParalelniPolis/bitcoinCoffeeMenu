<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Nextras\Datagrid\Datagrid;


/**
 * @property callable getMenu
 */
class MenuPresenter extends BasePresenter
{

	/** @var Model\MenuManager @inject */
	public $menuManager;

	public function renderDefault()
	{
		$this->template->menu = $this->menuManager->getAllMenuItems();
	}

}
