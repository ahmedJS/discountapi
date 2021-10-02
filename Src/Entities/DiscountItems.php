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
 * @ORM\Column(type="string")
 */
private $token;

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

/**
 * Get the value of discount_ratue
 *
 * @return  integer
 */ 
public function getDiscount_ratue()
{
return $this->discount_ratue;
}

/**
 * Set the value of discount_ratue
 *
 * @param  integer  $discount_ratue
 *
 * @return  self
 */ 
public function setDiscount_ratue($discount_ratue)
{
$this->discount_ratue = $discount_ratue;

return $this;
}

/**
 * Get the value of iat
 *
 * @return  DateTime
 */ 
public function getIat()
{
return $this->iat;
}

/**
 * Set the value of iat
 *
 * @param  DateTime  $iat
 *
 * @return  self
 */ 
public function setIat(\DateTime $iat)
{
$this->iat = $iat;

return $this;
}

/**
 * Get the value of nbf
 *
 * @return  DateTime
 */ 
public function getNbf()
{
return $this->nbf;
}

/**
 * Set the value of nbf
 *
 * @param  DateTime  $nbf
 *
 * @return  self
 */ 
public function setNbf(\DateTime $nbf)
{
$this->nbf = $nbf;

return $this;
}

/**
 * Get the value of active_state
 */ 
public function getActive_state()
{
return $this->active_state;
}

/**
 * Set the value of active_state
 *
 * @return  self
 */ 
public function setActive_state($active_state)
{
$this->active_state = $active_state;

return $this;
}

/**
 * Get the value of id
 */ 
public function getId()
{
return $this->id;
}

/**
 * Get the value of token
 */ 
public function getToken()
{
return $this->token;
}

/**
 * Set the value of token
 *
 * @return  self
 */ 
public function setToken($token)
{
$this->token = $token;

return $this;
}
}
