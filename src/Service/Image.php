<?php


namespace App\Service;


use Doctrine\ORM\EntityManagerInterface;

class Image
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

    public function delete()
    {
        $em = $this->em;

    }

    public function update()
    {

    }
    private function generateUniqueFileName()
    {
        // md5() уменьшает схожесть имён файлов, сгенерированных
        // uniqid(), которые основанный на временных отметках
        return md5(uniqid());
    }
    public function uploadImage($form)
    {
        $file = $form->get('image')->getData();

        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
        // перемещает файл в каталог, где хранятся изображения
        $file->move(
            $this->getParameter('image_directory_server'),
            $fileName
        );
        $result = $this->getParameter('image_directory') . '/' . $fileName;
        return $result;
    }

}