<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

class Order
{
    protected $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    public function show($id)
    {
        $em = $this->em;
        $order = $em->getRepository(\App\Entity\Order::class)->find($id);
        return $order;

    }
    public function showAll()
    {
        $em = $this->em;
        $order = $em->getRepository(\App\Entity\Order::class)->findAll();
        return $order;

    }

    public function delete()
    {
        $em = $this->em;

    }

    public function update()
    {

    }

    public function add($email, $phone)
    {

        $em = $this->em;
        $basket = $em->getRepository(\App\Entity\Basket::class)->findBy(array('hash' => $_COOKIE{'userBasketId'}));
        $i = 0;
        foreach ($basket as $t) {

            $data[$i] = array(
                'product' => array(
                    'id'=>$t->getProduct()->getId(),
                    'title'=>$t->getProduct()->getTitle(),
                ),
                'attribute' =>array(
                    'title'=>$t->getAttribute()->getTitle(),
                    'price'=>$t->getAttribute()->getValue(),
                ) ,
                'quantity' => $t->getQuantity(),
            );
            $i++;
        }


        $order = new \App\Entity\Order();
        $order->setProduct($data);
        $order->setDate();
        $order->setEmail($email);
        $order->setPhone($phone);
        $em->persist($order);
        $em->flush();
        return $order->getId();

    }
}