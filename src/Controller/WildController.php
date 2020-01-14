<?php
// src/Controller/WildController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Program;
use App\Entity\Category;
use App\Entity\Season;
use App\Entity\Episode;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;

/**
 * @Route("/wild", name="wild_")
 */
Class WildController extends AbstractController
{
    /**
    * Show all rows from Program’s entity
    *
    * @Route("/", name="wild_index")
    * @return Response A response instance
    */
    public function index(): Response
    {
      $programs = $this->getDoctrine()
          ->getRepository(Program::class)
          ->findAll();

      if (!$programs) {
          throw $this->createNotFoundException(
          'No program found in program\'s table.'
          );
      }     

      return $this->render(
              'wild/index.html.twig',
              ['programs' => $programs]
      );
    }

    /**
    * @param string $slug The slugger
    * @Route("/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show")
    * @return Response
    */
    public function show(?string $slug):Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with '.$slug.' title, found in program\'s table.'
            );
        }

        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug'  => $slug,
        ]);
    }
    
    /**
    * @Route("/category/{categoryName<^[a-z-]+$>}", defaults={"categoryName" = null}, name="show_category")
    */
    public function showByCategory(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository)
    {
        $category = $categoryRepository->findBy(
             ['name' => $categoryName]
        );

        $programs = $programRepository->findBy(
            ['category' => $category],
            ['id' => 'DESC'],
            3,
            0            
       );

        return $this->render('wild/category.html.twig', [
            'categoryName' => $categoryName,
            'programs' => $programs
        ]);
    }

    /**
    * @Route("/{programName<^[a-z0-9-]+$>}", defaults={"programName" = null}, name="show_program")
    * @return Response
    */
    public function showByProgram(string $programName, SeasonRepository $seasonRepository, ProgramRepository $programRepository):Response
    {
        $programName = str_replace("-", " ", $programName);
        $programName = ucwords($programName);
        $program = $programRepository->findOneBy(
            ['title' => $programName]
        );

        
        $seasons = $seasonRepository->findBy(
            ['program' => $program],
            ['id' => 'ASC'],
            3
        );
        
        return $this->render('wild/programs.html.twig', [
            'programName' => $programName,
            'seasons' => $seasons
        ]);
    }
    
    /**
    * @Route("/season/{seasonId<[0-9]+>}", defaults={"seasonId" = null}, name="show_season")
    */

    public function showBySeason(int $seasonId, SeasonRepository $seasonRepository)
    {
        $season = $seasonRepository->findOneById($seasonId);

        $program = $season->getProgram();
        $episodes = $season->getEpisodes();

        return $this->render('wild/season.html.twig', [
          'program' => $program,
          'season' => $season,
          'episodes' => $episodes
        ]);
    }

    /**
    * @Route("/episode/{id}", name="show_episode")  
    */

    public function showByEpisode(Episode $episode): Response
    {
        $season = $episode->getSeason();
        $program = $season->getProgram();
        $hyphenizedProgramTitle = strtolower(str_replace( ' ' ,'-' ,$program->getTitle()));

        return $this->render('wild/episode.html.twig', [
            'episode' => $episode,
            'season' => $season,
            'program' => $program,
            'hyphenizedProgramTitle' => $hyphenizedProgramTitle
        ]);
    }
}