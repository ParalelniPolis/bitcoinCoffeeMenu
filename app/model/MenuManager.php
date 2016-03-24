<?php

namespace App\Model;

use App\Model\Entity\Genre;
use App\Model\Entity\MenuItem;
use App\Model\Entity\Song;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Query;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Kdyby\Doctrine\QueryBuilder;
use Nette\Http\FileUpload;
use Nette\Object;
use Nette\Utils\Finder;
use Nette\Utils\Strings;
use Tracy\Debugger;

class MenuManager extends Object
{

	/** @var EntityManager */
	private $entityManager;

	/** @var EntityRepository */
	private $menuRepository;

	/** @var BitcoinPriceCalculator */
	private $bitcoinPriceCalculator;

	public function __construct(EntityManager $entityManager, BitcoinPriceCalculator $bitcoinPriceCalculator)
	{
		$this->entityManager = $entityManager;
		$this->menuRepository = $entityManager->getRepository(MenuItem::getClassName());
		$this->bitcoinPriceCalculator = $bitcoinPriceCalculator;
	}

	/**
	 * @return MenuItem[]
	 */
	public function getAllMenuItems()
	{
		/** @var MenuItem[] $items */
		$items = $this->menuRepository->findBy([], ['order' => 'ASC']);
		foreach ($items as $item) {
			$item->setPriceBitcoin($this->bitcoinPriceCalculator->getBitcoinPrice($item->getPriceCZ()));
		}
		return $items;
	}

	public function addMenuItem($name, $priceCZ)
	{
		$this->entityManager->persist(new MenuItem($name, $priceCZ, $this->getLastOrder() + 1));
		$this->entityManager->flush();
	}

	/**
	 * @param $id
	 * @return MenuItem
	 */
	public function getItem($id)
	{
		return $this->menuRepository->find($id);
	}

	public function editItem($id, $name, $priceCZ)
	{
		$item = $this->getItem($id);
		$item->setName($name);
		$item->setPriceCZ($priceCZ);
		$this->entityManager->flush();
	}

	public function deleteItem($id)
	{
		$this->entityManager->remove($this->getItem($id));
		$this->entityManager->flush();
	}

	public function getLastOrder()
	{
		$lastItem = $this->menuRepository->findOneBy([], ['order' => 'DESC']);
		return $lastItem ? $lastItem->getOrder() : 0;
	}

	public function moveItemUp($id)
	{
		$item = $this->getItem($id);
		$previous = $this->getItemWithOrder($item->getOrder() - 1);
		$previous->setOrder($item->getOrder());
		$item->setOrder($item->getOrder() - 1);
		$this->entityManager->flush();
	}
	
	public function moveItemDown($id)
	{
		$item = $this->getItem($id);
		$next = $this->getItemWithOrder($item->getOrder() + 1);
		$next->setOrder($item->getOrder());
		$item->setOrder($item->getOrder() + 1);
		$this->entityManager->flush();
	}

	/**
	 * @param $order
	 * @return MenuItem
	 */
	public function getItemWithOrder($order)
	{
		return $this->menuRepository->findOneBy(['order' => $order]);
	}
}
