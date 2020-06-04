<?php


namespace App\Controller;


use App\Entity\Orders;
use App\Service\Attribute;
use App\Service\Category;
use App\Service\Image;
use App\Service\News;
use App\Service\Order;
use App\Service\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\HttpClient\CurlHttpClient;

class AdminController extends AbstractController
{
    /**
     * @Route("dump", name="admin_home")//выборка
     */
    public function home(Product $product, Attribute $attribute)
    {
        set_time_limit(6000);
        $client = new CurlHttpClient();
        $response = $client->request('GET', 'http://stil-n.com/test');
        $content = $response->toArray();
        foreach ($content as $t) {
            switch ($t['categories']) {
                case 27:
                    $cat = 18;
                    break;
                case 26:
                    $cat = 17;
                    break;
                case 25:
                    $cat = 16;
                    break;
                case 23:
                    $cat = 15;
                    break;
                case 22:
                    $cat = 14;
                    break;
                case 21:
                    $cat = 13;
                    break;
                case 20:
                    $cat = 12;
                    break;
                case 19:
                    $cat = 9;
                    break;
                case 9:
                    $cat = 3;
                    break;
                case 13:
                    $cat = 6;
                    break;
                case 14:
                    $cat = 5;
                    break;
                case 15:
                    $cat = 7;
                    break;
                case 16:
                    $cat = 8;
                    break;
            }

            $idProduct = $product->add($t['title'], $t['content'], $t['image'], $t['create_date'], $cat, $t['getIsLeader'], $t['getIsspecialOffer'], $t['getIsNewItem'], $t['price']);
            if (is_int($idProduct)) {

                foreach ($t['attribute'] as $c) {
                    $attribute->add($c['title'], $c['value'], $idProduct);
                }
            }


        }
        return $this->render('admin/product/all_product.html.twig', array());
    }

