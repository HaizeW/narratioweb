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
        $themeQuete->setIntitule("Quête Fantaisie");
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
    /* Création de l'oeuvre "Nos étoiles contraires" de John Green      */
        /* ******************************************************* */
        
        $oeuvreLittNEC = new OeuvreLitt();
        $oeuvreLittNEC -> setNom("Nos étoiles contraires")
                    -> setResume("Deux adolescents atteints de cancer, Hazel Grace et Augustus Waters, se connaissent dans un groupe de soutien. Les deux adolescents se passionnent pour un roman de Peter Van Houten, qui se termine brutalement au milieu d'une phrase. Curieux du sort des personnages, Hazel et Augustus envisagent de se rendre à Amsterdam afin de rencontrer l'auteur. Ils effectuent le voyage grâce à une fondation d'aide aux enfants malades qui se charge d'exaucer leur vœu le plus cher…")
                    -> setEpoque($epoque1020)
                    -> setGenre($genreRomance)
                    -> setThematique($themeSens)
                    -> setTrancheAge($trancheAdo);
        $manager->persist($oeuvreLittNEC);
        
        $EditeurNEC = new Editeur();
         $EditeurNEC -> setNom("Nathan");
         $manager->persist($EditeurNEC);
                    
         $AuteurNEC = new Auteur();
         $AuteurNEC  -> setNom("Green")
                     -> setPrenom("John");
         $manager->persist($AuteurNEC);
         
         $LivreNEC = new Livre();
         $LivreNEC   -> setTitre("Nos étoiles contraires")
                     -> addAuteur($AuteurNEC)
                     -> setEditeur($EditeurNEC)
                     -> setOeuvreLitt($oeuvreLittNEC);
         $manager->persist($LivreNEC);
         
         $oeuvreCineNEC = new OeuvreCine();
         $oeuvreCineNEC -> setNom("Nos étoiles contraires")
                    -> setResume("Deux adolescents atteints de cancer, Hazel Grace et Augustus Waters, se connaissent dans un groupe de soutien. Les deux adolescents se passionnent pour un roman de Peter Van Houten, qui se termine brutalement au milieu d'une phrase. Curieux du sort des personnages, Hazel et Augustus envisagent de se rendre à Amsterdam afin de rencontrer l'auteur. Ils effectuent le voyage grâce à une fondation d'aide aux enfants malades qui se charge d'exaucer leur vœu le plus cher…")
                    -> setEpoque($epoque1020)
                    -> setGenre($genreRomance)
                    -> setThematique($themeSens)
                    -> setTrancheAge($trancheAdo);
         $manager->persist($oeuvreCineNEC);
         
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
         
         $TypeLongMetrage = new Type();
         $TypeLongMetrage -> setIntitule("Long Métrage");
         $manager->persist($TypeLongMetrage);
         
         $FilmNEC = new Film();
         $FilmNEC -> setTitre("Nos étoiles contraires")
                  -> setDuree(133)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurNEC)
                  -> addActeur($ActeurNEC1)
                  -> addActeur($ActeurNEC2)
                  -> addActeur($ActeurNEC3)
                  -> setOeuvreCine($oeuvreCineNEC);
         $manager->persist($FilmNEC);
         
         $ProduitDerNEC = new ProduitDer();
         $ProduitDerNEC -> setNom("Nos étoiles contraires")
                    -> setResume("Deux adolescents atteints de cancer, Hazel Grace et Augustus Waters, se connaissent dans un groupe de soutien. Les deux adolescents se passionnent pour un roman de Peter Van Houten, qui se termine brutalement au milieu d'une phrase. Curieux du sort des personnages, Hazel et Augustus envisagent de se rendre à Amsterdam afin de rencontrer l'auteur. Ils effectuent le voyage grâce à une fondation d'aide aux enfants malades qui se charge d'exaucer leur vœu le plus cher…")
                    -> setEpoque($epoque1020)
                    -> setGenre($genreRomance)
                    -> setThematique($themeSens)
                    -> setTrancheAge($trancheAdo)
                    -> setDescription("Accessoires et vêtements avec le titre du livre ou la phrase «ok? ok.» BSO Histoire de Esther Earl, jeune fille qui a inspiré John Green a écrire l'histoire: This Star Won't Go Out: The Life and Words of Esther Grace Earl");
         $manager->persist($ProduitDerNEC);
         
         $ImageNEC = new Image();
         $ImageNEC -> setUrl("http://www.photogeniques.fr/wp-content/uploads/2014/09/The-Fault-in-Our-Stars_tfios_Nos-etoiles-contraires_okay-okay.jpg")
                     -> setOeuvreLitt($oeuvreLittNEC)
                     -> setOeuvreCine($oeuvreCineNEC)
                     -> setProduit($ProduitDerNEC);
         $manager->persist($ImageNEC);
         
        $oeuvreLittLOTR = new OeuvreLitt();
        $oeuvreLittLOTR -> setNom("Le Seigneur des Anneaux")
                    -> setResume("Un jeune Hobbit nommé Frodon Sacquet, hérite d'un anneau. Mais il se trouve que cet anneau est L'Anneau UNIQUE, un instrument de pouvoir absolu crée pour Sauron, le Seigneur des ténèbres, pour lui permettre de régner sur la Terre du Milieu et de réduire en esclavage ses peuples. Frodon a donc comme mission de détruire l'anneau en le jetant dans les laves de la Crevasse du Destin où l'Anneau à été forgé et ainsi le détruir pour toujours. Pour cela, Frodon sera aidé d'une Compagnie constituée d'Hobbits, d'Hommes, d'un Magicien, d'un Nain, et d'un Elfe, Un tel périple signifie s'aventurer très loin en Mordor, les terres du Seigneur des ténèbres, où est rassemblée son armée d'Orques maléfiques. La Compagnie doit non seulement combattre les forces extérieures du mal mais aussi les dissensions internes et l'influence corruptrice qu'exerce l'Anneau lui-même sur Frodon...")
                    -> setEpoque($epoque5060)
                    -> setGenre($genreFantastique)
                    -> setThematique($themeQuete)
                    -> setTrancheAge($trancheAdulte);
        $manager->persist($oeuvreLittLOTR);
        
        $EditeurLOTR = new Editeur();
        $EditeurLOTR -> setNom("Allen & Unwin");
        $manager->persist($EditeurLOTR);
                    
        $AuteurLOTR = new Auteur();
        $AuteurLOTR  -> setNom("Tolkien")
                     -> setPrenom("J.R.R.");
        $manager->persist($AuteurLOTR);
         
        $LivreLOTR1 = new Livre();
        $LivreLOTR1 -> setTitre("La Fraternité de l'Anneau")
                     -> addAuteur($AuteurLOTR)
                     -> setEditeur($EditeurLOTR)
                     -> setOeuvreLitt($oeuvreLittLOTR);
        $manager->persist($LivreLOTR1);
         
        $LivreLOTR2 = new Livre();
        $LivreLOTR2 -> setTitre("Les Deux Tours")
                     -> addAuteur($AuteurLOTR)
                     -> setEditeur($EditeurLOTR)
                     -> setOeuvreLitt($oeuvreLittLOTR);
        $manager->persist($LivreLOTR1);
		 
		$LivreLOTR3 = new Livre();
        $LivreLOTR3 -> setTitre("Les Retour du Roi")
                     -> addAuteur($AuteurLOTR)
                     -> setEditeur($EditeurLOTR)
                     -> setOeuvreLitt($oeuvreLittLOTR);
        $manager->persist($LivreLOTR3);
         
        $oeuvreCineLOTR = new OeuvreCine();
        $oeuvreCineLOTR -> setNom("Le Seigneur des Anneaux")
                    -> setResume("Un jeune Hobbit nommé Frodon Sacquet, hérite d'un anneau. Mais il se trouve que cet anneau est L'Anneau UNIQUE, un instrument de pouvoir absolu crée pour Sauron, le Seigneur des ténèbres, pour lui permettre de régner sur la Terre du Milieu et de réduire en esclavage ses peuples. Frodon a donc comme mission de détruire l'anneau en le jetant dans les laves de la Crevasse du Destin où l'Anneau à été forgé et ainsi le détruir pour toujours. Pour cela, Frodon sera aidé d'une Compagnie constituée d'Hobbits, d'Hommes, d'un Magicien, d'un Nain, et d'un Elfe, Un tel périple signifie s'aventurer très loin en Mordor, les terres du Seigneur des ténèbres, où est rassemblée son armée d'Orques maléfiques. La Compagnie doit non seulement combattre les forces extérieures du mal mais aussi les dissensions internes et l'influence corruptrice qu'exerce l'Anneau lui-même sur Frodon...")
                    -> setEpoque($epoque5060)
                    -> setGenre($genreFantastique)
                    -> setThematique($themeQuete)
                    -> setTrancheAge($trancheAdulte);
        $manager->persist($oeuvreCineLOTR);
         
        $ActeurElijahWood = new Acteur();
        $ActeurElijahWood -> setNom("Wood")
                         -> setPrenom("Elijah");
        $manager->persist($ActeurElijahWood);
         
        $ActeurViggoMortensen = new Acteur();
        $ActeurViggoMortensen -> setNom("Mortensen")
                         -> setPrenom("Viggo");
        $manager->persist($ActeurViggoMortensen);
         
        $ActeurIanMcKellen = new Acteur();
        $ActeurIanMcKellen -> setNom("McKellen")
                         -> setPrenom("Ian");
        $manager->persist($ActeurIanMcKellen);
         
        $ActeurOrlandoBloom = new Acteur();
        $ActeurOrlandoBloom -> setNom("Bloom")
                         -> setPrenom("Orlando");
        $manager->persist($ActeurOrlandoBloom);
         
        $RéalisateurPeterJackson = new Realisateur();
        $RéalisateurPeterJackson -> setNom("Jackson")
                                 -> setPrenom("Peter");
        $manager->persist($RéalisateurPeterJackson);
         
        $FilmLOTR1 = new Film();
        $FilmLOTR1 -> setTitre("La Communauté de l'Anneau")
                  -> setDuree(165)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurPeterJackson)
                   -> addActeur($ActeurElijahWood)
                   -> addActeur($ActeurViggoMortensen)
                   -> addActeur($ActeurIanMcKellen)
                   -> addActeur($ActeurOrlandoBloom)
                   -> setOeuvreCine($oeuvreCineLOTR);
         $manager->persist($FilmLOTR1);
		 
		$FilmLOTR2 = new Film();
        $FilmLOTR2 -> setTitre("Les Deux Tours")
                  -> setDuree(178)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurPeterJackson)
                   -> addActeur($ActeurElijahWood)
                   -> addActeur($ActeurViggoMortensen)
                   -> addActeur($ActeurIanMcKellen)
                   -> addActeur($ActeurOrlandoBloom)
                   -> setOeuvreCine($oeuvreCineLOTR);
         $manager->persist($FilmLOTR2);
		 
		$FilmLOTR3 = new Film();
        $FilmLOTR3 -> setTitre("Le Retour du Roi")
                  -> setDuree(200)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurPeterJackson)
                   -> addActeur($ActeurElijahWood)
                   -> addActeur($ActeurViggoMortensen)
                   -> addActeur($ActeurIanMcKellen)
                   -> addActeur($ActeurOrlandoBloom)
                   -> setOeuvreCine($oeuvreCineLOTR);
         $manager->persist($FilmLOTR3);
         
        $ProduitDerLOTR = new ProduitDer();
        $ProduitDerLOTR -> setNom("Nos étoiles contraires")
                    -> setResume("Deux adolescents")
                    -> setEpoque($epoque1020)
                    -> setGenre($genreRomance)
                    -> setThematique($themeSens)
                    -> setTrancheAge($trancheAdo)
                    -> setDescription("Tous types de produits dérivés sont trouvables : jeux videos, jeux de société, vetements, l'Anneau, ainsi que des figurines en tous genres (exposition, jeu de role ou maquette à taille réelle).");
        $manager->persist($ProduitDerLOTR);
         
        $ImageLOTR = new Image();
        $ImageLOTR -> setUrl("http://gardoum.com/wp-content/uploads/2015/10/92359592_o.jpg")
					 -> setOeuvreLitt($oeuvreLittLOTR)
                     -> setOeuvreCine($oeuvreCineLOTR)
                     -> setProduit($ProduitDerLOTR);
        $manager->persist($ImageLOTR);
         
        

        /* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */

        // On déclenche l'enregistrement de toutes les données en BD
        $manager->flush();
    }
}


?>