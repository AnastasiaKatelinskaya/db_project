<?php


namespace App\Service;

use App\Entity\Attributes;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class Reviews
{
    protected $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }


    public function showItem($id)
    {
        $em = $this->em;

    }
    public function showAll()
    {
        $em = $this->em;

    }

    public function delete($id)
    {
        $em = $this->em;

    }

    public function update($id,$title,$text)
    {
        $em = $this->em;
    }

    public function add($title,$text)
    {
        $em = $this->em;
      




    }



}