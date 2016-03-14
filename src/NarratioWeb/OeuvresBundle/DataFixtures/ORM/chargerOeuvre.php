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
        
		$epoque3040 = new Epoque();
		$epoque3040->setIntitule("1830 - 1840");
		$manager->persist($epoque3040);
		
		$epoque5060 = new Epoque();
		$epoque5060->setIntitule("1950 - 1960");
		$manager->persist($epoque5060);
		
		$epoque8090 = new Epoque();
		$epoque8090->setIntitule("1880 - 1890");
		$manager->persist($epoque8090);
        
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
		
		$genreDramatique = new Genre();
		$genreDramatique->setIntitule("Dramatique");
		$manager->persist($genreDramatique);
        
        /* ******************************************************* */
        /* Création des thématiques     */
        /* ******************************************************* */
        
		$themeQuete = new Thematique();
		$themeQuete->setIntitule("Quête Fantaisie");
		$manager->persist($themeQuete);
        
		$themeSens = new Thematique();
		$themeSens->setIntitule("Sens de la vie");
		$manager->persist($themeSens);
		
		$themeRomantisme = new Thematique();
		$themeRomantisme->setIntitule("Romantisme");
		$manager->persist($themeRomantisme);
		
		$themeEcole = new Thematique();
		$themeEcole->setIntitule("École");
		$manager->persist($themeEcole);
        
        /* ******************************************************* */
        /* Création des tranches d'âge     */
        /* ******************************************************* */
        
		$trancheAdulte = new TrancheAge();
		$trancheAdulte->setIntitule("Adulte");
		$manager->persist($trancheAdulte);
        
		$trancheAdo = new TrancheAge();
		$trancheAdo->setIntitule("Adolescent");
		$manager->persist($trancheAdo);
		
		$trancheGrandPub = new TrancheAge();
		$trancheGrandPub->setIntitule("Grand Public");
		$manager->persist($trancheGrandPub);
        
        /* ******************************************************* */
         /* Création des oeuvres          */
        /* ******************************************************* */  

		$oeuvreNEC = new Oeuvre();
		$oeuvreNEC -> setNom("Nos Etoiles Contraires")
                    -> setConcept("Deux adolescents atteints de cancer, Hazel Grace et Augustus Waters, se connaissent dans un groupe de soutien. Les deux adolescents se passionnent pour un roman de Peter Van Houten, qui se termine brutalement au milieu d'une phrase. Curieux du sort des personnages, Hazel et Augustus envisagent de se rendre à Amsterdam afin de rencontrer l'auteur. Ils effectuent le voyage grâce à une fondation d'aide aux enfants malades qui se charge d'exaucer leur vœu le plus cher…")
                    -> setProdDer   ("Accessoires et vêtements avec le titre du livre ou la phrase «ok? ok.»
                                    B.O. avec artistes invités comme Charlie XCX
                                    Histoire de Esther Earl, jeune fille qui a inspiré John Green a écrire l'histoire: This Star Won't Go Out: The Life and Words of Esther Grace Earl")
                    -> setEpoque($epoque1020)
                    -> setGenre($genreRomance)
                    -> setThematique($themeSens)
                    -> setTrancheAge($trancheAdo)
                    -> setCompteurVues(0);
		$manager->persist($oeuvreNEC);
		 
		$oeuvreFCM = new Oeuvre();
		$oeuvreFCM  -> setNom("La face cachée de Margo")
                    -> setConcept("D’après le best-seller homonyme, La Face Cachée de Margo est l’histoire de Quentin et de Margo, sa voisine énigmatique. Après l’avoir entraîné avec elle toute la nuit dans une expédition vengeresse à travers leur Orlando, Margo disparaît subitement – laissant derrière elle des indices qu’il devra déchiffrer...")
                    -> setProdDer("B.O. et Blue-Ray")
                    -> setEpoque($epoque1020)
                    -> setGenre($genreRomance)
                    -> setThematique($themeSens)
                    -> setTrancheAge($trancheAdo)
                    -> setCompteurVues(0);
		$manager->persist($oeuvreFCM);
		
		$oeuvreLOTR = new Oeuvre();
		$oeuvreLOTR -> setNom("Le Seigneur des Anneaux")
                    -> setConcept("Un jeune Hobbit nommé Frodon Sacquet, hérite d'un anneau. Mais il se trouve que cet anneau est L'Anneau UNIQUE, un instrument de pouvoir absolu crée pour Sauron, le Seigneur des ténèbres, pour lui permettre de régner sur la Terre du Milieu et de réduire en esclavage ses peuples. Frodon a donc comme mission de détruire l'anneau en le jetant dans les laves de la Crevasse du Destin où l'Anneau à été forgé et ainsi le détruir pour toujours. Pour cela, Frodon sera aidé d'une Compagnie constituée d'Hobbits, d'Hommes, d'un Magicien, d'un Nain, et d'un Elfe, Un tel périple signifie s'aventurer très loin en Mordor, les terres du Seigneur des ténèbres, où est rassemblée son armée d'Orques maléfiques. La Compagnie doit non seulement combattre les forces extérieures du mal mais aussi les dissensions internes et l'influence corruptrice qu'exerce l'Anneau lui-même sur Frodon...")
                    -> setEpoque($epoque5060)
                    -> setGenre($genreFantastique)
                    -> setThematique($themeQuete)
                    -> setTrancheAge($trancheAdulte)
                    ->setProdDer("Tous types de produits dérivés sont trouvables : jeux videos, jeux de société, vetements, l'Anneau, ainsi que des figurines en tous genres (exposition, jeu de role ou maquette à taille réelle).")
                    -> setCompteurVues(0);
		$manager->persist($oeuvreLOTR);
		
		$oeuvreCyrano = new Oeuvre();
		$oeuvreCyrano -> setNom("Cyrano De Bergerac")
                    -> setConcept("Cyrano deBergerac est un turbulent mousquetaire de la compagnie des Cadets de Gascogne. Il est amoureux de sa cousine, la belle Roxane,mais n’ose pas le lui avouer car il est complexé par son nez difforme, même s’il défend cette difformité brillamment quand un vicomte trop audacieux se risque à lui faire une remarque. Lorsque Roxane sollicite une entrevue avec lui à la rôtisserie de Ragueneau, Cyrano est plein d’espoir, mais Roxane luirévèle qu’elle aime Christian, beau jeune homme qui s’apprête à entrer chez les Cadets de Gascogne, et elle demande à Cyrano de le protéger. Cyrano accepte et va même plus loin, puisqu’il conclut un pacte avec Christian, qui est beau mais peu spirituel : il va lui dicter les mots d’amour que Christian dira à Roxane. Grâce auxbons mots de Cyrano, Christian gagne le cœur de Roxane ils se marient très rapidement. Cependant De Guiche, rival jaloux, fait envoyer les Cadets de Gascogne à la guerre, au siège d’Arras. Cyrano y protège toujours Christian et envoie tous les jours des lettres à Roxane au nom de celui-ci. Néanmoins Christian s’aperçoit que Roxane l’aime surtout pour ce qu’elle croit être son bel esprit et qu’elle aime donc en réalité, sans le savoir, Cyrano. Il refuse de prolonger l’imposture et exige de Cyrano qu’il dise la vérité à Roxane. Mais au moment où Cyrano s’apprête à tout avouer, Christian est tué au front. Cyrano décide donc de se taire à jamais. L'histoire se ﬁnit quinze ans plus tard. Roxane est retirée dans un couvent, et Cyrano vient lui rendre visite toutes les semaines. Ce jour-là, victime d’un accident qui ressemble à un attentat, mourant, il lui demande de lire la dernière lettre de Christian. Alors qu’il la récite par cœur, Roxane comprend tout. Cyrano meurt en ayant reçu d’elle un baiser sur le front.")
                    -> setEpoque($epoque8090)
                    -> setGenre($genreDramatique)
                    -> setThematique($themeRomantisme)
                    ->setTrancheAge($trancheGrandPub)
                    ->setProdDer("Accessoires et déguisements d'époque, le fameux modèle d'épée du héro, la 'rapière' ainsi que de faux nez en plastique pour se mettre dans la peau du personange.")
                    ->setCompteurVues(0);
		$manager->persist($oeuvreCyrano);
		
		$oeuvreHobbit = new Oeuvre();
		$oeuvreHobbit -> setNom("Le Hobbit")
                    -> setConcept("Le hobbit Bilbo Bessac mène une existence paisible dans son trou de Cul-de-Sac jusqu’au jour où il croise le magicien Gandalf. Le lendemain, il a la surprise de voir venir prendre le thé chez lui non seulement Gandalf, mais également une compagnie de treize nains menée par Thorin Lécudechesne et composée de Balin, Dwalin, Fili, Kili, Dori, Nori, Ori, Oin, Gloin, Bifur, Bofur et Bombur. La compagnie est en route vers la Montagne Solitaire, où elle espère vaincre le dragon Smaug, qui a jadis dépossédé les nains de leur royaume et de leurs trésors. Cependant, pour mener à bien leurs projets, il leur faut un expert-cambrioleur, et Gandalf leur a recommandé Bilbo. Celui-ci est plus que réticent à l’idée de partir à l’aventure, mais il finit par accompagner la troupe.")
                    -> setEpoque($epoque3040)
                    -> setGenre($genreFantastique)
                    -> setThematique($themeQuete)
                    -> setTrancheAge($trancheGrandPub)
                    ->setProdDer("Il y a tout types de produits qui sont dérivés de cette oeuvre : des jeux vidéos, des figurines, ou encore des costumes.")
                    -> setCompteurVues(0);
		$manager->persist($oeuvreHobbit);
		
		$oeuvreDPS = new Oeuvre();
		$oeuvreDPS -> setNom("Le Cercle des Poètes Disparus")
                    -> setConcept("En 1959, aux États-Unis, Todd Anderson, un garçon timide, est envoyé dans la prestigieuse académie de Welton, dans le Vermont, réputée pour être l'une des plus fermées et austères du pays et où son frère a suivi de brillantes études. Il y fait la rencontre d'un professeur de lettres anglaises aux pratiques plutôt originales, M. Keating, qui encourage le refus du conformisme, l'épanouissement des personnalités et le goût de la liberté. Voulant au maximum suivre la voie nouvelle qui leur est présentée, certains élèves vont redonner vie au cercle des poètes disparus, un groupe d'esprits libres et oniriques, dont M. Keating fut, en son temps, l'un des membres influents. La découverte d'une autre vie va à jamais bouleverser l'avenir de ces étudiants. En effet, les situations des divers personnages ne se prêtent guère à l'exercice de ces libertés récemment découvertes.")
                    -> setProdDer("A faire")
                    -> setEpoque($epoque8090)
                    -> setGenre($genreDramatique)
                    -> setThematique($themeEcole)
                    -> setTrancheAge($trancheGrandPub)
                    -> setCompteurVues(0);
		$manager->persist($oeuvreDPS);
		
		/* ******************************************************* */
         /* Création des auteurs          */
        /* ******************************************************* */  
                    
		$AuteurGreen = new Auteur();
		$AuteurGreen  -> setNom("Green")
                     -> setPrenom("John");
		$manager->persist($AuteurGreen);
		
		$AuteurTolkien = new Auteur();
		$AuteurTolkien  -> setNom("Tolkien")
                     -> setPrenom("J.R.R.");
		$manager->persist($AuteurTolkien);
		
		$AuteurRostand = new Auteur();
		$AuteurRostand  -> setNom("Rostand")
                     -> setPrenom("Edmond");
		$manager->persist($AuteurRostand);
		
		$AuteurKleinbaum = new Auteur();
		$AuteurKleinbaum  -> setNom("Kleinbaum")
                     -> setPrenom("Nancy H.");
		$manager->persist($AuteurKleinbaum);
		 
		 /* ******************************************************* */
         /* Création des éditeurs          */
        /* ******************************************************* */  

		$EditeurNathan = new Editeur();
		$EditeurNathan -> setNom("Nathan");
		$manager->persist($EditeurNathan);
		
		$EditeurGall = new Editeur();
		$EditeurGall -> setNom("Gallimard");
		$manager->persist($EditeurGall);
		
		$EditeurAU = new Editeur();
		$EditeurAU -> setNom("Allen & Unwin");
		$manager->persist($EditeurAU);
		
		$EditeurLibrio = new Editeur();
		$EditeurLibrio -> setNom("Librio");
		$manager->persist($EditeurLibrio);
		
		$EditeurPoche = new Editeur();
		$EditeurPoche -> setNom("Le Livre de Poche");
	    $manager->persist($EditeurPoche);
		 
		 /* ******************************************************* */
         /* Création des livres           */
        /* ******************************************************* */  
         
		$LivreNEC = new Livre();
		$LivreNEC   -> setTitre("Nos étoiles contraires")
                     -> addAuteur($AuteurGreen)
                     -> setEditeur($EditeurNathan)
                     -> setOeuvre($oeuvreNEC)
                     -> setResume("Hazel, 16 ans, est atteinte d'un cancer. Son dernier traitement semble avoir arrêté l'évolution de la maladie, mais elle se sait condamnée. Bien qu'elle s'y ennuie passablement, elle intègre un groupe de soutien, fréquenté par d'autres jeunes malades. C'est là qu'elle rencontre Augustus, un garçon en rémission, qui partage son humour et son goût de la littérature. Entre les deux adolescents, l'attirance est immédiate. Et malgré les réticences d'Hazel, qui a peur de s'impliquer dans une relation dont le temps est compté, leur histoire d'amour commence... Les entraînant vite dans un projet un peu fou, ambitieux, drôle et surtout plein de vie.");
		$manager->persist($LivreNEC);
		 
		$LivreFCM = new Livre();
		$LivreFCM   -> setTitre("La face cachée de Margo")
                    -> addAuteur($AuteurGreen)
                    -> setEditeur($EditeurGall)
                    -> setOeuvre($oeuvreFCM)
                    -> setResume("Margo Roth Speigelman, le nom aux six syllabes qui fait fantasmer Quentin depuis toujours. Alors forcément, quand elle s'introduit dans sa chambre, une nuit, par la fenêtre ouverte, pour l'entraîner dans une expédition vengeresse, il la suit. Mais au lendemain de leur folle nuit blanche, Margo n'apparaît pas au lycée, elle a disparu. Quentin saura-t-il décrypter les indices qu'elle lui a laissés pour la retrouver ? Plus il s'en rapproche, plus Margo semble lui échapper...");
		$manager->persist($LivreFCM);
		
		$LivreLOTR1 = new Livre();
		$LivreLOTR1 -> setTitre("La Fraternité de l'Anneau")
                     -> addAuteur($AuteurTolkien)
					 -> setEditeur($EditeurAU)
                     -> setOeuvre($oeuvreLOTR)
                     -> setResume("Un jeune Hobbit nommé Frodon Sacquet, hérite d'un anneau. Mais il se trouve que cet anneau est L'Anneau UNIQUE, un instrument de pouvoir absolu crée pour Sauron, le Seigneur des ténèbres, pour lui permettre de régner sur la Terre du Milieu et de réduire en esclavage ses peuples. Frodon a donc comme mission de détruire l'anneau en le jetant dans les laves de la Crevasse du Destin où l'Anneau à été forgé et ainsi le détruir pour toujours. Pour cela, Frodon sera aidé d'une Compagnie constituée d'Hobbits, d'Hommes, d'un Magicien, d'un Nain, et d'un Elfe, Un tel périple signifie s'aventurer très loin en Mordor, les terres du Seigneur des ténèbres, où est rassemblée son armée d'Orques maléfiques. La Compagnie doit non seulement combattre les forces extérieures du mal mais aussi les dissensions internes et l'influence corruptrice qu'exerce l'Anneau lui-même sur Frodon...");
		$manager->persist($LivreLOTR1);
         
		$LivreLOTR2 = new Livre();
		$LivreLOTR2 -> setTitre("Les Deux Tours")
                     -> addAuteur($AuteurTolkien)
                     -> setEditeur($EditeurAU)
                     -> setOeuvre($oeuvreLOTR)
                     -> setResume("Frodon le Hobbit et ses Compagnons se sont engagés, au Grand Conseil d'Elrond, à détruire l'Anneau de Puissance dont Sauron de Mordor cherche à s'emparer pour asservir tous les peuples de la terre habitée : Elfes et Nains, Hommes et Hobbits.");
		$manager->persist($LivreLOTR2);
		 
		$LivreLOTR3 = new Livre();
		$LivreLOTR3 -> setTitre("Les Retour du Roi")
                     -> addAuteur($AuteurTolkien)
                     -> setEditeur($EditeurAU)
                     -> setOeuvre($oeuvreLOTR)
                     -> setResume("Tandis que le continent se couvre de ténèbres, annonçant pour le peuple des Hobbits l'aube d'une ère nouvelle, Frodon poursuit son entreprise. Alors qu'il n'a pu franchir la Porte Noire, il se demande comment atteindre le Mont du Destin. Peut-être est-il trop tard : le Seigneur des Ténèbres mobilise ses troupes. Les Rohirrim n'ont plus le temps d'en finir avec le traître assiégé dans l'imprenable tour d'Orthanc ; ils doivent se rassembler pour faire face à l'ennemi. Tentant une fois de plus sa chance, Frodon passe par le Haut Col, où il sera livré à l'abominable Arachné. Survivra-t-il à son dangereux périple à travers le Pays Noir ?");
		$manager->persist($LivreLOTR3);
		
		$LivreCyrano = new Livre();
		$LivreCyrano   -> setTitre("Cyrano De Bergerac")
                     -> addAuteur($AuteurRostand)
                     -> setEditeur($EditeurLibrio)
                     -> setOeuvre($oeuvreCyrano)
                     -> setResume("Le nez de Cyrano s'est mis en travers de son coeur. La belle Roxane aime ailleurs, en l'espèce un cadet sans esprit mais de belle apparence, Christian de Neuvillette. La pièce de Rostand met en scène la tragique complicité entre deux moitiés d'homme, et s'achève sur une évidence en forme d'espérance : sous les traits de Christian, ce n'était pas moins que l'âme de Cyrano qu'aimait Roxane. Avec ce drame en cinq actes, au travers des reprises ou des adaptations cinématographiques, Rostand a connu et connaît un succès ininterrompu et planétaire. Pourquoi ? A cause des qualités d'écriture, des vertus dramatiques ou de la réussite du personnage principal de la pièce ? Sans doute, pour une part. Mais la raison profonde tient à son art de caresser l'un de nos plus anciens mythes : il n'est pas de justice ici-bas, ni d'amour heureux. Presque pas. Et tout est dans cette manière de nous camper sur cette frontière, entre rêve et réalité, entre lune et terre.");
		$manager->persist($LivreCyrano);
		
		$LivreHobbit = new Livre();
		$LivreHobbit -> setTitre("Le Hobbit")
                     -> addAuteur($AuteurTolkien)
					 -> setEditeur($EditeurAU)
                     -> setOeuvre($oeuvreHobbit)
                     -> setResume("Le hobbit Bilbo Bessac mène une existence paisible dans son trou de Cul-de-Sac jusqu’au jour où il croise le magicien Gandalf. Le lendemain, il a la surprise de voir venir prendre le thé chez lui non seulement Gandalf, mais également une compagnie de treize nains menée par Thorin Lécudechesne et composée de Balin, Dwalin, Fili, Kili, Dori, Nori, Ori, Oin, Gloin, Bifur, Bofur et Bombur. La compagnie est en route vers la Montagne Solitaire, où elle espère vaincre le dragon Smaug, qui a jadis dépossédé les nains de leur royaume et de leurs trésors. Cependant, pour mener à bien leurs projets, il leur faut un expert-cambrioleur, et Gandalf leur a recommandé Bilbo. Celui-ci est plus que réticent à l’idée de partir à l’aventure, mais il finit par accompagner la troupe.");
		$manager->persist($LivreHobbit);
		
		$LivreDPS = new Livre();
		$LivreDPS   -> setTitre("Le Cercle des Poètes Disparus")
                     -> addAuteur($AuteurKleinbaum)
                     -> setEditeur($EditeurPoche)
                     -> setOeuvre($oeuvreDPS)
                     -> setResume("Il fut leur inspiration. Il a transformé leur vie à jamais. A Welton, un austère collège du Vermont, dans les années 60, la vie studieuse des pensionnaires est bouleversée par l'arrivée d'un nouveau professeur de lettres, M. Keating. Ce pédagogue peu orthodoxe va leur communiquer sa passion de la poésie, de la liberté, de l'anticonformisme, secouant la poussière des autorités parentales, académiques et sociales. Même si le drame - le suicide d'un adolescent - déchire finalement cette expérience unique, même si Keating doit quitter le collège, il restera pour tous celui qui leur a fait découvrir le sens de la vie.");
		$manager->persist($LivreDPS);
        		 
		 /* ******************************************************* */
         /* Création des acteurs          */
        /* ******************************************************* */  

		$ActeurWoodley = new Acteur();
		$ActeurWoodley -> setNom("Woodley")
                     -> setPrenom("Shailene");
		$manager->persist($ActeurWoodley);
         
		$ActeurElgort = new Acteur();
		$ActeurElgort -> setNom("Elgort")
                     -> setPrenom("Ansel");
		$manager->persist($ActeurElgort);
         
		$ActeurWolff = new Acteur();
		$ActeurWolff -> setNom("Wolff")
                     -> setPrenom("Nat");
		$manager->persist($ActeurWolff);
		 
		$ActeurDelevigne = new Acteur();
		$ActeurDelevigne -> setNom("Delevingne")
                    -> setPrenom("Cara");
		$manager->persist($ActeurDelevigne);
		
		$ActeurSmith = new Acteur();
		$ActeurSmith -> setNom("Smith")
                    -> setPrenom("Justice");
		$manager->persist($ActeurSmith);
		
		$ActeurWood = new Acteur();
		$ActeurWood -> setNom("Wood")
                         -> setPrenom("Elijah");
		$manager->persist($ActeurWood);
         
		$ActeurMortensen = new Acteur();
		$ActeurMortensen -> setNom("Mortensen")
                              -> setPrenom("Viggo");
		$manager->persist($ActeurMortensen);
         
		$ActeurMcKellen = new Acteur();
		$ActeurMcKellen -> setNom("McKellen")
                         -> setPrenom("Ian");
		$manager->persist($ActeurMcKellen);
         
		$ActeurBloom = new Acteur();
		$ActeurBloom -> setNom("Bloom")
                         -> setPrenom("Orlando");
		$manager->persist($ActeurBloom);
		
		$ActeurFerrer = new Acteur();
		$ActeurFerrer -> setNom("Ferrer")
                     -> setPrenom("José");
		$manager->persist($ActeurFerrer);
         
		$ActeurPowers = new Acteur();
		$ActeurPowers -> setNom("Powers")
                     -> setPrenom("Mala");
		$manager->persist($ActeurPowers);
         
		$ActeurPrince = new Acteur();
		$ActeurPrince -> setNom("Prince")
                     -> setPrenom("William");
		$manager->persist($ActeurPrince);
         
		$ActeurChristophe = new Acteur();
		$ActeurChristophe -> setNom("Christophe")
                     -> setPrenom("Francoise");
		$manager->persist($ActeurChristophe);
         
		$ActeurRoyer = new Acteur();
		$ActeurRoyer -> setNom("Le Royer")
                        -> setPrenom("Michel");
		$manager->persist($ActeurRoyer);
		 
		$ActeurDepardieu = new Acteur();
		$ActeurDepardieu -> setNom("Depardieu")
                        -> setPrenom("Gérard");
		$manager->persist($ActeurDepardieu);
         
		$ActeurBrochet = new Acteur();
		$ActeurBrochet -> setNom("Brochet")
                        -> setPrenom("Anne");
		$manager->persist($ActeurBrochet);
         
		$ActeurPerez = new Acteur();
		$ActeurPerez -> setNom("Perez")
                         -> setPrenom("Vincent");
		$manager->persist($ActeurPerez);
		
		$ActeurFreeman = new Acteur();
		$ActeurFreeman -> setNom("Freeman")
                         -> setPrenom("Martin");
		$manager->persist($ActeurFreeman);
		
		$ActeurHolm = new Acteur();
		$ActeurHolm -> setNom("Holm")
                         -> setPrenom("Ian");
		$manager->persist($ActeurHolm);
		
		$ActeurArmitage = new Acteur();
		$ActeurArmitage -> setNom("Armitage")
                         -> setPrenom("Richard");
		$manager->persist($ActeurArmitage);
		
		$ActeurWilliams = new Acteur();
		$ActeurArmitage -> setNom("Williams")
                         -> setPrenom("Robin");
		$manager->persist($ActeurWilliams);
		
		$ActeurLeonard = new Acteur();
		$ActeurLeonard -> setNom("Leonard")
                         -> setPrenom("Robert Sean");
		$manager->persist($ActeurLeonard);
		
		$ActeurHawke = new Acteur();
		$ActeurArmitage -> setNom("Hawke")
                         -> setPrenom("Ethan");
		$manager->persist($ActeurHawke);
		 
		 /* ******************************************************* */
         /* Création des réalisateurs          */
        /* ******************************************************* */  
         
		$RéalisateurBoone = new Realisateur();
		$RéalisateurBoone -> setNom("Boone")
                          -> setPrenom("Josh");
		$manager->persist($RéalisateurBoone);
		 
		$RéalisateurSchreier = new Realisateur();
		$RéalisateurSchreier -> setNom("Schreier")  
                         -> setPrenom("Jake");
		$manager->persist($RéalisateurSchreier);
		
		$RéalisateurJackson = new Realisateur();
		$RéalisateurJackson -> setNom("Jackson")
                                 -> setPrenom("Peter");
		$manager->persist($RéalisateurJackson);
		
		$RéalisateurGordon = new Realisateur();
		$RéalisateurGordon -> setNom("Gordon")
                          -> setPrenom("Michael");
		$manager->persist($RéalisateurGordon);
		 
		$RéalisateurBarma = new Realisateur();
		$RéalisateurBarma    -> setNom("Barma")
                                -> setPrenom("Claude");
		$manager->persist($RéalisateurBarma);
		 
		$RéalisateurRappeneau = new Realisateur();
		$RéalisateurRappeneau -> setNom("Rappeneau")
                             -> setPrenom("Jean-Paul");
		$manager->persist($RéalisateurRappeneau);
		
		$RéalisateurWeir = new Realisateur();
		$RéalisateurRappeneau -> setNom("Weir")
                             -> setPrenom("Peter");
		$manager->persist($RéalisateurWeir);
		 
		 /* ******************************************************* */
         /* Création des types          */
        /* ******************************************************* */  
         
		$TypeLongMetrage = new Type();
		$TypeLongMetrage -> setIntitule("Long Métrage");
		$manager->persist($TypeLongMetrage);
		 
		 /* ******************************************************* */
         /* Création des films          */
        /* ******************************************************* */  
         
		$FilmNEC = new Film();
		$FilmNEC -> setTitre("Nos étoiles contraires")
                  -> setDuree(133)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurBoone)
                  -> addActeur($ActeurWoodley)
                  -> addActeur($ActeurElgort)
                  -> addActeur($ActeurWolff)
                  -> setOeuvre($oeuvreNEC)
                  -> setSynopsis("Hazel Grace et Gus sont deux adolescents hors-normes, partageant un humour ravageur et le mépris des conventions. Leur relation est elle-même inhabituelle, étant donné qu’ils se sont rencontrés et sont tombés amoureux lors d'un groupe de soutien pour les malades du cancer.");
		$manager->persist($FilmNEC);
		 
		$FilmFCM = new Film();
		$FilmFCM -> setTitre("La face cachée de Margo")
                 -> setDuree(69)
                 -> setType($TypeLongMetrage)
                 -> setRealisateur($RéalisateurSchreier)
                 -> addActeur($ActeurDelevigne)
                 -> addActeur($ActeurWolff)
                 -> addActeur($ActeurSmith)
                 -> setOeuvre($oeuvreFCM)
                 -> setSynopsis("C'est l’histoire de Quentin et de Margo, sa voisine énigmatique, qui aimait tant les mystères qu’elle en est devenue un. Après l’avoir entraîné avec elle toute la nuit dans une expédition vengeresse à travers leur ville, Margo disparaît subitement – laissant derrière elle des indices qu’il devra déchiffrer. Sa recherche entraîne Quentin et sa bande de copains dans une aventure exaltante à la fois drôle et émouvante. Pour trouver Margo, Quentin va devoir découvrir le vrai sens de l’amitié… et de l’amour.");
		$manager->persist($FilmFCM);
		
		$FilmLOTR1 = new Film();
		$FilmLOTR1 -> setTitre("La Communauté de l'Anneau")
                   -> setDuree(165)
                   -> setType($TypeLongMetrage)
                   -> setRealisateur($RéalisateurJackson)
                   -> addActeur($ActeurWood)
                   -> addActeur($ActeurMortensen)
                   -> addActeur($ActeurMcKellen)
                   -> addActeur($ActeurBloom)
                   -> setOeuvre($oeuvreLOTR)
                   -> setSynopsis("Le jeune et timide hobbit Frodon Sacquet, hérite d'un anneau. Bien loin d'être une simple babiole, il s'agit de l'Anneau Unique, un instrument de pouvoir absolu qui permettrait à Sauron, le Seigneur des ténèbres, de régner sur la Terre du Milieu et de réduire en esclavage ses peuples. À moins que Frodon, aidé d'une Compagnie constituée de Hobbits, d'Hommes, d'un Magicien, d'un Nain, et d'un Elfe, ne parvienne à emporter l'Anneau à travers la Terre du Milieu jusqu'à la Crevasse du Destin, lieu où il a été forgé, et à le détruire pour toujours. Un tel périple signifie s'aventurer très loin en Mordor, les terres du Seigneur des ténèbres, où est rassemblée son armée d'Orques maléfiques... La Compagnie doit non seulement combattre les forces extérieures du mal mais aussi les dissensions internes et l'influence corruptrice qu'exerce l'Anneau lui-même.L'issue de l'histoire à venir est intimement liée au sort de la Compagnie.");
		$manager->persist($FilmLOTR1);
		 
		$FilmLOTR2 = new Film();
		$FilmLOTR2 -> setTitre("Les Deux Tours")
                   -> setDuree(178)
                   -> setType($TypeLongMetrage)
                   -> setRealisateur($RéalisateurJackson)
                   -> addActeur($ActeurWood)
                   -> addActeur($ActeurMortensen)
                   -> addActeur($ActeurMcKellen)
                   -> addActeur($ActeurBloom)
                   -> setOeuvre($oeuvreLOTR)
                   -> setSynopsis("Après la mort de Boromir et la disparition de Gandalf, la Communauté s'est scindée en trois. Perdus dans les collines d'Emyn Muil, Frodon et Sam découvrent qu'ils sont suivis par Gollum, une créature versatile corrompue par l'Anneau. Celui-ci promet de conduire les Hobbits jusqu'à la Porte Noire du Mordor. A travers la Terre du Milieu, Aragorn, Legolas et Gimli font route vers le Rohan, le royaume assiégé de Theoden. Cet ancien grand roi, manipulé par l'espion de Saroumane, le sinistre Langue de Serpent, est désormais tombé sous la coupe du malfaisant Magicien. Eowyn, la nièce du Roi, reconnaît en Aragorn un meneur d'hommes. Entretemps, les Hobbits Merry et Pippin, prisonniers des Uruk-hai, se sont échappés et ont découvert dans la mystérieuse Forêt de Fangorn un allié inattendu : Sylvebarbe, gardien des arbres, représentant d'un ancien peuple végétal dont Saroumane a décimé la forêt... ");
		$manager->persist($FilmLOTR2);
		 
		$FilmLOTR3 = new Film();
		$FilmLOTR3 -> setTitre("Le Retour du Roi")
                   -> setDuree(200)
                   -> setType($TypeLongMetrage)
                   -> setRealisateur($RéalisateurJackson)
                   -> addActeur($ActeurWood)
                   -> addActeur($ActeurMortensen)
                   -> addActeur($ActeurMcKellen)
                   -> addActeur($ActeurBloom)
                   -> setOeuvre($oeuvreLOTR)
                   -> setSynopsis("Les armées de Sauron ont attaqué Minas Tirith, la capitale de Gondor. Jamais ce royaume autrefois puissant n'a eu autant besoin de son roi. Mais Aragorn trouvera-t-il en lui la volonté d'accomplir sa destinée ? Tandis que Gandalf s'efforce de soutenir les forces brisées de Gondor, Théoden exhorte les guerriers de Rohan à se joindre au combat. Mais malgré leur courage et leur loyauté, les forces des Hommes ne sont pas de taille à lutter contre les innombrables légions d'ennemis qui s'abattent sur le royaume... Chaque victoire se paye d'immenses sacrifices. Malgré ses pertes, la Communauté se jette dans la bataille pour la vie, ses membres faisant tout pour détourner l'attention de Sauron afin de donner à Frodon une chance d'accomplir sa quête. Voyageant à travers les terres ennemies, ce dernier doit se reposer sur Sam et Gollum, tandis que l'Anneau continue de le tenter... ");
		$manager->persist($FilmLOTR3);
		 
		$FilmCyrano = new Film();
		$FilmCyrano -> setTitre("Cyrano De Bergerac")
                  -> setDuree(167)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurGordon)
                  -> addActeur($ActeurFerrer)
                  -> addActeur($ActeurPowers)
                  -> addActeur($ActeurPrince)
                  -> setOeuvre($oeuvreCyrano)
                  -> setSynopsis("Au XVIIe siècle, l'aimable poète et terrible bretteur qu'est Cyrano de Bergerac, affligé d'un nez disgracieux, souffre en secret de ne pouvoir gagner l'amour de sa cousine Roxane qui lui préfère un fat sans esprit mais redoutablement beau, Christian. Cyrano met son art au service de Christian et lui assure l'amour de la belle...");
		$manager->persist($FilmCyrano);

		$FilmCyrano2 = new Film();
		$FilmCyrano2 -> setTitre("Cyrano De Bergerac")
                  -> setDuree(280)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurBarma)
                  -> addActeur($ActeurChristophe)
                  -> addActeur($ActeurRoyer)
                  -> setOeuvre($oeuvreCyrano)
                  -> setSynopsis("Amoureux de Roxane, qui est elle-même éprise du jeune cadet de Gascogne, Christian de Neuvilette, Cyrano dicte au jeune homme ses mots d’amour. Mais le Comte de Guiche, rival malheureux, se venge en envoyant Christian et Cyrano au siège d’Arras. Durant l’assaut, Christian est tué. Roxane se retire au couvent. Quinze ans plus tard, Cyrano lui révèle la vérité mais il meurt, laissant la jeune femme plongée dans la souffrance un amour deux fois perdu.");
		$manager->persist($FilmCyrano2);

		$FilmCyrano3 = new Film();
		$FilmCyrano3 -> setTitre("Cyrano De Bergerac 3")
                  -> setDuree(257)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurRappeneau)
                  -> addActeur($ActeurDepardieu)
                  -> addActeur($ActeurBrochet)
                  -> addActeur($ActeurPerez)
                  -> setOeuvre($oeuvreCyrano)
                  -> setSynopsis("Cyrano de Bergerac, poète, bretteur et fort-en-gueule, interrompt une représentation théâtrale à l'Hôtel de Bourgogne parce que l'interprétation du comédien Montfleury lui déplaît. Le vicomte de Valvert, que le comte de Guiche destine à sa cousine, Roxane, dont Cyrano est éperdument amoureux, le provoque en raillant la taille de son nez. Cyrano l'écrase d'une cascade de bons mots, avant de le clouer au sol d'un coup d'épée. Lorsque la belle Roxane veut lui confier un secret, son coeur vacille. Mais la frêle enfant aime Christian, un jeune fat, beau comme un dieu et sot comme un pâtre. Cyrano prête à Christian son esprit pour l'aider à conquérir la demoiselle... ");
		$manager->persist($FilmCyrano3);
		
		$FilmHobbit1 = new Film();
		$FilmHobbit1 -> setTitre("Le Hobbit - Un Voyage Inattendu")
                   -> setDuree(169)
                   -> setType($TypeLongMetrage)
                   -> setRealisateur($RéalisateurJackson)
                   -> addActeur($ActeurFreeman)
                   -> addActeur($ActeurHolm)
                   -> addActeur($ActeurMcKellen)
                   -> addActeur($ActeurArmitage)
                   -> setOeuvre($oeuvreHobbit)
                   -> setSynopsis("Le hobbit Bilbo Bessac mène une existence paisible dans son trou de Cul-de-Sac jusqu’au jour où il croise le magicien Gandalf. Le lendemain, il a la surprise de voir venir prendre le thé chez lui non seulement Gandalf, mais également une compagnie de treize nains menée par Thorin Lécudechesne et composée de Balin, Dwalin, Fili, Kili, Dori, Nori, Ori, Oin, Gloin, Bifur, Bofur et Bombur. La compagnie est en route vers la Montagne Solitaire, où elle espère vaincre le dragon Smaug, qui a jadis dépossédé les nains de leur royaume et de leurs trésors. Cependant, pour mener à bien leurs projets, il leur faut un expert-cambrioleur, et Gandalf leur a recommandé Bilbo. Celui-ci est plus que réticent à l’idée de partir à l’aventure, mais il finit par accompagner la troupe.");
		$manager->persist($FilmHobbit1);
		
		$FilmHobbit2 = new Film();
		$FilmHobbit2 -> setTitre("Le Hobbit - La Désolation de Smaug")
                   -> setDuree(161)
                   -> setType($TypeLongMetrage)
                   -> setRealisateur($RéalisateurJackson)
                   -> addActeur($ActeurFreeman)
                   -> addActeur($ActeurMcKellen)
                   -> addActeur($ActeurArmitage)
                   -> setOeuvre($oeuvreHobbit)
                   -> setSynopsis("Bilbo Sacquet est parti reconquérir le Mont Solitaire et le Royaume perdu des Nains d'Erebor, en compagnie du magicien Gandalf le Gris et des 13 nains, dont le chef n'est autre que Thorin Écu-de-Chêne. Après avoir survécu à un périple inattendu, la petite bande s'enfonce vers l'Est, où elle croise Beorn, le Changeur de Peau, et une nuée d'araignées géantes au cœur de la Forêt Noire qui réserve bien des dangers. Alors qu'ils ont failli être capturés par les redoutables Elfes Sylvestres, les Nains arrivent à Esgaroth, puis au Mont Solitaire, où ils doivent affronter le danger le plus terrible – autrement dit, la créature la plus terrifiante de tous les temps qui mettra à l'épreuve le courage de nos héros, mais aussi leur amitié et le sens même de leur voyage : le Dragon Smaug.");
		$manager->persist($FilmHobbit2);
		
		$FilmHobbit3 = new Film();
		$FilmHobbit3 -> setTitre("Le Hobbit - La Bataille des Cinq Armées")
                   -> setDuree(144)
                   -> setType($TypeLongMetrage)
                   -> setRealisateur($RéalisateurJackson)
                   -> addActeur($ActeurFreeman)
                   -> addActeur($ActeurHolm)
                   -> addActeur($ActeurMcKellen)
                   -> addActeur($ActeurArmitage)
                   -> setOeuvre($oeuvreHobbit)
                   -> setSynopsis("Atteignant enfin la Montagne Solitaire, Thorin et les Nains, aidés par Bilbo le Hobbit, ont réussi à récupérer leur royaume et leur trésor. Mais ils ont également réveillé le dragon Smaug qui déchaîne désormais sa colère sur les habitants de Lac-ville. A présent, les Nains, les Elfes, les Humains mais aussi les Wrags et les Orques menés par le Nécromancien, convoitent les richesses de la Montagne Solitaire. La bataille des cinq armées est imminente et Bilbon est le seul à pouvoir unir ses amis contre les puissances obscures de Sauron.");
		$manager->persist($FilmHobbit3);
		
		$FilmDPS = new Film();
		$FilmDPS -> setTitre("Le Cercle des Poètes Disparus")
                  -> setDuree(128)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurWeir)
                  -> addActeur($ActeurWilliams)
                  -> addActeur($ActeurLeonard)
                  -> addActeur($ActeurHawke)
                  -> setOeuvre($oeuvreDPS)
                  -> setSynopsis("Todd Anderson, un garçon plutôt timide, est envoyé dans la prestigieuse académie de Welton, réputée pour être l'une des plus fermées et austères des États-Unis, là où son frère avait connu de brillantes études.C'est dans cette université qu'il va faire la rencontre d'un professeur de lettres anglaises plutôt étrange, Mr Keating, qui les encourage à toujours refuser l'ordre établi. Les cours de Mr Keating vont bouleverser la vie de l'étudiant réservé et de ses amis...");
		$manager->persist($FilmDPS);
		 
		 /* ******************************************************* */
         /* Création des images          */
        /* ******************************************************* */  

		$ImageNEC = new Image();
		$ImageNEC  -> setUrl("http://www.photogeniques.fr/wp-content/uploads/2014/09/The-Fault-in-Our-Stars_tfios_Nos-etoiles-contraires_okay-okay.jpg")
                    -> setOeuvre($oeuvreNEC);
		$manager->persist($ImageNEC);
		
		$ImageFCM = new Image();
		$ImageFCM  -> setUrl("http://www.virginradiovendee.fr/vrv/wp-content/uploads/2015/08/facecacheemargo.png")
                    -> setOeuvre($oeuvreFCM);
		$manager->persist($ImageFCM);
		
		$ImageLOTR = new Image();
		$ImageLOTR  -> setUrl("http://gardoum.com/wp-content/uploads/2015/10/92359592_o.jpg")
                    ->setOeuvre($oeuvreLOTR);
		$manager->persist($ImageLOTR);
		
		$ImageCyrano = new Image();
		$ImageCyrano -> setUrl("http://www.revistarambla.com/v1/images/ARTICULOS/2014%20ENERO/sirano_rambla_02.jpg")
                      -> setOeuvre($oeuvreCyrano);
		$manager->persist($ImageCyrano);
		
		$ImageHobbit = new Image();
		$ImageHobbit -> setUrl("http://www.lescinemasaixois.com/films/medias/photo18_8616.jpg")
                      -> setOeuvre($oeuvreHobbit);
		$manager->persist($ImageHobbit);
		
		$ImageDPS = new Image();
		$ImageDPS -> setUrl("http://www.linternaute.com/cinema/diaporama/07/repliques-les-plus-celebres/images/le-cercle-des-poetes-disparus.jpg")
                      -> setOeuvre($oeuvreDPS);
		$manager->persist($ImageDPS);
		
		/* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */

        // On déclenche l'enregistrement de toutes les données en BD
		$manager->flush();
    }
}




?>