<?php

namespace App\Presenters;

use App\Forms\AddSongFormFactory;
use App\Forms\FormFactory;
use App\Model\AlbumCoverProvider;
use App\Model\CantDeleteException;
use App\Model\Entity\MenuItem;
use App\Model\Entity\Song;
use App\Model\GenresManager;
use App\Model\MenuManager;
use Doctrine\DBAL\DBALException;
use Nette\Application\ForbiddenRequestException;
use Nette\Application\Responses\FileResponse;
use Nette\Application\UI\Form;
use Nette\Forms\Container;
use Nette\Forms\Controls\SubmitButton;
use Nette\Http\FileUpload;
use Nextras\Datagrid\Datagrid;
use Tracy\Debugger;

class AdminMenuPresenter extends BasePresenter
{

	/** @var MenuManager @inject */
	public $menuManager;

	/** @var FormFactory @inject */
	public $formFactory;

	/** @var string */
	private $superSecretParameter;

	/** @var string @persistent */
	public $superSecretKey;

	/** @var string @persistent */
	public $editId;

	/**
	 * @param string $superSecretParameter
	 */
	public function setSuperSecretParameter($superSecretParameter)
	{
		$this->superSecretParameter = $superSecretParameter;
	}

	public function checkRequirements($element)
	{
		parent::checkRequirements($element);
		$getParameter = $this->request->getParameter('superSecretKey');
		if ($this->superSecretParameter != $getParameter) {
			throw new ForbiddenRequestException();
		}
	}

	public function actionDefault()
	{
		$this->editId = null;
	}

	public function renderDefault()
	{
		$this->template->menu = $this->menuManager->getAllMenuItems();
		$this->template->editId = $this->editId;
	}

	public function createComponentEditItem()
	{
		$form = new Form();
		$form->addText('name', 'Název')
			->setRequired('Musíte zadat název.');
		$form->addText('priceCZ', 'cena v CZ')
			->setRequired('Musíte zadat cenu v CZ');
		$form->addHidden('id', $this->editId);
		$form->addSubmit('submit', 'Uložit');
		$form->addSubmit('cancel', 'Zrušit');
		$form['submit']->onClick[] = function(SubmitButton $button) {
			$values = $button->getForm()->getValues();
			$this->menuManager->editItem($values->id, $values->name, $values->priceCZ);
		};
		$form['cancel']->onClick[] = function(SubmitButton $button) {
			$this->editId = null;
		};
		!$this->editId ?: $form->setDefaults($this->menuManager->getItem($this->editId)->toArray());
		return $form;
	}

	public function handleEdit($id)
	{
		$this->editId = $id;
		$this->redrawControl('menu');
	}

	public function handleDelete($id)
	{
		$this->menuManager->deleteItem($id);
	}

	public function handleMoveUp($id)
	{
		$this->menuManager->moveItemUp($id);
		$this->redrawControl('menu');
	}

	public function handleMoveDown($id)
	{
		$this->menuManager->moveItemDown($id);
		$this->redrawControl('menu');
	}

	public function createComponentAddItem()
	{
		$form = $this->formFactory->create();
		$form->addText('name', 'Název: ')
			->setRequired('Musíte zadat název.');
		$form->addText('priceCZ', 'cena v CZK')
			->setRequired('Musíte zadat cenu v CZK');
		$form->addSubmit('submit', 'Přidat');
		$form->onSuccess[] = function(Form $form) {
			$values = $form->getValues();
			$this->menuManager->addMenuItem($values->name, $values->priceCZ);
		};
		return $form;
	}

}
