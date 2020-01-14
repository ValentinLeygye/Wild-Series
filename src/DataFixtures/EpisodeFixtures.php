<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;    
        
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $episode = new Episode();
            $episode->setTitle($faker->word);
            $episode->setNumber($faker->year($max = 'now'));
            $episode->setSummary($faker->text($maxNbChars = 200));                     
            $manager->persist($episode);
            
            $this->addReference('episode_' . $i, $episode);
            $episode->setSeason($this->getReference('season_0'));
        }
        $manager->flush();
    
    }

    public function getDependencies()
    {  
        return [SeasonFixtures::class];
    }
}
