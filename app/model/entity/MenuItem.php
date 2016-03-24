<?php
 
namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities;
use Nette\Utils\Strings;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 */
class MenuItem extends Entities\BaseEntity
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="uuid")
	 * @ORM\GeneratedValue(strategy="NONE")
	 * @var \Ramsey\Uuid\Uuid
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", nullable=false, unique=true)
	 * @var string
	 */
	private $name;

	/**
	 * @ORM\Column(type="float")
	 * @var float
	 */
	private $priceCZ;

	/**
	 * @ORM\Column(type="float", nullable=true)
	 * @var float
	 */
	private $priceBitcoin;

	/**
	 * @ORM\Column(type="integer", name="`order`", unique=true, nullable=false)
	 * @var int
	 */
	private $order;

    public function __construct($name, $priceCZ, $order)
    {
	    $this->id = Uuid::uuid4();
    	$this->name = $name;
	    $this->priceCZ = $priceCZ;
	    $this->priceBitcoin = 0;
	    $this->order = $order;
    }

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id->toString();
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getPriceCZ()
	{
		return $this->priceCZ;
	}

	/**
	 * @return float
	 */
	public function getPriceBitcoin()
	{
		return $this->priceBitcoin;
	}

	/**
	 * @return int
	 */
	public function getOrder()
	{
		return $this->order;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param float $priceCZ
	 */
	public function setPriceCZ($priceCZ)
	{
		$this->priceCZ = $priceCZ;
	}

	/**
	 * @param float $priceBitcoin
	 */
	public function setPriceBitcoin($priceBitcoin)
	{
		$this->priceBitcoin = $priceBitcoin;
	}

	/**
	 * @param int $order
	 */
	public function setOrder($order)
	{
		$this->order = $order;
	}


	public function toArray()
	{
		return [
			'uuid' => $this->id,
			'name' => $this->name,
			'priceCZ' => $this->priceCZ
		];
	}
}

