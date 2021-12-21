<?php

namespace App\Controller;

use App\Entity\Picture;
use App\Form\PictureType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class GaleryController extends AbstractController
{
    /**
     * @Route("/galery", name="galery")
     */
    public function index(): Response
    {
        return $this->render('galery/index.html.twig', [
            'controller_name' => 'GaleryController',
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("galery/add", name="galery_add")
     */
    public function addPicture(Request $request): Response
    {
        
        $ext_arry = ["jpg", "png", "gif", "jpeg"];
        $picture = new Picture();
        $form = $this->createForm(PictureType::class, $picture);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $picture->setCreatedAt(new \DateTimeImmutable());
            if ($picture->getPicture() !== null) {

                $file = $form->get('picture')->getData();
                $nom = $form->get('name')->getData();
                $order = $form->get('numOrder')->getData();

                $ext = $file->guessExtension();
                $size = filesize($file);

                if(in_array($ext, $ext_arry) and $size<= 50000000){
                    $picture->setSize($size);
                    $fileName =  uniqid(). '.' .$file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('images_directory'), // Le dossier dans le quel le fichier va etre charger
                            $fileName
                        );
                    } catch (FileException $e) {
                        return new Response($e->getMessage());
                    }
                    $picture->setName($nom);
                    $picture->setNumOrder($order);
                    $picture->setPicture($fileName);
                }

            }


            $em = $this->getDoctrine()->getManager(); // On récupère l'entity manager
            $em->persist($picture); // On confie notre entité à l'entity manager (on persist l'entité)
            $em->flush(); // On execute la requete

            return new Response("La photo a bien été enregistrer.");
        }

        return $this->render('galery/picture/ajouterPicture.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
