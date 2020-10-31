<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
#use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;

Class LoadUserData implements FixtureInterface , ContainerAwareInterface {
  /**
  * @var ContainerInterface
  */
  private $container;
  /**
  * Load data fixtures with the passed EntityManager
  * @param ObjectManager $manager
  */
  public function load(ObjectManager $manager){
  	$user = new User();
  	$user->setUsername('admin');
  	$user->setEmail('admin@admin.com');
  	#$user->setPassword('0000');
    $encoder = $this->container->get('security.password_encoder');
    $password =$encoder->encodePassword($user,'0000');
    $user->setPassword($password);
   
    $manager->persist($user);
    $manager->flush();
  }
    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}