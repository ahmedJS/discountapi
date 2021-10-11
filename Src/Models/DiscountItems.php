<?php
namespace Models;

use Doctrine\ORM\EntityManagerInterface;
use Entities\DiscountItems;

class DiscountItemsModel{
    private EntityManagerInterface $em;
    
    function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    function addDiscountItem($active = "active",\int $ratue,\DateTime $iat,\DateTime $nbf,\DateTime $exp)
    {
        $discount_entity = new DiscountItems;

        // generate random tokens
        $token = $this->randomTokenGenerate();

        // set the entity information
        $discount_entity->setActive_state($active)
            ->setDiscount_ratue($ratue)
            ->setIat($iat)
            ->setNbf($nbf)
            ->setExp($exp)
            ->setToken($token);

        $this->em->persist($discount_entity);
        $this->em->flush();

        // make sure this record is inserted into database as well
        // this is more important to do

        if(1){
            return ["token" =>  $token];
        }

    }

    function randomTokenGenerate()
    {
        return md5(uniqid());
    }
}