<?php


namespace App\Service;

use App\Entity\Attributes;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class Basket
{
    protected $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    public function show()
    {
        $this->checkCookie();
        $em = $this->em;
        $basket = $em->getRepository(\App\Entity\Basket::class)->findBy(array('hash'=>$_COOKIE{'userBasketId'}));
        return $basket;
    }

    public function delete($id,$hash)
    {
        $em = $this->em;
        $basket = $em->getRepository(\App\Entity\Basket::class)->find();

    }

    public function update()
    {

        $em = $this->em;
        $this->checkCookie();
        $idProductBasket = str_replace('quantity', '', $_POST['product']);
        $basketcheck = $em->getRepository(\App\Entity\Basket::class)->findOneBy(array('hash' => $_COOKIE{'userBasketId'}, 'attribute' => $idProductBasket));
        $basketcheck->setQuantity($_POST['value']);
        $em->persist($basketcheck);
        $em->flush();
        return $basketcheck;
    }

    public function add()
    {
        $em = $this->em;
        $this->checkCookie();
        if (!empty($_POST)) {


            foreach ($_POST as $key => $value) {

                if ($value > 0) {
                    $idProductBasket = str_replace('quantity', '', $key);

                    $attributes = $em->getRepository(\App\Entity\Attribute::class)->find($idProductBasket);
                    $product = $em->getRepository(\App\Entity\Product::class)->find($idProductBasket);
                    $basketcheck = $em->getRepository(\App\Entity\Basket::class)->findOneBy(array('hash' => $_COOKIE{'userBasketId'}, 'product' => $attributes));
                    $basket = new \App\Entity\Basket();
                    if (empty($basketcheck)) {

                        $basket->setHash($_COOKIE{'userBasketId'});
                        $basket->setProduct($attributes->getProduct());
                        $basket->setAttribute($attributes);
                        $basket->setQuantity($value);

                        $em->persist($basket);
                    } else {

                        $result = $basketcheck->getQuantity() + $value;
                        $basketcheck->setQuantity($result);
                        echo $result;
                        $em->persist($basketcheck);


                    }
                }
                $em->flush();
            }
        }


    }

    private function checkCookie()
    {
        if (empty($_COOKIE{'userBasketId'})) {
            $cookie = new Cookie(
                'userBasketId',    // Cookie name.
                md5(uniqid()),    // Cookie value.
                time() + (2 * 365 * 24 * 60 * 60)    // Expires 2 years.
            );
            $res = new Response();

            $res->headers->setCookie($cookie);
            $res->send();
            return ;
        }
    }


}