<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS = [
        'Walking Dead' => [      
        'summary' => 'Le policier Rick Grimes se réveille après un long coma. Il découvre avec effarement que le monde, ravagé par une épidémie, est envahi par les morts-vivants.',
        'category' => 'categorie_0',
        'country' => 'france',
        'year' => '2010',
        ],  
        'The Haunting Of Hill House' => [      
        'summary' => 'Plusieurs frères et sœurs qui, enfants, ont grandi dans la demeure qui allait devenir la maison hantée la plus célèbre des États-Unis, sont contraints de se réunir pour finalement affronter les fantômes de leur passé.',      
        'category' => 'categorie_0',      
        'country' => 'france',
        'year' => '2010',
        ],  
        'American Horror Story' => [      
        'summary' => 'A chaque saison, son histoire. American Horror Story nous embarque dans des récits à la fois poignants et cauchemardesques, mêlant la peur, le gore et le politiquement correct.',      
        'category' => 'categorie_0',
        'country' => 'france',
        'year' => '2010',
        ],  
        'Love Death And Robots' => [      
        'summary' => 'Un yaourt susceptible, des soldats lycanthropes, des robots déchaînés, des monstres-poubelles, des chasseurs de primes cyborgs, des araignées extraterrestres et des démons assoiffés de sang : tout ce beau monde est réuni dans 18 courts métrages animés déconseillés aux âmes sensibles.',      
        'category' => 'categorie_0',
        'country' => 'france',
        'year' => '2010',         
        ],
    ];
    public function load(ObjectManager $manager)
    {
        $i = 0;
        foreach (self::PROGRAMS as $title => $data) {
            $program = new Program();
            $program->setTitle($title);
            $program->setSummary($data['summary']);
            $program->setCountry($data['country']);
            $program->setYear($data['year']);
            $manager->persist($program);            
            $this->addReference('program_' . $i, $program);
            //$this->addReference('walking', $program);
            $i++;            
            $program->setCategory($this->getReference('categorie_0'));
        }        
        $manager->flush();
    }
    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}