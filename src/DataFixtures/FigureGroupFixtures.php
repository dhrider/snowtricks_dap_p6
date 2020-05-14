<?php

namespace App\DataFixtures;

use App\Entity\FiguresGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FigureGroupFixtures extends Fixture implements  ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $figureGroupArray = [
            'Straight airs',
            'Grabs',
            'Flips and inverted rotations',
            'Inverted hand plants',
            'Slides',
        ];

        foreach ($figureGroupArray as $value) {
            $figureGroup = new FiguresGroup();
            $figureGroup->setName($value);
            $manager->persist($figureGroup);
        }

        $manager->flush();
    }
}
