<?php

namespace FantasiaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HL\FantasiaBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setPlainPassword('admin');
		$userAdmin->setNombre('admin');
		$userAdmin->setApellido('admin');  
		$userAdmin->setDni('21785949');
		$userAdmin->setEmail('zurdolarrondo@hotmail.com');
		$userAdmin->setEnabled(true);

        $manager->persist($userAdmin);
        $manager->flush();
    }
}
?>