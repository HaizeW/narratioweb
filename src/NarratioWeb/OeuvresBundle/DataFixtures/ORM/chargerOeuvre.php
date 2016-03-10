<?php

namespace NarratioWeb\OeuvresBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NarratioWeb\OeuvresBundle\Entity\Epoque;
use NarratioWeb\OeuvresBundle\Entity\Genre;
use NarratioWeb\OeuvresBundle\Entity\Thematique;
use NarratioWeb\OeuvresBundle\Entity\TrancheAge;
use NarratioWeb\OeuvresBundle\Entity\Oeuvre;
use NarratioWeb\OeuvresBundle\Entity\Livre;
use NarratioWeb\OeuvresBundle\Entity\Editeur;
use NarratioWeb\OeuvresBundle\Entity\Auteur;
use NarratioWeb\OeuvresBundle\Entity\Film;
use NarratioWeb\OeuvresBundle\Entity\Acteur;
use NarratioWeb\OeuvresBundle\Entity\Realisateur;
use NarratioWeb\OeuvresBundle\Entity\Type;
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
         /* Création de l'oeuvre "Nos étoiles contraires"          */
        /* ******************************************************* */  

        $oeuvreNEC = new Oeuvre();
        $oeuvreNEC -> setNom("Nos étoiles contraires")
                    -> setResume("Deux adolescents atteints de cancer, Hazel Grace et Augustus Waters, se connaissent dans un groupe de soutien. Les deux adolescents se passionnent pour un roman de Peter Van Houten, qui se termine brutalement au milieu d'une phrase. Curieux du sort des personnages, Hazel et Augustus envisagent de se rendre à Amsterdam afin de rencontrer l'auteur. Ils effectuent le voyage grâce à une fondation d'aide aux enfants malades qui se charge d'exaucer leur vœu le plus cher…")
                    -> setProdDer("Accessoires et vêtements avec le titre du livre ou la phrase «ok? ok.» BSO Histoire de Esther Earl, jeune fille qui a inspiré John Green a écrire l'histoire: This Star Won't Go Out: The Life and Words of Esther Grace Earl")
                    -> setEpoque($epoque1020)
                    -> setGenre($genreRomance)
                    -> setThematique($themeSens)
                    -> setTrancheAge($trancheAdo)
                    -> setCompteurVues(0);
         $manager->persist($oeuvreNEC);

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
                     -> setOeuvres($oeuvreNEC);
         $manager->persist($LivreNEC);


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
                  -> setOeuvres($oeuvreNEC);
         $manager->persist($FilmNEC);

        $ImageNEC = new Image();
        $ImageNEC  -> setUrl("http://www.photogeniques.fr/wp-content/uploads/2014/09/The-Fault-in-Our-Stars_tfios_Nos-etoiles-contraires_okay-okay.jpg")
                    -> setOeuvre($oeuvreNEC);
        $manager->persist($ImageNEC);

        /* ******************************************************* */
         /* Création de l'oeuvre "Le Seigneur des Anneaux"       */
        /* ******************************************************* */  

        $oeuvreLOTR = new Oeuvre();
        $oeuvreLOTR -> setNom("Le Seigneur des Anneaux")
                    -> setResume("Un jeune Hobbit nommé Frodon Sacquet, hérite d'un anneau. Mais il se trouve que cet anneau est L'Anneau UNIQUE, un instrument de pouvoir absolu crée pour Sauron, le Seigneur des ténèbres, pour lui permettre de régner sur la Terre du Milieu et de réduire en esclavage ses peuples. Frodon a donc comme mission de détruire l'anneau en le jetant dans les laves de la Crevasse du Destin où l'Anneau à été forgé et ainsi le détruir pour toujours. Pour cela, Frodon sera aidé d'une Compagnie constituée d'Hobbits, d'Hommes, d'un Magicien, d'un Nain, et d'un Elfe, Un tel périple signifie s'aventurer très loin en Mordor, les terres du Seigneur des ténèbres, où est rassemblée son armée d'Orques maléfiques. La Compagnie doit non seulement combattre les forces extérieures du mal mais aussi les dissensions internes et l'influence corruptrice qu'exerce l'Anneau lui-même sur Frodon...")
                    -> setEpoque($epoque5060)
                    -> setGenre($genreFantastique)
                    -> setThematique($themeQuete)
                    -> setTrancheAge($trancheAdulte)
                    ->setProdDer("Tous types de produits dérivés sont trouvables : jeux videos, jeux de société, vetements, l'Anneau, ainsi que des figurines en tous genres (exposition, jeu de role ou maquette à taille réelle).")
                    -> setCompteurVues(1);
        $manager->persist($oeuvreLOTR);
        
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
                     -> setOeuvres($oeuvreLOTR)
                     -> setEditeur($EditeurLOTR);
        $manager->persist($LivreLOTR1);
         
        $LivreLOTR2 = new Livre();
        $LivreLOTR2 -> setTitre("Les Deux Tours")
                     -> addAuteur($AuteurLOTR)
                     -> setEditeur($EditeurLOTR)
                     -> setOeuvres($oeuvreLOTR);
        $manager->persist($LivreLOTR2);
		 
		$LivreLOTR3 = new Livre();
        $LivreLOTR3 -> setTitre("Les Retour du Roi")
                     -> addAuteur($AuteurLOTR)
                     -> setEditeur($EditeurLOTR)
                     -> setOeuvres($oeuvreLOTR);
        $manager->persist($LivreLOTR3);
         
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
                   -> setOeuvres($oeuvreLOTR);
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
                   -> setOeuvres($oeuvreLOTR);
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
                   -> setOeuvres($oeuvreLOTR);
         $manager->persist($FilmLOTR3);
         
        $ImageLOTR = new Image();
        $ImageLOTR -> setUrl("http://gardoum.com/wp-content/uploads/2015/10/92359592_o.jpg")
                                ->setOeuvre($oeuvreLOTR);
        $manager->persist($ImageLOTR);

        $epoque8090 = new Epoque();
        $epoque8090->setIntitule("1880 - 1890");
        $manager->persist($epoque8090);

        $genreDramatique = new Genre();
        $genreDramatique->setIntitule("Dramatique");
        $manager->persist($genreDramatique);

        $themeRomantisme = new Thematique();
        $themeRomantisme->setIntitule("Romantisme");
        $manager->persist($themeRomantisme);

        $trancheGrandPub = new TrancheAge();
        $trancheGrandPub->setIntitule("Grand Public");
        $manager->persist($trancheGrandPub);

        $oeuvreCyrano = new Oeuvre();
        $oeuvreCyrano -> setNom("Cyrano De Bergerac")
                    -> setResume("Cyrano deBergerac est un turbulent mousquetaire de la compagnie des Cadets de Gascogne. Il est amoureux de sa cousine, la belle Roxane,mais n’ose pas le lui avouer car il est complexé par son nez difforme, même s’il défend cette difformité brillamment quand un vicomte trop audacieux se risque à lui faire une remarque. Lorsque Roxane sollicite une entrevue avec lui à la rôtisserie de Ragueneau, Cyrano est plein d’espoir, mais Roxane luirévèle qu’elle aime Christian, beau jeune homme qui s’apprête à entrer chez les Cadets de Gascogne, et elle demande à Cyrano de le protéger. Cyrano accepte et va même plus loin, puisqu’il conclut un pacte avec Christian, qui est beau mais peu spirituel : il va lui dicter les mots d’amour que Christian dira à Roxane. Grâce auxbons mots de Cyrano, Christian gagne le cœur de Roxane ils se marient très rapidement. Cependant De Guiche, rival jaloux, fait envoyer les Cadets de Gascogne à la guerre, au siège d’Arras. Cyrano y protège toujours Christian et envoie tous les jours des lettres à Roxane au nom de celui-ci. Néanmoins Christian s’aperçoit que Roxane l’aime surtout pour ce qu’elle croit être son bel esprit et qu’elle aime donc en réalité, sans le savoir, Cyrano. Il refuse de prolonger l’imposture et exige de Cyrano qu’il dise la vérité à Roxane. Mais au moment où Cyrano s’apprête à tout avouer, Christian est tué au front. Cyrano décide donc de se taire à jamais. L'histoire se ﬁnit quinze ans plus tard. Roxane est retirée dans un couvent, et Cyrano vient lui rendre visite toutes les semaines. Ce jour-là, victime d’un accident qui ressemble à un attentat, mourant, il lui demande de lire la dernière lettre de Christian. Alors qu’il la récite par cœur, Roxane comprend tout. Cyrano meurt en ayant reçu d’elle un baiser sur le front.")
                    -> setEpoque($epoque8090)
                    -> setGenre($genreDramatique)
                    -> setThematique($themeRomantisme)
                    ->setTrancheAge($trancheGrandPub)
                    ->setProdDer("Accessoires et déguisements d'époque, le fameux modèle d'épée du héro, la 'rapière' ainsi que de faux nez en plastique pour se mettre dans la peau du personange.")
                    ->setCompteurVues(0);
        $manager->persist($oeuvreCyrano);

         $EditeurCyrano = new Editeur();
         $EditeurCyrano -> setNom("Librio");
         $manager->persist($EditeurCyrano);
                    
         $AuteurCyrano = new Auteur();
         $AuteurCyrano  -> setNom("Rostand")
                     -> setPrenom("Edmond");
         $manager->persist($AuteurCyrano);
         
         $LivreCyrano = new Livre();
         $LivreCyrano   -> setTitre("Cyrano De Bergerac")
                     -> addAuteur($AuteurCyrano)
                     -> setEditeur($EditeurCyrano)
                     -> setOeuvres($oeuvreCyrano);
         $manager->persist($LivreCyrano);

         $ActeurCyrano1 = new Acteur();
         $ActeurCyrano1 -> setNom("Ferrer")
                     -> setPrenom("José");
         $manager->persist($ActeurCyrano1);
         
         $ActeurCyrano2 = new Acteur();
         $ActeurCyrano2 -> setNom("Powers")
                     -> setPrenom("Mala");
         $manager->persist($ActeurCyrano2);
         
         $ActeurCyrano3 = new Acteur();
         $ActeurCyrano3 -> setNom("Prince")
                     -> setPrenom("William");
         $manager->persist($ActeurCyrano3);
         
         $RéalisateurCyrano = new Realisateur();
         $RéalisateurCyrano -> setNom("Gordon")
                          -> setPrenom("Michael");
         $manager->persist($RéalisateurCyrano);

         $FilmCyrano = new Film();
         $FilmCyrano -> setTitre("Cyrano De Bergerac")
                  -> setDuree(167)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurCyrano)
                  -> addActeur($ActeurCyrano1)
                  -> addActeur($ActeurCyrano2)
                  -> addActeur($ActeurCyrano3)
                  -> setOeuvres($oeuvreCyrano);
         $manager->persist($FilmCyrano);

         $ActeurCyrano4 = new Acteur();
         $ActeurCyrano4 -> setNom("Sorano")
                     -> setPrenom("Daniel");
         $manager->persist($ActeurCyrano4);
         
         $ActeurCyrano5 = new Acteur();
         $ActeurCyrano5 -> setNom("Christophe")
                     -> setPrenom("Francoise");
         $manager->persist($ActeurCyrano5);
         
         $ActeurCyrano6 = new Acteur();
         $ActeurCyrano6 -> setNom("Le Royer")
                        -> setPrenom("Michel");
         $manager->persist($ActeurCyrano6);
         
         $RéalisateurCyrano2 = new Realisateur();
         $RéalisateurCyrano2    -> setNom("Barma")
                                -> setPrenom("Claude");
         $manager->persist($RéalisateurCyrano2);

         $FilmCyrano2 = new Film();
         $FilmCyrano2 -> setTitre("Cyrano De Bergerac")
                  -> setDuree(280)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurCyrano)
                  -> addActeur($ActeurCyrano5)
                  -> addActeur($ActeurCyrano6)
                  -> setOeuvres($oeuvreCyrano);
         $manager->persist($FilmCyrano2);

         $ActeurCyrano8 = new Acteur();
         $ActeurCyrano8 -> setNom("Depardieu")
                        -> setPrenom("Gérard");
         $manager->persist($ActeurCyrano8);
         
         $ActeurCyrano9 = new Acteur();
         $ActeurCyrano9 -> setNom("Brochet")
                        -> setPrenom("Anne");
         $manager->persist($ActeurCyrano9);
         
         $ActeurCyrano10 = new Acteur();
         $ActeurCyrano10 -> setNom("Perez")
                         -> setPrenom("Vincent");
         $manager->persist($ActeurCyrano10);
         
         $RéalisateurCyrano3 = new Realisateur();
         $RéalisateurCyrano3 -> setNom("Rappeneau")
                             -> setPrenom("Jean-Paul");
         $manager->persist($RéalisateurCyrano3);

         $FilmCyrano3 = new Film();
         $FilmCyrano3 -> setTitre("Cyrano De Bergerac 3")
                  -> setDuree(257)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurCyrano3)
                  -> addActeur($ActeurCyrano8)
                  -> addActeur($ActeurCyrano9)
                  -> addActeur($ActeurCyrano10)
                  -> setOeuvres($oeuvreCyrano);
         $manager->persist($FilmCyrano3);

         
         $ImageCyrano = new Image();
         $ImageCyrano -> setUrl("http://www.stuartfernie.org/cyr2.jpg")
                      -> setOeuvre($oeuvreCyrano);
         $manager->persist($ImageCyrano);



        /* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */

        // On déclenche l'enregistrement de toutes les données en BD
        $manager->flush();
    }
}




?>