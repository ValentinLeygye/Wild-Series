<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProgramType;
use Symfony\Component\HttpFoundation\Request;

Class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
    */
    public function index(Request $request) :Response
        {
            $form = $this->createForm(
                ProgramType::class);
                $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $newProgram = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                dump($entityManager);

                $entityManager->persist($newProgram);
                $entityManager->flush();
            }

            return $this->render('/home/home.html.twig', [
                'programForm' => $form->createView()
            ])
            ;
        }
}