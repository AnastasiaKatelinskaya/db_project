<?php

namespace App\Controller;

use App\Service\Attribute;
use App\Service\Basket;
use App\Service\Category;
use App\Service\Order;
use App\Service\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(Product $product, Category $category)
    {
        $leader = $product->show('', '', 'true');
        $newItem = $product->show('', '', '', '', 'true');
        $specialOffers = $product->show('', '', '', 'true');
        $categories = $category->show();
        return $this->render('home/index.html.twig', array(
            'categories' => $categories,
            'specialOffers' => $specialOffers,
            'newItem' => $newItem,
            'leader' => $leader,
        ));
    }
    public function categories(){
        $category= new Category($this->getDoctrine()->getManager());
        $categories = $category->show();
        return $categories;
    }

    /**
     * @Route("/catalog/{link}", name="catalog_category")
     */
    public function catalog(Product $product, $link, Category $category)
    {
        $categories = $category->show();
        $products = $product->show('', $link);

        return $this->render('home/product/products.html.twig', array(
            'products' => $products,
            'categories' => $categories,
        ));
    }

    /**
     * @Route("/catalog/{link}/product/{id}", name="product_show")
     */
    public function productShow(Basket $basket,Request $request, Product $product, $link, $id, Attribute $attribute)
    {

        $products = $product->show($id);
        $attribute = $attribute->show($id);
        $products_recommend = $product->show('', $link);
        if($request->getContent()){
            $basket->add();
        }
        return $this->render('home/product/productitem.html.twig', array(

            'products' => $products,
            'products_recommend' => $products_recommend,
            'attributes' => $attribute,
        ));
    }

    /**
     * @Route("/setbasket", name="setBasket")
     */
    public function setBasket(Basket $basket)
    {

        $basket->add();
    }

    /**
     * @Route("/basket", name="getBasket")
     */
    public function getBasket(Basket $basket)
    {

        $baskets = $basket->show();
        $content = $this->renderView('home/_basket.html.twig', array(
            'baskets' => $baskets,
        ));
        return new Response($content);
    }

    /**
     * @Route("/updatebasket", name="setBasket")
     */
    public function updateBasket(Basket $basket)
    {

        $basket->update();
    }

    /**
     * @Route("/createOrder", name="setOrder")
     */
    public function setOrder(Order $order)
    {

        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $phone = preg_replace('/[^ a-zа-яё\d]/ui', '', $_POST['phone']);
            $order->add($_POST['email'], $phone);
        }

    }

    /**
     * @Route("/news", name="news")
     */
    public function news()
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository(News::class)->findall();


        return $this->render('home/news.html.twig', array(
            'news' => $news,

        ));
    }

    /**
     * @Route("/news/{id}", name="newsItem")
     */
    public function newsItem($id)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository(News::class)->find($id);


        return $this->render('home/newsItem.html.twig', array(
            'news' => $news,

        ));
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('home/about.html.twig', array());
    }

    /**
     * @Route("/paymentAndDelivery", name="paymentAndDelivery")
     */
    public function paymentAndDelivery()
    {
        return $this->render('home/paymentAndDelivery.html.twig', [
        ]);
    }
    /**
     * @Route("/wholesalePrice", name="wholesalePrice")
     */
    public function wholesalePrice()
    {
        return $this->render('home/wholesalePrice.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    /**
     * @Route("/policy", name="sendingApplication")
     */
    public function policy()
    {
        return $this->render('home/policy.html.twig', array());

    }

}