    /**
     * @Route("/admin/product/show_all", name="product_show_all")
     */
    public function product_show_all(Product $product)
    {
        $content = $product->showAll();
        return $this->render('admin/product/all_product.html.twig', array('products' => $content));
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function admin(Product $product)
    {

        return $this->redirect('/admin/product/show_all');
    }
    /**
     * @Route("/admin/news/show_all", name="news_show_all")
     */
    public function news_show_all(News $news)
    {
        $news = $news->showAll();
        return $this->render('admin/news/news.html.twig', array(
            'news' => $news,
        ));
    }
    /**
     * @Route("/admin/news/add", name="news_add")
     */
    public function news_add(Request $request,News $news)
    {

        $formNews = $this->createFormBuilder()
            ->add('title', TextType::class, array('label' => false))
            ->add('text', TextType::class, array( 'label' => false))
            ->add('categories', ChoiceType::class, array( 'label' => false))
            ->add('image', FileType::class, array('label' => false))
            ->add('submit', SubmitType::class, ['label' => 'Изменить товар'])
            ->getForm();
        $formNews->handleRequest($request);
        if ($formNews->isSubmitted()) {
            $body = $formNews->getData();
            $news = $news->add();
        }
        return $this->render('admin/news/addnews.html.twig', array(
            'news' => $news,
        ));
    }
    /**
     * @Route("/admin/news/show/{id}", name="news_show")
     */
    public function news_show(News $news, $id)
    {

        $news = $news->showItem($id);
        return $this->render('admin/news/newsItem.html.twig', array(
            'news' => $news,
        ));
    }

    /**
     * @Route("/admin/product/show/{id}", name="product_show_item")
     */
    public function product_show_item($id, Product $product, Request $request, Category $category, Attribute $attribute, Image $image)
    {
        $content = $product->show($id);
        $category = $category->show();
        foreach ($category as $t) {

            $techChoices[$t->getName()] = $t->getId();

        }
        $formProduct = $this->createFormBuilder()
            ->add('name', TextType::class, array('label' => false))
            ->add('content', TextType::class, array('data' => $content->getContent(), 'label' => false))
            ->add('categories', ChoiceType::class, array('choices' => $techChoices, 'label' => false))
            ->add('image', FileType::class, array('label' => false))
            ->add('submit', SubmitType::class, ['label' => 'Изменить товар'])
            ->add('isLeader', CheckboxType::class, [
                'data' => $content->getLeader(),
                'label' => false,
                'required' => false,
            ])
            ->add('isspecialOffer', CheckboxType::class, [
                'data' => $content->getSpecialOffers(),
                'label' => false,
                'required' => false,
            ])
            ->add('isNewItem', CheckboxType::class, [
                'data' => $content->getNewItem(),
                'label' => false,
                'required' => false,
            ])
            ->getForm();
        $formProduct->handleRequest($request);
        $formAttribute = $this->createFormBuilder()
            ->add('title', TextType::class, array('label' => false))
            ->add('value', TextType::class, array('label' => false))
            ->add('submit', SubmitType::class)
            ->getForm();
        $formAttribute->handleRequest($request);
        $attributes = $attribute->show($id);
        if ($formProduct->isSubmitted()) {
            $body = $formProduct->getData();
            $imageLink = null;
            if (!empty($formProduct->get('image')->getData())) {
                $imageLink = $image->uploadImage($formProduct);
            }
            $product->update($body['title'], $body['content'], $imageLink, $body['category'], $body['isLeader'], $body['isspecialOffer'], $body['isNewItem'], $body['price']);

        }
        if ($formAttribute->isSubmitted()) {
            $body = $formProduct->getData();
            $attribute->add($body['title'], $body['value'], $id);
        }

        return $this->render('admin/product/productitem.html.twig', array(
            'product' => $content,
            'attributes' => $attributes,
            'formProduct' => $formProduct->createView(),
            'formAttribute' => $formAttribute->createView(),
        ));
    }

    /**
     * @Route("/admin/product/add", name="product_add")
     */
    public function product_add(Request $request)
    {
        $techChoices = array();
        $techChoices += ['Нет категории' => 'null'];
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, array('label' => false))
            ->add('content', TextType::class, array('label' => false))
            ->add('categories', ChoiceType::class, array('choices' => $techChoices, 'label' => false))
            ->add('image', FileType::class, array('label' => false))
            ->add('submit', SubmitType::class, ['label' => 'Изменить товар'])
            ->getForm();
        $form->handleRequest($request);

        return $this->render('admin/product/add_product.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/product/update", name="product_update")
     */
    public function product_update(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, array('label' => false))
            ->add('content', TextType::class, array('label' => false))
            ->add('categories', ChoiceType::class, array('choices' => $techChoices, 'label' => false))
            ->add('image', FileType::class, array('label' => false))
            ->add('submit', SubmitType::class, ['label' => 'Изменить товар'])
            ->getForm();
        $form->handleRequest($request);
        return $this->render('admin/product/productitem.html.twig', array(
            'formProduct' => $form->createView(),
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/product/delete/{id}", name="product_delete")
     */
    public function product_delete($id, Product $product)
    {
        $product->delete($id);
        return $this->render('admin/product/all_product.html.twig', array());
    }
//
//    /**
//     * @Route("/admin/category/show_all", name="category_show_all")
//     */
//    public function category_show_all()
//    {
//
//        return $this->render('admin/product/all_product.html.twig', array());
//    }
//
//    /**
//     * @Route("/admin/category/show", name="category_show")
//     */
//    public function category_show_item()
//    {
//
//        return $this->render('admin/product/all_product.html.twig', array());
//    }
//
//    /**
//     * @Route("/admin/category/add", name="category_add")
//     */
//    public function category_add(Request $request, Category $category)
//    {
////        $idCategory = $category->add('Все товары');
////        var_dump($idCategory);
//        return $this->render('admin/product/add_product.html.twig', array());
//    }
//
//    /**
//     * @Route("/admin/category/update", name="category_update")
//     */
//    public function category_update()
//    {
//
//        return $this->render('admin/product/all_product.html.twig', array());
//    }
//
//    /**
//     * @Route("/admin/category/delete", name="category_delete")
//     */
//    public function category_delete()
//    {
//
//        return $this->render('admin/product/all_product.html.twig', array());
//    }
    /**
     * @Route("/admin/order/show_all", name="order_show_all")
     */
    public function orders(Order $order)
    {
        $orders = $order->showAll();

        return $this->render('admin/order/order.html.twig', array(
            'orders' => $orders,
        ));
    }
    /**
     * @Route("/admin/order/{id}", name="admin/order_item")
     */
    public function order_item($id, Order $order)
    {
        $orders = $order->show($id);

        return $this->render('admin/order/orderItem.html.twig', array(
            'orders' => $orders,
        ));
    }

    /**
     * @Route("/admin/attribute/show_all", name="attribute_show_all")
     */
    public function attribute_show_all()
    {

        return $this->render('admin/product/all_product.html.twig', array());
    }

    /**
     * @Route("/admin/attribute/show", name="attribute_show")
     */
    public function attribute_show_item()
    {

        return $this->render('admin/product/all_product.html.twig', array());
    }


    /**
     * @Route("/admin/attribute/update", name="attribute_update")
     */
    public function attribute_update()
    {

        return $this->render('admin/product/all_product.html.twig', array());
    }

    /**
     * @Route("/admin/attribute/delete/{id}", name="attribute_delete")
     */
    public function attribute_delete($id, Attribute $attribute)
    {
        $attribute->delete($id);
        return $this->render('admin/product/all_product.html.twig', array());
    }
}