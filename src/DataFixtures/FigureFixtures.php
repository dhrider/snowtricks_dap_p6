<?php

namespace App\DataFixtures;

use App\Entity\Figure;
use App\Entity\FiguresGroup;
use App\Entity\Image;
use App\Entity\Link;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\AsciiSlugger;

class FigureFixtures extends Fixture
{
    private $filesTargetDirectory;
    private $slugger;

    public function __construct($filesTargetDirectory)
    {
        $this->filesTargetDirectory = $filesTargetDirectory;
        $this->slugger = new AsciiSlugger();
    }

    public function load(ObjectManager $manager)
    {
        // Liste des groupes de figures
        $group1 = new FiguresGroup();
        $group1->setName('Grabs');
        $group2 = new FiguresGroup();
        $group2->setName('Straight airs');
        $group3 = new FiguresGroup();
        $group3->setName('Flips and inverted rotations');
        $group4 = new FiguresGroup();
        $group4->setName('Inverted hand plants');
        $group5 = new FiguresGroup();
        $group5->setName('Slides');

        $manager->persist($group1);
        $manager->persist($group2);
        $manager->persist($group3);
        $manager->persist($group4);
        $manager->persist($group5);

        // Figure 1
        $figure1 = new Figure();
        $figure1->setName('Bloody Dracula');
        $figure1->setDescription('A trick in which the rider grabs the tail of the board with both hands. The rear hand grabs the board as it would do it during a regular tail-grab but the front hand blindly reaches for the board behind the riders back.');
        $figure1->setSlug($this->slugger->slug('Bloody Dracula'));
        $figure1->setFiguresGroup($group1);
        $link1 = new Link();
        $link1->setUrl('https://www.youtube.com/watch?v=UU9iKINvlyU');
        $figure1->addLink($link1);
        $imageName1 = uniqid().'.jpg';
        $image1 = new  Image();
        $image1->setName($imageName1);
        $image1->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboard_grabs_bloddy-dracula_01.jpg', $this->filesTargetDirectory.'/images/'.$imageName1);
        $figure1->addImage($image1);
        $imageName2 = uniqid().'.jpg';
        $image2 = new Image();
        $image2->setName($imageName2);
        $image2->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboard_grabs_bloddy-dracula_02.jpg', $this->filesTargetDirectory.'/images/'.$imageName2);
        $figure1->addImage($image2);

        $manager->persist($figure1);
        $manager->persist($link1);
        $manager->persist($image1);
        $manager->persist($image2);

        // Figure 2
        $figure2 = new Figure();
        $figure2->setName('Melon');
        $figure2->setDescription('A melon grab where the rider bones the front leg and turns the board the 45° angle.');
        $figure2->setSlug($this->slugger->slug('Melon'));
        $figure2->setFiguresGroup($group1);
        $imageName3 = uniqid().'.jpg';
        $image3 = new Image();
        $image3->setName($imageName3);
        $image3->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboard_grabs_melon_01.jpg', $this->filesTargetDirectory.'/images/'.$imageName3);
        $figure2->addImage($image3);
        $imageName4 = uniqid().'.jpg';
        $image4 = new Image();
        $image4->setName($imageName4);
        $image4->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboard_grabs_melon_02.jpg', $this->filesTargetDirectory.'/images/'.$imageName4);
        $figure2->addImage($image4);
        $imageName5 = uniqid().'.jpg';
        $image5 = new Image();
        $image5->setName($imageName5);
        $image5->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboard_grabs_melon_03.jpg', $this->filesTargetDirectory.'/images/'.$imageName5);
        $figure2->addImage($image5);

        $manager->persist($figure2);
        $manager->persist($image3);
        $manager->persist($image4);
        $manager->persist($image5);

        // Figure 3
        $figure3 = new Figure();
        $figure3->setName('Air-to-fakie');
        $figure3->setDescription('Airing straight out of a vertical transition (halfpipe, quarterpipe) and then re-entering fakie, without rotation.');
        $figure3->setSlug($this->slugger->slug('Air-to-fakie'));
        $figure3->setFiguresGroup($group2);
        $imageName6 = uniqid().'.jpg';
        $image6 = new Image();
        $image6->setName($imageName6);
        $image6->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboard_straight_air_air-to-fakie.jpg', $this->filesTargetDirectory.'/images/'.$imageName6);
        $figure3->addImage($image6);
        $imageName7 = uniqid().'.jpg';
        $image7 = new Image();
        $image7->setName($imageName7);
        $image7->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboard_straight_air_air-to-fakie_02.jpg', $this->filesTargetDirectory.'/images/'.$imageName7);
        $figure3->addImage($image7);

        $manager->persist($figure3);
        $manager->persist($image6);
        $manager->persist($image7);

        // Figure 4
        $figure4 = new Figure();
        $figure4->setName('Ollie');
        $figure4->setDescription('A trick in which the snowboarder springs off the tail of the board and into the air.');
        $figure4->setSlug($this->slugger->slug('Ollie'));
        $figure4->setFiguresGroup($group2);
        $imageName7 = uniqid().'.jpg';
        $image7 = new Image();
        $image7->setName($imageName7);
        $image7->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboard_straight_air_air-to-fakie.jpg', $this->filesTargetDirectory.'/images/'.$imageName7);
        $figure4->addImage($image7);
        $imageName8 = uniqid().'.jpg';
        $image8 = new Image();
        $image8->setName($imageName8);
        $image8->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboard_straight_air_air-to-fakie_02.jpg', $this->filesTargetDirectory.'/images/'.$imageName8);
        $figure4->addImage($image8);

        $manager->persist($figure4);
        $manager->persist($image7);
        $manager->persist($image8);

        // Figure 5
        $figure5 = new Figure();
        $figure5->setName('Boardslide');
        $figure5->setDescription('A slide performed where the riders leading foot passes over the rail on approach, with their snowboard traveling perpendicular along the rail or other obstacle. When performing a frontside boardslide, the snowboarder is facing uphill. When performing a backside boardslide, a snowboarder is facing downhill. This is often confusing to new riders learning the trick because with a frontside boardslide you are moving backward and with a backside boardslide you are moving forward.');
        $figure5->setSlug($this->slugger->slug('Boardslide'));
        $figure5->setFiguresGroup($group5);
        $imageName9 = uniqid().'.jpg';
        $image9 = new Image();
        $image9->setName($imageName9);
        $image9->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboarder_slides_boardslide_01.jpg', $this->filesTargetDirectory.'/images/'.$imageName9);
        $figure5->addImage($image9);
        $imageName10 = uniqid().'.jpg';
        $image10 = new Image();
        $image10->setName($imageName10);
        $image10->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboarder_slides_boardslide_02.jpg', $this->filesTargetDirectory.'/images/'.$imageName10);
        $figure5->addImage($image10);

        $manager->persist($figure5);
        $manager->persist($image9);
        $manager->persist($image10);

        // Figure 6
        $figure6 = new Figure();
        $figure6->setName('50-50');
        $figure6->setDescription('A slide in which a snowboarder rides straight along a rail or other obstacle.[1] This trick has its origin in skateboarding, where the trick is performed with both skateboard trucks grinding along a rail.');
        $figure6->setSlug($this->slugger->slug('50-50'));
        $figure6->setFiguresGroup($group5);
        $imageName11 = uniqid().'.jpg';
        $image11 = new Image();
        $image11->setName($imageName11);
        $image11->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboarder_slides_5050_01.jpg', $this->filesTargetDirectory.'/images/'.$imageName11);
        $figure6->addImage($image11);
        $imageName12 = uniqid().'.jpg';
        $image12 = new Image();
        $image12->setName($imageName12);
        $image12->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboarder_slides_5050_02.jpg', $this->filesTargetDirectory.'/images/'.$imageName12);
        $figure6->addImage($image12);

        $manager->persist($figure6);
        $manager->persist($image11);
        $manager->persist($image12);

        // Figure 7
        $figure7 = new Figure();
        $figure7->setName('Wildcat');
        $figure7->setDescription('A backflip performed on a straight jump, with an axis of rotation in which the snowboarder flips in a backward, cartwheel-like fashion. A double wildcat is called a supercat.');
        $figure7->setSlug($this->slugger->slug('Wildcat'));
        $figure7->setFiguresGroup($group3);
        $imageName13 = uniqid().'.jpg';
        $image13 = new Image();
        $image13->setName($imageName13);
        $image13->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboarder_flips_wildcat_01.jpg', $this->filesTargetDirectory.'/images/'.$imageName13);
        $figure7->addImage($image13);
        $imageName14 = uniqid().'.jpg';
        $image14 = new Image();
        $image14->setName($imageName14);
        $image14->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboarder_flips_wildcat_02.jpg', $this->filesTargetDirectory.'/images/'.$imageName14);
        $figure7->addImage($image14);

        $manager->persist($figure7);
        $manager->persist($image13);
        $manager->persist($image14);

        // Figure 8
        $figure8 = new Figure();
        $figure8->setName('Tamedog');
        $figure8->setDescription('A frontflip performed on a straight jump, with an axis of rotation in which the snowboarder flips in a forward, cartwheel-like fashion.');
        $figure8->setSlug($this->slugger->slug('Tamedog'));
        $figure8->setFiguresGroup($group3);
        $imageName15 = uniqid().'.jpg';
        $image15 = new Image();
        $image15->setName($imageName15);
        $image15->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboarder_flips_tamedog_01.jpg', $this->filesTargetDirectory.'/images/'.$imageName15);
        $figure8->addImage($image15);
        $imageName16 = uniqid().'.jpg';
        $image16 = new Image();
        $image16->setName($imageName16);
        $image16->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboarder_flips_tamedog_02.jpg', $this->filesTargetDirectory.'/images/'.$imageName16);
        $figure8->addImage($image16);

        $manager->persist($figure8);
        $manager->persist($image15);
        $manager->persist($image16);

        // Figure 9
        $figure9 = new Figure();
        $figure9->setName('Handplant');
        $figure9->setDescription('A 180° degree handplant in which the rear hand is planted on the lip of the wall and the rotation is frontside.');
        $figure9->setSlug($this->slugger->slug('Handplant'));
        $figure9->setFiguresGroup($group4);
        $imageName17 = uniqid().'.jpg';
        $image17 = new Image();
        $image17->setName($imageName17);
        $image17->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboarder_inverted_handplant_01.jpg', $this->filesTargetDirectory.'/images/'.$imageName17);
        $figure9->addImage($image17);
        $imageName18 = uniqid().'.jpg';
        $image18 = new Image();
        $image18->setName($imageName18);
        $image18->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboarder_inverted_handplant_02.jpg', $this->filesTargetDirectory.'/images/'.$imageName18);
        $figure9->addImage($image18);

        $manager->persist($figure9);
        $manager->persist($image17);
        $manager->persist($image18);

        // Figure 10
        $figure10 = new Figure();
        $figure10->setName('Layback');
        $figure10->setDescription('A non-inverted handplant in which the leading hand is planted during a slide. The rider literally lays back, hence the name.');
        $figure10->setSlug($this->slugger->slug('Layback'));
        $figure10->setFiguresGroup($group4);
        $imageName19 = uniqid().'.jpg';
        $image19 = new Image();
        $image19->setName($imageName19);
        $image19->setType('image/jpeg');
        copy(__DIR__. '/Images/snowboarder_inverted_layback_01.jpg', $this->filesTargetDirectory.'/images/'.$imageName19);
        $figure10->addImage($image19);

        $manager->persist($figure10);
        $manager->persist($image19);

        $manager->flush();
    }
}
