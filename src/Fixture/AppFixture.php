<?php


namespace App\Fixture;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;

class AppFixture extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     * @throws Exception
     */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('admin');
        $user1->setPassword('12341234');
        $user1->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $manager->persist($user1);


        $user2 = new User();
        $user2->setUsername('kek');
        $user2->setPassword('1234');
        $user2->setRoles(['ROLE_USER']);

        $manager->persist($user2);

        $manager->flush();
    }
}