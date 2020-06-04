<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

class Attribute
{
    protected $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    public function show($id_product)
    {
        $em = $this->em;
        $attribute = $em->getRepository(\App\Entity\Attribute::class)->findBy(array('product' => $id_product));
        return $attribute;

    }

    public function delete($id)
    {
        $em = $this->em;
        $attribute = $em->getRepository(\App\Entity\Attribute::class)->find($id);
        $em->remove($attribute);
        $em->flush();
    }

    public function update()
    {

    }

    public function add($title, $value, $idProduct)
    {

        $em = $this->em;
        $product = $em->getRepository(\App\Entity\Product::class)->find($idProduct);
        $attribute = new \App\Entity\Attribute();
        $attribute->setTitle($title);
        $attribute->setValue($value);
        $attribute->setProduct($product);
        $em->persist($attribute);
        $em->flush();
        return $attribute->getTitle();

    }
}