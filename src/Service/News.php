<?php


namespace App\Service;

use App\Entity\Attributes;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class News
{
    protected $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    public function showItem($id)
    {
        $em = $this->em;
        $news = $em->getRepository(\App\Entity\News::class)->find($id);
        return $news;
    }
    public function showAll()
    {
        $em = $this->em;
        $news = $em->getRepository(\App\Entity\News::class)->findAll();
        return $news;
    }

    public function delete($id)
    {
        $em = $this->em;
        $news = $em->getRepository(\App\Entity\News::class)->find($id);
        $em->remove($news);
        $em->flush();

    }

    public function update($id,$title,$text)
    {
        $em = $this->em;
        $news = $em->getRepository(\App\Entity\News::class)->find($id);
        $news->setTitle($title);
        $news->setText($text);
        $em->persist($news);
        $em->flush();
    }

    public function add($title,$text)
    {
        $em = $this->em;
        $news = new \App\Entity\News();
        $news->setTitle($title);
        $news->setText($text);
        $em->persist($news);
        $em->flush();




    }



}