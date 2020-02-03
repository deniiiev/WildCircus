<?php

namespace App\DataFixtures;

use App\Entity\Performances;
use App\Entity\Prices;
use App\Entity\Sections;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CircusFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $performances = [
            0 => [
                'title' => 'Laugh',
                'description' => 'As an adult, come and discover our irresistible clowns, 
                between practical jokes and pranks let yourself be carried away by their 
                joy and fall back into childhood.',
                'image' => 'laugh.jpeg'
            ],
            1 => [
                'title' => 'Dream',
                'description' => 'Let yourself be carried away in a world where the real 
                and the imaginary are one, in the company of our talented magicians, 
                discover a wonderful world limited only by your imagination.',
                'image' => 'dream.jpeg'
            ],
            2 => [
                'title' => 'Marvel at',
                'description' => 'Tame the untameable in the company of our tamers,
                 between roar and razor-sharp claws, watch these fierce 
                 felines turn into sweet kittens.',
                'image' => 'marvel-at.jpeg'
            ]
        ];

        $prices = [
            0 => [
                'service' => 'Adults',
                'week' => 29,
                'weekend' => 39
            ],
            1 => [
                'service' => 'Childrens',
                'week' => 19,
                'weekend' => 29
            ],
            2 => [
                'service' => 'Groups',
                'week' => 9,
                'weekend' => 19
            ]
        ];

        $about = '<p><strong>Wild Circus</strong> – All new circus sensation presents world class acts 
        from around the globe. It brings a fresh and exiting new look to circus.
        You will be amazed and dazzled by the skill, beauty, and strength of our
        incredible international artists.&nbsp;</p><p>You will fall off your
        seats laughing at our clowns. you will gasp in awe and fear as our
        acrobats and magicians perform tricks never seen here before!</p><p>
        Award winning acts from international circus competitions make this
        show something not to be missed. “Universoul Circus” in the USA 
        describes our international award winning bicycle act as…</p><p>
        “The most amazing bicycle display you’ll ever see! 12 beautiful 
        girls performing tricks on a single bicycle in an act that combines
        aerobics, gymnastics, riding and dance… Truly incredible!” 
        Our amazing African performers will take your breath away with
        gravity defying performances.</p><p>Their ability to entertain you
        goes far beyond anything you have ever seen before. They dazzle children
        and adults alike with their zest for fun, everlasting energy and cheeky
        sense of humour. Some of our other unique acts include Teeterboard,
        Hoop Diving, human pyramids and much, much more.</p>';

        $users = [
            0 => [
                'username' => 'admin',
                'password' => 'admin',
                'role' => ['ROLE_ADMIN']
            ],
            1 => [
                'username' => 'yavuz',
                'password' => 'yavuz',
                'role' => ['ROLE_USER']
            ]
        ];

        foreach ($performances as $value) {
            $performance = new Performances();
            $performance->setTitle($value['title']);
            $performance->setDescription($value['description']);
            $performance->setImage($value['image']);
            $manager->persist($performance);
            $manager->flush();
        }

        foreach ($prices as $value) {
            $price = new Prices();
            $price->setService($value['service']);
            $price->setWeek($value['week']);
            $price->setWeekend($value['weekend']);
            $manager->persist($price);
            $manager->flush();
        }

        foreach ($users as $value) {
            $user = new User();
            $user->setUsername($value['username']);
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $value['password']
                )
            );
            $user->setRoles($value['role']);
            $manager->persist($user);
            $manager->flush();
        }

        $section = new Sections();
        $section->setTitle('About Us');
        $section->setDescription($about);
        $section->setImage('about-us.jpeg');
        $manager->persist($section);
        $manager->flush();
    }
}
