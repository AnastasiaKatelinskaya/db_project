<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

class Category
{
    protected $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    public function show()
    {
        $em = $this->em;
        $category = $em->getRepository(\App\Entity\Category::class)->findAll();
        return $category;
    }

    public function delete()
    {
        $em = $this->em;

    }

    public function update()
    {

    }

    public function add($title, $parent = null)
    {
        $em = $this->em;
        if ($parent != null) {
            $parent = $em->getRepository(\App\Entity\Category::class)->find($parent);
        }
        if ($em->getRepository(\App\Entity\Category::class)->findBy(array('name' => $title)) == null) {
            $lat = $this->transliterateen($title);
            $category = new \App\Entity\Category();
            $category->setName($title);
            $category->setLink($lat);
            $category->setParent($parent);
            $em->persist($category);
            $em->flush();
            return $category->getId();
        } else return ['error' => 'Данная категория уже существует'];


    }

    private function transliterateen($input)
    {
        $gost = array(
            "а" => "a", "б" => "b", "в" => "v", "г" => "g", "д" => "d",
            "е" => "e", "ё" => "yo", "ж" => "j", "з" => "z", "и" => "i",
            "й" => "i", "к" => "k", "л" => "l", "м" => "m", "н" => "n",
            "о" => "o", "п" => "p", "р" => "r", "с" => "s", "т" => "t",
            "у" => "y", "ф" => "f", "х" => "h", "ц" => "c", "ч" => "ch",
            "ш" => "sh", "щ" => "sh", "ы" => "i", "э" => "e", "ю" => "u",
            "я" => "ya",
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G", "Д" => "D",
            "Е" => "E", "Ё" => "Yo", "Ж" => "J", "З" => "Z", "И" => "I",
            "Й" => "I", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
            "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
            "У" => "Y", "Ф" => "F", "Х" => "H", "Ц" => "C", "Ч" => "Ch",
            "Ш" => "Sh", "Щ" => "Sh", "Ы" => "I", "Э" => "E", "Ю" => "U",
            "Я" => "Ya",
            "ь" => "", "Ь" => "", "ъ" => "", "Ъ" => "",
            "ї" => "j", "і" => "i", "ґ" => "g", "є" => "ye",
            "Ї" => "J", "І" => "I", "Ґ" => "G", "Є" => "YE", ' ' => '_'
        );
        return strtr($input, $gost);
    }
}