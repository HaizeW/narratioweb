<?php

namespace NarratioWeb\OeuvresBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NarratioWeb\OeuvresBundle\Entity\Epoque;
use NarratioWeb\OeuvresBundle\Entity\Genre;
use NarratioWeb\OeuvresBundle\Entity\Thematique;
use NarratioWeb\OeuvresBundle\Entity\TrancheAge;
use NarratioWeb\OeuvresBundle\Entity\Oeuvre;
use NarratioWeb\OeuvresBundle\Entity\OeuvreLitt;
use NarratioWeb\OeuvresBundle\Entity\Livre;
use NarratioWeb\OeuvresBundle\Entity\Editeur;
use NarratioWeb\OeuvresBundle\Entity\Auteur;
use NarratioWeb\OeuvresBundle\Entity\OeuvreCine;
use NarratioWeb\OeuvresBundle\Entity\Film;
use NarratioWeb\OeuvresBundle\Entity\Acteur;
use NarratioWeb\OeuvresBundle\Entity\Realisateur;
use NarratioWeb\OeuvresBundle\Entity\Type;
use NarratioWeb\OeuvresBundle\Entity\ProduitDer;
use NarratioWeb\OeuvresBundle\Entity\Image;

class Oeuvres implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        /* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */
        // On déclenche l'enregistrement de toutes les données en BD */
        $manager->flush();
    }
}




?> 