<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{
	private $passwordEncoder;

	/**
	 * UserFixtures constructor.
	 * @param UserPasswordEncoderInterface $passwordEncoder
	 */
	public function __construct(UserPasswordEncoderInterface $passwordEncoder)
	{
		$this->passwordEncoder = $passwordEncoder;
	}

	/**
	 * @param ObjectManager $manager
	 */
	public function load(ObjectManager $manager)
    {
	    $user = new User();
	    $role = array();
	    $role[] = 'ROLE_ADMIN';
	    $user
		    ->setEmail('paulbeffa@outlook.fr')
		    ->setPassword($this->passwordEncoder->encodePassword(
				$user,
				'Loutre2049'
			))
		    ->setRoles($role);

        $manager->persist($user);

        $article = new Article();
        $article
	        ->setAuthor($user)
	        ->setTitle('Welcome to Autobahn, the Nihilist\'s blog')
	        ->setIntro('Nihilists! ..Fuck me. I mean, say what you want about the tenets of National Socialism, Dude, at least it\'s an ethos.')
	        ->setBody('Here you go, Larry. You see what happens? You see what happens, Larry?! See what happens?! [The Dude: Oh, great...] This is what happens when you fuck a stranger in the ass, Larry! [Proceeds to smash up what he wrongly believes is Larry\'s new Corvette] This is what happens, Larry! You see what happens, Larry?! Do you see what happens when you fuck a stranger in the ass, this is what happens! You see what happens, Larry?! You see what happens, Larry?! Do you see what happens, Larry, when you fuck a stranger in the ass?! This is what happens, Larry! This is what happens, Larry!')
	        ->setSlug('welcome-autobahn')
	        ->setImageFilename('')
	        ->prePersist();

		$manager->persist($article);

        $manager->flush();
    }
}
