<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

class Product
{
    protected $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    public function show($id = null, $category = null, $leader = null, $specialOffers = null, $newItem = null)
    {
        $em = $this->em;
        if ($id) {
            $products = $em->getRepository(\App\Entity\Product::class)->find($id);
        }
        if ($leader) {
            $products = $em->getRepository(\App\Entity\Product::class)->findBy(array('leader' => $leader));;
        }
        if ($specialOffers) {
            $products = $em->getRepository(\App\Entity\Product::class)->findBy(array('specialOffers' => $specialOffers));;
        }
        if ($newItem) {
            $products = $em->getRepository(\App\Entity\Product::class)->findBy(array('newItem' => $newItem));;
        }

        if ($category) {
            $categories = $em->getRepository(\App\Entity\Category::class)->findBy(array('link' => $category));
            if ($categories['0']->getId() == 19) {
                $products = $em->getRepository(\App\Entity\Product::class)->findAll();

            }
            else if ($categories['0']->getId() == 1) {
                $category = $em->getRepository(\App\Entity\Category::class)->findBy(array('parent' => 1));
                $i = 0;
                $products = array();
                foreach ($category as $t) {


                    $product = $em->getRepository(\App\Entity\Product::class)->findBy(array('category' => $t->getId()));
                    $products = array_merge($product,$products);

                }

            } else {
                $products = $em->getRepository(\App\Entity\Product::class)->findBy(array('category' => $categories['0']->getId()));
            }

        }

        return $products;
    }

    public function showAll()
    {
        $em = $this->em;
        $products = $em->getRepository(\App\Entity\Product::class)->findAll();
        return $products;
    }

    public function delete($id)
    {
        $em = $this->em;
        $product = $em->getRepository(\App\Entity\Product::class)->find($id);
        $em->remove($product);
        $em->flush();
    }

    public function update($title, $content, $image = null, $category, $leader, $specialOffers, $newItem, $price)
    {
        $em = $this->em;
        $product = new \App\Entity\Product();
        $product->setTitle($title);
        $product->setContent($content);
        $product->setImage($image);
        $product->setStatus(true);
        $product->setCategory($category);
        $product->setLeader($leader);
        $product->setSpecialOffers($specialOffers);
        $product->setNewItem($newItem);
        $product->setBestseller(false);
        $product->setPrice($price);
        $em->persist($product);
        $em->flush();
    }

    public function add($title, $content, $image, $date, $category, $leader, $specialOffers, $newItem, $price)
    {
        $em = $this->em;
        if ($em->getRepository(\App\Entity\Product::class)->findBy(array('title' => $title)) == null) {
            if ($leader == null) {
                $leader = false;
            }
            if ($specialOffers == null) {
                $specialOffers = false;
            }
            if ($newItem == null) {
                $newItem = false;
            }
            if ($price == null) {
                $price = 0;
            }
            $category = $em->getRepository(\App\Entity\Category::class)->find($category);
            $product = new \App\Entity\Product();
            $product->setTitle($title);
            $product->setContent($content);
            $product->setImage($image);
            $product->setDate($date);
            $product->setStatus(true);
            $product->setCategory($category);
            $product->setLeader($leader);
            $product->setSpecialOffers($specialOffers);
            $product->setNewItem($newItem);
            $product->setBestseller(false);
            $product->setPrice($price);
            $em->persist($product);
            $em->flush();
            return $product->getId();
        }


    }
}