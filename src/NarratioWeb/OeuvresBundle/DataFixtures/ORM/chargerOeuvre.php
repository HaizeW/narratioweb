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
        /* Création des epoques     */
        /* ******************************************************* */
        
        $epoque5060 = new Epoque();
        $epoque5060->setIntitule("1950 - 1960");
        $manager->persist($epoque5060);
        
        $epoque1020 = new Epoque();
        $epoque1020->setIntitule("2010 - 2020");
        $manager->persist($epoque1020);
        
        /* ******************************************************* */
        /* Création des genres     */
        /* ******************************************************* */
        
        $genreFantastique = new Genre();
        $genreFantastique->setIntitule("Fantastique");
        $manager->persist($genreFantastique);
        
        $genreRomance = new Genre();
        $genreRomance->setIntitule("Romance");
        $manager->persist($genreRomance);
        
        /* ******************************************************* */
        /* Création des thématiques     */
        /* ******************************************************* */
        
        $themeQuete = new Thematique();
        $themeQuete->setIntitule("Quete Fantaisie");
        $manager->persist($themeQuete);
        
        $themeSens = new Thematique();
        $themeSens->setIntitule("Sens de la vie");
        $manager->persist($themeSens);
        
        /* ******************************************************* */
        /* Création des tranches d'âge     */
        /* ******************************************************* */
        
        $trancheAdulte = new TrancheAge();
        $trancheAdulte->setIntitule("Adulte");
        $manager->persist($trancheAdulte);
        
        $trancheAdo = new TrancheAge();
        $trancheAdo->setIntitule("Adolescent");
        $manager->persist($trancheAdo);
        
        /***********************************************************************************************
        ************************************************************************************************
        ************************************************************************************************/
        
        /* structure générale remplissage BDD */
        
        $oeuvreTEST = new Oeuvre();
        $oeuvreTEST -> setNom()
                    -> setResume();
        $manager->persist($oeuvreTEST);
        
        $oeuvreLittTEST = new OeuvreLitt();
        $manager->persist($oeuvreLittTEST);
        
        $LivreTEST = new Livre();
        $LivreTEST -> setTitre();
        $manager->persist($LivreTEST);
        
        $EditeurTEST = new Editeur();
        $EditeurTEST -> setNom();
        $manager->persist($EditeurTEST);
                    
        $AuteurTEST = new Auteur();
        $AuteurTEST -> setNom()
                    -> setPrenom();
        $manager->persist($AuteurTEST);
        
        $OeuvreCinéTEST = new OeuvreCine();
        $manager->persist($OeuvreCiné);
        
        $FilmTEST = new Film();
        $FilmTEST -> setTitre()
                  -> setDuree();
        $manager->persist($FilmTEST);
        
        $ActeurTEST = new Acteur();
        $ActeurTEST -> setNom()
                    -> setPrenom();
        $manager->persist($ActeurTEST);
        
        $RéalisateurTEST = new Realisateur();
        $RéalisateurTEST -> setNom()
                         -> setPrenom();
        $manager->persist($RéalisateurTEST);
        
        $TypeTEST = new Type();
        $TypeTEST -> setIntitule();
        $manager->persist($TypeTEST);
        
        $ImageTEST = new Image();
        $ImageTEST -> setUrl();
        $manager->persist($ImageTEST);
        
        
        /* ******************************************************* */
    /* Création du livre "Nos étoiles contraires" de John Green      */
        /* ******************************************************* */
        
        // ON CREE L'OEUVRE LITTERAIRE
        $oeuvreLittTFIOS = new OeuvreLitt();
                        -> 
        
        $manager->persist($oeuvreLittTFIOS);

        // ON CREE LE LIVRE -- "Nos étoiles contraires" de John Green        
        $livreNosEtoilesContraires = new Livre();
        $livreNosEtoilesContraires ->setTitre("Nos étoiles contraires");
                                    
        $livreNosEtoilesContraires->setDatePar(new \DateTime('2004/06/16')); // Attention, il faut donner une date au format mysql pour l'enregistrement en BD: AAAA/MM/JJ
      
        // On rend le livre persistant
        
        $manager->persist($livreNosEtoilesContraires);
        
        // ON CREE L'AUTEUR -- "John Green"
        $auteurJohnGreen = new Auteur();
        $auteurJohnGreen   ->setNom("Green")
                           ->setPrenom("John");

        // On rend l'auteur persistant pour pouvoir y faire référence ensuite lorsqu'on créé le livre
        $manager->persist($auteurJohnGreen);
        
        
        
        
        /* ******************************************************* */
    /* Création de l'oeuvre Le Seigneur des Anneaux de J.R.R. Tolkien     */
        /* ******************************************************* */
        

        

        /* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */

        // On déclenche l'enregistrement de tous les livres et de leurs auteurs en BD
        $manager->flush();
    }
}


?>