<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;    
        
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $season = new Season();
            $season->setNumber($faker->randomDigitNotNull);
            $season->setYear($faker->year($max = 'now'));
            $season->setDescription($faker->text($maxNbChars = 200));                     
            $manager->persist($season);
            
            $this->addReference('season_' . $i, $season);
            $season->setProgram($this->getReference('program_0'));
        }
        $manager->flush();
    }

    public function getDependencies()
    {  
        return [ProgramFixtures::class];
    }
}