<?php
namespace Entities;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="discount_items")
 */
class DiscountItems {
/**
 * @ORM\Id
 * @ORM\Column(type="integer")
 * @ORM\GeneratedValue(strategy="AUTO")
 */
private $id;

/**
 * @ORM\Column(type="integer")
 * @var integer
 */
private $discount_ratue;

/**
 * @ORM\Column(type="datetime")
 * @var DateTime
 */
private $iat;

/**
 * @ORM\Column(type="datetime")
 * @var DateTime
 */
private $nbf;

/**
 * @ORM\Column(type="string")
 */
private $active_state;
}
