<?php

namespace NarratioWeb\OeuvresBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NarratioWeb\UserBundle\Entity\User;

class Users implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        /* ******************************************************* */
        /* Création des users    */
        /* ******************************************************* */
        
        $user1 = new User();
        $manager->persist($user1);
        
        $user2 = new User();
        $manager->persist($user2);
        
        /* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */

        // On déclenche l'enregistrement de toutes les données en BD
		$manager->flush();
    }
}




?>