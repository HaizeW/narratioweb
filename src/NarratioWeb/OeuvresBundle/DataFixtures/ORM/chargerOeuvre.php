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
        

        /* ******************************************************* */
    /* Création du livre "Nos étoiles contraires" de John Green      */
        /* ******************************************************* */
        
        $oeuvreNEC = new Oeuvre();
        $oeuvreNEC -> setNom("Nos étoiles contraires")
                    -> setResume("Deux adolescents atteints de cancer, Hazel Grace et Augustus Waters, se connaissent dans un groupe de soutien. Les deux adolescents se passionnent pour un roman de Peter Van Houten, qui se termine brutalement au milieu d'une phrase. Curieux du sort des personnages, Hazel et Augustus envisagent de se rendre à Amsterdam afin de rencontrer l'auteur. Ils effectuent le voyage grâce à une fondation d'aide aux enfants malades qui se charge d'exaucer leur vœu le plus cher…")
                    -> setGenre($genreRomance)
                    -> setThematique($themeSens)
                    -> setTrancheAge($trancheAdo);
        $manager->persist($oeuvreNEC);
        
        $oeuvreLittNEC = new OeuvreLitt();
        $manager->persist($oeuvreLittNEC);
        
        $LivreNEC = new Livre();
        $LivreNEC -> setTitre("Nos étoiles contraires");
        $manager->persist($LivreNEC);
        
        $EditeurNEC = new Editeur();
        $EditeurNEC -> setNom("Nathan");
        $manager->persist($EditeurNEC);
                    
        $AuteurNEC = new Auteur();
        $AuteurNEC  -> setNom("Green")
                    -> setPrenom("John");
        $manager->persist($AuteurNEC);
        
        $OeuvreCinéNEC = new OeuvreCine();
        $manager->persist($OeuvreCiné);
        
        $FilmNEC = new Film();
        $FilmNEC -> setTitre("Nos étoiles contraires")
                  -> setDuree(133);
        $manager->persist($FilmNEC);
        
        $ActeurNEC1 = new Acteur();
        $ActeurNEC1 -> setNom("Woodley")
                    -> setPrenom("Shailene");
        $manager->persist($ActeurNEC1);
        
        $ActeurNEC2 = new Acteur();
        $ActeurNEC2 -> setNom("Elgort")
                    -> setPrenom("Ansel");
        $manager->persist($ActeurNEC2);
        
        $ActeurNEC3 = new Acteur();
        $ActeurNEC3 -> setNom("Wolff")
                    -> setPrenom("Nat");
        $manager->persist($ActeurNEC3);
        
        $RéalisateurNEC = new Realisateur();
        $RéalisateurNEC -> setNom("Boone")
                         -> setPrenom("Josh");
        $manager->persist($RéalisateurNEC);
        
        $TypeNEC = new Type();
        $TypeNEC -> setIntitule();
        $manager->persist($TypeNEC);
        
        $ImageNEC = new Image();
        $ImageNEC -> setUrl();
        $manager->persist($ImageNEC);
        
        /* ******************************************************* */
    /* Création de l'oeuvre Le Seigneur des Anneaux de J.R.R. Tolkien     */
        /* ******************************************************* */
        
        $oeuvreLOTR = new Oeuvre();
        $oeuvreLOTR -> setNom("Le Seigneur des Anneaux")
                    -> setResume("Un jeune Hobbit nommé Frodon Sacquet, hérite d'un anneau. Mais il se trouve que cet anneau est L'Anneau UNIQUE, un instrument de pouvoir absolu crée pour Sauron, le Seigneur des ténèbres, pour lui permettre de régner sur la Terre du Milieu et de réduire en esclavage ses peuples. Frodon a donc comme mission de détruire l'anneau en le jetant dans les laves de la Crevasse du Destin où l'Anneau à été forgé et ainsi le détruir pour toujours. Pour cela, Frodon sera aidé d'une Compagnie constituée d'Hobbits, d'Hommes, d'un Magicien, d'un Nain, et d'un Elfe, Un tel périple signifie s'aventurer très loin en Mordor, les terres du Seigneur des ténèbres, où est rassemblée son armée d'Orques maléfiques. La Compagnie doit non seulement combattre les forces extérieures du mal mais aussi les dissensions internes et l'influence corruptrice qu'exerce l'Anneau lui-même sur Frodon...");
        $manager->persist($oeuvreLOTR);
        
        $oeuvreLittLOTR = new OeuvreLitt();
        $manager->persist($oeuvreLittLOTR);
        
        $LivreLOTR1 = new Livre();
        $LivreLOTR1 -> setTitre("La Fraternité de l'Anneau")
                    -> setOeuvreLitt($oeuvreLittLOTR);
        $manager->persist($LivreLOTR1);
        
        $LivreLOTR2 = new Livre();
        $LivreLOTR2 -> setTitre("Les Deux Tours")
                    -> setOeuvreLitt($oeuvreLittLOTR);
        $manager->persist($LivreLOTR1);
        
        $EditeurLOTR = new Editeur();
        $EditeurLOTR -> setNom();
        $manager->persist($EditeurLOTR);
                    
        $AuteurLOTR = new Auteur();
        $AuteurLOTR -> setNom()
                    -> setPrenom();
        $manager->persist($AuteurLOTR);
        
        $OeuvreCinéLOTR = new OeuvreCine();
        $manager->persist($OeuvreCiné);
        
        $FilmLOTR = new Film();
        $FilmLOTR -> setTitre()
                  -> setDuree()
                  -> setOeuvreCine($OeuvreCinéLOTR);
        $manager->persist($FilmLOTR);
        
        $ActeurLOTR = new Acteur();
        $ActeurLOTR -> setNom()
                    -> setPrenom();
        $manager->persist($ActeurLOTR);
        
        $RéalisateurLOTR = new Realisateur();
        $RéalisateurLOTR -> setNom()
                         -> setPrenom();
        $manager->persist($RéalisateurLOTR);
        
        $TypeLOTR = new Type();
        $TypeLOTR -> setIntitule();
        $manager->persist($TypeLOTR);
        
        $ImageLOTR = new Image();
        $ImageLOTR -> setUrl();
        $manager->persist($ImageLOTR);
        

        /* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */

        // On déclenche l'enregistrement de tous les livres et de leurs auteurs en BD
        $manager->flush();
    }
}


?>