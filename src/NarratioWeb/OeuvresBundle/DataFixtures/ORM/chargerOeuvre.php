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
                    -> setTrancheAge($trancheAdo)
                    -> setCompteurVues(0);
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
                    -> setTrancheAge($trancheAdo)
                    -> setCompteurVues(0);
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
                    -> setDescription("Accessoires et vêtements avec le titre du livre ou la phrase «ok? ok.» BSO Histoire de Esther Earl, jeune fille qui a inspiré John Green a écrire l'histoire: This Star Won't Go Out: The Life and Words of Esther Grace Earl")
                    -> setCompteurVues(0);
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
                    -> setTrancheAge($trancheAdulte)
                    -> setCompteurVues(0);
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
        $manager->persist($LivreLOTR2);
		 
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
                    -> setTrancheAge($trancheAdulte)
                    -> setCompteurVues(0);
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
        $ProduitDerLOTR -> setNom("Le Seigneur des Anneaux")
                    -> setResume("Un jeune Hobbit nommé Frodon Sacquet, hérite d'un anneau. Mais il se trouve que cet anneau est L'Anneau UNIQUE, un instrument de pouvoir absolu crée pour Sauron, le Seigneur des ténèbres, pour lui permettre de régner sur la Terre du Milieu et de réduire en esclavage ses peuples. Frodon a donc comme mission de détruire l'anneau en le jetant dans les laves de la Crevasse du Destin où l'Anneau à été forgé et ainsi le détruir pour toujours. Pour cela, Frodon sera aidé d'une Compagnie constituée d'Hobbits, d'Hommes, d'un Magicien, d'un Nain, et d'un Elfe, Un tel périple signifie s'aventurer très loin en Mordor, les terres du Seigneur des ténèbres, où est rassemblée son armée d'Orques maléfiques. La Compagnie doit non seulement combattre les forces extérieures du mal mais aussi les dissensions internes et l'influence corruptrice qu'exerce l'Anneau lui-même sur Frodon...")
                    -> setEpoque($epoque5060)
                    -> setGenre($genreFantastique)
                    -> setThematique($themeQuete)
                    -> setTrancheAge($trancheAdulte)
                    -> setDescription("Tous types de produits dérivés sont trouvables : jeux videos, jeux de société, vetements, l'Anneau, ainsi que des figurines en tous genres (exposition, jeu de role ou maquette à taille réelle).")
                    -> setCompteurVues(0);
        $manager->persist($ProduitDerLOTR);
         
        $ImageLOTR = new Image();
        $ImageLOTR -> setUrl("http://gardoum.com/wp-content/uploads/2015/10/92359592_o.jpg")
					 -> setOeuvreLitt($oeuvreLittLOTR)
                     -> setOeuvreCine($oeuvreCineLOTR)
                     -> setProduit($ProduitDerLOTR);
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

        $oeuvreLittCyrano = new OeuvreLitt();
        $oeuvreLittCyrano -> setNom("Cyrano De Bergerac")
                    -> setResume("Cyrano deBergerac est un turbulent mousquetaire de la compagniedesCadets de Gascogne. Il est amoureux de sa cousine, la belle Roxane,mais n’ose pas le lui avouer car il est complexé par son nez difforme,même s’il défend cette difformité brillamment quand un vicomtetrop audacieux se risque à lui faire une remarque. Lorsque Roxanesollicite une entrevue avec lui à la rôtisserie de Ragueneau, Cyrano estplein d’espoir, mais Roxane luirévèle qu’elle aime Christian, beau jeunehomme quis’apprête à entrer chez les Cadets de Gascogne, et elledemande à Cyrano de le protéger. Cyrano accepte et va même plusloin, puisqu’ilconclut un pacte avec Christian, qui est beau mais peuspirituel : il va lui dicter les mots d’amour que Christian dira à Roxane.Grâce auxbons mots de Cyrano, Christian gagne le cœur de Roxane ;ils se marient très rapidement. Cependant De Guiche, rival jaloux,fait envoyer les Cadets de Gascogne à la guerre, au siège d’Arras.Cyrano y protège toujours Christian et envoie tous les jours deslettres à Roxane aunom de celui-ci. Néanmoins Christian s’aperçoit queRoxane l’aime surtout pour ce qu’elle croit être son bel esprit etqu’elle aime donc enréalité, sans le savoir, Cyrano. Il refuse de prolongerl’imposture et exige de Cyrano qu’ildise la vérité à Roxane. Mais aumoment où Cyrano s’apprêteà tout avouer, Christian est tué au front.Cyrano décidedonc de se taire à jamais. La pièce se ﬁnit quinze ansplus tard. Roxaneest retirée dans un couvent, et Cyrano vient luirendre visite toutes les semaines. Ce jour-là, victime d’un accident quiressemble à unattentat, mourant, il lui demande de lire la dernièrelettre deChristian. Alors qu’il la récite par cœur, Roxane comprendtout. Cyrano meurt enayant reçu d’elle un baiser sur le front. ")
                    -> setEpoque($epoque8090)
                    -> setGenre($genreDramatique)
                    -> setThematique($themeRomantisme)
                    -> setTrancheAge($trancheGrandPub)
                    -> setCompteurVues(0);
        $manager->persist($oeuvreLittCyrano);

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
                     -> setOeuvreLitt($oeuvreLittCyrano);
         $manager->persist($LivreCyrano);
         





         $oeuvreCineCyrano = new OeuvreCine();
         $oeuvreCineCyrano -> setNom("Cyrano De Bergerac")
                    -> setResume("Cyrano deBergerac est un turbulent mousquetaire de la compagniedesCadets de Gascogne. Il est amoureux de sa cousine, la belle Roxane,mais n’ose pas le lui avouer car il est complexé par son nez difforme,même s’il défend cette difformité brillamment quand un vicomtetrop audacieux se risque à lui faire une remarque. Lorsque Roxanesollicite une entrevue avec lui à la rôtisserie de Ragueneau, Cyrano estplein d’espoir, mais Roxane luirévèle qu’elle aime Christian, beau jeunehomme quis’apprête à entrer chez les Cadets de Gascogne, et elledemande à Cyrano de le protéger. Cyrano accepte et va même plusloin, puisqu’ilconclut un pacte avec Christian, qui est beau mais peuspirituel : il va lui dicter les mots d’amour que Christian dira à Roxane.Grâce auxbons mots de Cyrano, Christian gagne le cœur de Roxane ;ils se marient très rapidement. Cependant De Guiche, rival jaloux,fait envoyer les Cadets de Gascogne à la guerre, au siège d’Arras.Cyrano y protège toujours Christian et envoie tous les jours deslettres à Roxane aunom de celui-ci. Néanmoins Christian s’aperçoit queRoxane l’aime surtout pour ce qu’elle croit être son bel esprit etqu’elle aime donc enréalité, sans le savoir, Cyrano. Il refuse de prolongerl’imposture et exige de Cyrano qu’ildise la vérité à Roxane. Mais aumoment où Cyrano s’apprêteà tout avouer, Christian est tué au front.Cyrano décidedonc de se taire à jamais. La pièce se ﬁnit quinze ansplus tard. Roxaneest retirée dans un couvent, et Cyrano vient luirendre visite toutes les semaines. Ce jour-là, victime d’un accident quiressemble à unattentat, mourant, il lui demande de lire la dernièrelettre deChristian. Alors qu’il la récite par cœur, Roxane comprendtout. Cyrano meurt enayant reçu d’elle un baiser sur le front.")
                    -> setEpoque($epoque8090)
                    -> setGenre($genreDramatique)
                    -> setThematique($themeRomantisme)
                    -> setTrancheAge($trancheGrandPub)
                    -> setCompteurVues(0);
         $manager->persist($oeuvreCineCyrano);

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
                  -> setOeuvreCine($oeuvreCineCyrano);
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
         $RéalisateurCyrano2 -> setNom("Barma")
                          -> setPrenom("Claude");
         $manager->persist($RéalisateurCyrano2);

         $FilmCyrano2 = new Film();
         $FilmCyrano2 -> setTitre("Cyrano De Bergerac")
                  -> setDuree(280)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurCyrano)
                  -> addActeur($ActeurCyrano5)
                  -> addActeur($ActeurCyrano6)
                  -> setOeuvreCine($oeuvreCineCyrano);
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
                  -> setOeuvreCine($oeuvreCineCyrano);
         $manager->persist($FilmCyrano3);





         
         $ProduitDerCyrano = new ProduitDer();
         $ProduitDerCyrano-> setNom("Cyrano De Bergerac")
                    -> setResume("Cyrano deBergerac est un turbulent mousquetaire de la compagniedesCadets de Gascogne. Il est amoureux de sa cousine, la belle Roxane,mais n’ose pas le lui avouer car il est complexé par son nez difforme,même s’il défend cette difformité brillamment quand un vicomtetrop audacieux se risque à lui faire une remarque. Lorsque Roxanesollicite une entrevue avec lui à la rôtisserie de Ragueneau, Cyrano estplein d’espoir, mais Roxane luirévèle qu’elle aime Christian, beau jeunehomme quis’apprête à entrer chez les Cadets de Gascogne, et elledemande à Cyrano de le protéger. Cyrano accepte et va même plusloin, puisqu’ilconclut un pacte avec Christian, qui est beau mais peuspirituel : il va lui dicter les mots d’amour que Christian dira à Roxane.Grâce auxbons mots de Cyrano, Christian gagne le cœur de Roxane ;ils se marient très rapidement. Cependant De Guiche, rival jaloux,fait envoyer les Cadets de Gascogne à la guerre, au siège d’Arras.Cyrano y protège toujours Christian et envoie tous les jours deslettres à Roxane aunom de celui-ci. Néanmoins Christian s’aperçoit queRoxane l’aime surtout pour ce qu’elle croit être son bel esprit etqu’elle aime donc enréalité, sans le savoir, Cyrano. Il refuse de prolongerl’imposture et exige de Cyrano qu’ildise la vérité à Roxane. Mais aumoment où Cyrano s’apprêteà tout avouer, Christian est tué au front.Cyrano décidedonc de se taire à jamais. La pièce se ﬁnit quinze ansplus tard. Roxaneest retirée dans un couvent, et Cyrano vient luirendre visite toutes les semaines. Ce jour-là, victime d’un accident quiressemble à unattentat, mourant, il lui demande de lire la dernièrelettre deChristian. Alors qu’il la récite par cœur, Roxane comprendtout. Cyrano meurt enayant reçu d’elle un baiser sur le front.")
                    -> setEpoque($epoque1020)
                    -> setGenre($genreRomance)
                    -> setThematique($themeSens)
                    -> setTrancheAge($trancheAdo)
                    -> setDescription("Accessoires et déguisements d'époque, le fameux modèle d'épée du héro, la 'rapière'  ainsi que de faux nez en plastique pour se mettre dans la peau du personange.")
                    -> setCompteurVues(0);
         $manager->persist($ProduitDerCyrano);
         
         $ImageCyrano = new Image();
         $ImageCyrano -> setUrl("http://www.stuartfernie.org/cyr2.jpg")
                     -> setOeuvreLitt($oeuvreLittCyrano)
                     -> setOeuvreCine($oeuvreCineCyrano)
                     -> setProduit($ProduitDerCyrano);
         $manager->persist($ImageCyrano);

        $oeuvreLittGdM = new OeuvreLitt();
        $oeuvreLittGdM -> setNom("La guerre des mondes")
                    -> setResume("1894. Des astronomes sont témoins d'étranges activités à la surface de Mars, comme des flash ou des explosions de gaz incandescent. L'étonnant phénomène se répète pendant les dix nuits suivantes puis cesse. Des météores venant de la planète rouge se dirigent bientôt vers la Terre. Le premier s'écrase en Angleterre, dans le Surrey : il s'agit d'un objet ayant la forme d'un cylindre de vingt-cinq à trente mètres. Les curieux se rassemblent autour du cratère formé par la chute du projectile, mais ils sont bientôt tués par un Rayon Ardent projeté par une machine gigantesque à trois énormes pieds sortie du cylindre.
Par la suite, les autres cylindres envoyés depuis Mars s'écrasent et libèrent d'autres engins mécaniques contrôlés par des créatures tentaculaires installées à l'intérieur. Ces tripodes, armés de leur Rayon Ardent et d'un gaz toxique appelé Fumée Noire (Black smoke), se dirigent versLondres en désintégrant tout sur leur passage. L'armée britannique réplique. Mais rapidement, la lutte tourne à l'avantage des envahisseurs. Les populations terrifiées fuient cet ennemi implacable qui pompe le sang des malheureux qu'il capture et sème partout une mystérieuse herbe rouge qui étouffe toute végétation. Commence alors pour le narrateur, une fuite dans un monde ravagé, où il ne croise plus que des êtres humains isolés à la limite de la folie. Puis, il se rend compte que les martiens ont soudain cessé toute activité : les microbes terriens, auxquels ils n'étaient pas immunisés, les ont exterminés ")
                    -> setEpoque($epoque5060)
                    -> setGenre($genreFantastique)
                    -> setThematique($themeQuete)
                    -> setTrancheAge($trancheAdulte)
                    -> setCompteurVues(0);
        $manager->persist($oeuvreLittLOTR);
        
        $EditeurGdM = new Editeur();
        $EditeurGdM -> setNom("Heinemann");
        $manager->persist($EditeurGdM);
                    
        $AuteurGdM = new Auteur();
        $AuteurGdM -> setNom("Wells")
                     -> setPrenom("H.G ");
        $manager->persist($AuteurGdM);
         
        $LivreGdM = new Livre();
        $LivreGdM -> setTitre("La guerre des mondes")
                     -> addAuteur($AuteurGdM)
                     -> setEditeur($EditeurGdM)
                     -> setOeuvreLitt($oeuvreLittGdM);
        $manager->persist($LivreGdM);
         
        $oeuvreCineGdM = new OeuvreCine();
        $oeuvreCineGdM -> setNom("La guerre des mondes")
                    -> setResume("1894. Des astronomes sont témoins d'étranges activités à la surface de Mars, comme des flash ou des explosions de gaz incandescent. L'étonnant phénomène se répète pendant les dix nuits suivantes puis cesse. Des météores venant de la planète rouge se dirigent bientôt vers la Terre. Le premier s'écrase en Angleterre, dans le Surrey : il s'agit d'un objet ayant la forme d'un cylindre de vingt-cinq à trente mètres. Les curieux se rassemblent autour du cratère formé par la chute du projectile, mais ils sont bientôt tués par un Rayon Ardent projeté par une machine gigantesque à trois énormes pieds sortie du cylindre.
Par la suite, les autres cylindres envoyés depuis Mars s'écrasent et libèrent d'autres engins mécaniques contrôlés par des créatures tentaculaires installées à l'intérieur. Ces tripodes, armés de leur Rayon Ardent et d'un gaz toxique appelé Fumée Noire (Black smoke), se dirigent versLondres en désintégrant tout sur leur passage. L'armée britannique réplique. Mais rapidement, la lutte tourne à l'avantage des envahisseurs. Les populations terrifiées fuient cet ennemi implacable qui pompe le sang des malheureux qu'il capture et sème partout une mystérieuse herbe rouge qui étouffe toute végétation. Commence alors pour le narrateur, une fuite dans un monde ravagé, où il ne croise plus que des êtres humains isolés à la limite de la folie. Puis, il se rend compte que les martiens ont soudain cessé toute activité : les microbes terriens, auxquels ils n'étaient pas immunisés, les ont exterminés ")
                    -> setEpoque($epoque5060)
                    -> setGenre($genreFantastique)
                    -> setThematique($themeQuete)
                    -> setTrancheAge($trancheAdulte)
                    -> setCompteurVues(0);
        $manager->persist($oeuvreCineGdM);
         
        $ActeurTomCruise = new Acteur();
        $ActeurTomCruise -> setNom("Cruise")
                         -> setPrenom("Tom");
        $manager->persist($ActeurTomCruise);
         
        $ActeurDakotaFanning= new Acteur();
        $ActeurDakotaFanning -> setNom("Fanning")
                         -> setPrenom("Dakota");
        $manager->persist($ActeurDakotaFanning);
         
        $ActeurIanMirandaOtto = new Acteur();
        $ActeurIanMirandaOtto -> setNom("Otto")
                         -> setPrenom("Miranda");
        $manager->persist($ActeurIanMirandaOtto);
         
        $ActeurJustinChatwin = new Acteur();
        $ActeurJustinChatwin -> setNom("Chatwin")
                         -> setPrenom("Justin");
        $manager->persist($ActeurJustinChatwin);
         
        $RéalisateurStevenSpielberg = new Realisateur();
        $RéalisateurStevenSpielberg -> setNom("Spielberg ")
                                 -> setPrenom("Steven");
        $manager->persist($RéalisateurStevenSpielberg);
         
        $FilmGdM = new Film();
        $FilmGdM -> setTitre("La guerre des mondes")
                  -> setDuree(118)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurStevenSpielberg)
                   -> addActeur($ActeurTomCruise)
                   -> addActeur($ActeurDakotaFanning)
                   -> addActeur($ActeurIanMirandaOtto)
                   -> addActeur($ActeurJustinChatwin)
                   -> setOeuvreCine($oeuvreCineGdM);
         $manager->persist($FilmGdM);
         
        $ProduitDerGdM = new ProduitDer();
        $ProduitDerGdM -> setNom("La guerre des mondes")
                    -> setResume("1894. Des astronomes sont témoins d'étranges activités à la surface de Mars, comme des flash ou des explosions de gaz incandescent. L'étonnant phénomène se répète pendant les dix nuits suivantes puis cesse. Des météores venant de la planète rouge se dirigent bientôt vers la Terre. Le premier s'écrase en Angleterre, dans le Surrey : il s'agit d'un objet ayant la forme d'un cylindre de vingt-cinq à trente mètres. Les curieux se rassemblent autour du cratère formé par la chute du projectile, mais ils sont bientôt tués par un Rayon Ardent projeté par une machine gigantesque à trois énormes pieds sortie du cylindre.
Par la suite, les autres cylindres envoyés depuis Mars s'écrasent et libèrent d'autres engins mécaniques contrôlés par des créatures tentaculaires installées à l'intérieur. Ces tripodes, armés de leur Rayon Ardent et d'un gaz toxique appelé Fumée Noire (Black smoke), se dirigent versLondres en désintégrant tout sur leur passage. L'armée britannique réplique. Mais rapidement, la lutte tourne à l'avantage des envahisseurs. Les populations terrifiées fuient cet ennemi implacable qui pompe le sang des malheureux qu'il capture et sème partout une mystérieuse herbe rouge qui étouffe toute végétation. Commence alors pour le narrateur, une fuite dans un monde ravagé, où il ne croise plus que des êtres humains isolés à la limite de la folie. Puis, il se rend compte que les martiens ont soudain cessé toute activité : les microbes terriens, auxquels ils n'étaient pas immunisés, les ont exterminés ")
                    -> setEpoque($epoque5060)
                    -> setGenre($genreFantastique)
                    -> setThematique($themeQuete)
                    -> setTrancheAge($trancheAdulte)
                    -> setDescription("Tous types de produits dérivés sont trouvables : jeux videos, jeux de société, vetements, figurines des personnages ainsi que des robots ennemis. ")
                    -> setCompteurVues(0);
        $manager->persist($ProduitDerGdM);
         
        $ImageGdM = new Image();
        $ImageGdM -> setUrl("http://fr.web.img6.acsta.net/medias/nmedia/18/35/50/73/18430317.jpg")
					 -> setOeuvreLitt($oeuvreLittGdM)
                     -> setOeuvreCine($oeuvreCineGdM)
                     -> setProduit($ProduitDerGdM);
        $manager->persist($ImageGdM);
        
        /* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */
        // On déclenche l'enregistrement de toutes les données en BD
        $manager->flush();

    }
}




?>