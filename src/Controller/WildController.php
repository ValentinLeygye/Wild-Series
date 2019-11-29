<?php
// src/Controller/WildController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

Class WildController extends AbstractController
{
    /**
    * @Route("/wild",
    * name="wild_index")
    */
    public function index() :Response
    {
        return $this->render('wild/index.html.twig', [
                'website' => 'Wild Séries',
        ]);
    }

    /**
    * @Route("/list", name="list")
    */
public function list(int $page = 3): Response
    {
        return $this->render('wild/list.html.twig', ['page' => $page]);
    }

   /**
   * @Route("/wild/show/{slug<^[a-z0-9-]+$>}",
   * defaults={"slug"=null},
   * name="wild_show")
   */
public function show(string $slug): Response
   {
       return $this->render('wild/show.html.twig', ['slug' => $slug]);
   }
}