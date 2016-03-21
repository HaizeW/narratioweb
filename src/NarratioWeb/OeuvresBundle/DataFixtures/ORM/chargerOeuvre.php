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
use NarratioWeb\OeuvresBundle\Entity\Note;

class Oeuvres implements FixtureInterface
{
    // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
    public function load(ObjectManager $manager)
    {
        
        /* ******************************************************* */
        /* Création des epoques     */
        /* ******************************************************* */
        
        $epoqueContemporaine = new Epoque();
		$epoqueContemporaine->setIntitule("Contemporaine");
		$manager->persist($epoqueContemporaine);
		
		$epoqueFuturiste = new Epoque();
		$epoqueFuturiste->setIntitule("Futuriste");
		$manager->persist($epoqueFuturiste);
        
		$epoqueModerne = new Epoque();
		$epoqueModerne->setIntitule("Moderne");
		$manager->persist($epoqueModerne);
		
		$epoqueMoyenAge = new Epoque();
		$epoqueMoyenAge->setIntitule("Moyen Age");
		$manager->persist($epoqueMoyenAge);
		
		$epoqueAntiquite = new Epoque();
		$epoqueAntiquite->setIntitule("Antiquite");
		$manager->persist($epoqueAntiquite);
        
		//$epoqueAvantJC = new Epoque();
		//$epoqueAvantJC->setIntitule("Avant JC");
		//$manager->persist($epoqueAvantJC);
        
        /* ******************************************************* */
        /* Création des genres     */
        /* ******************************************************* */
        
		$genreScienceFiction = new Genre();
		$genreScienceFiction->setIntitule("Science Fiction");
		$manager->persist($genreScienceFiction);
        
		$genreDrame = new Genre();
		$genreDrame->setIntitule("Drame");
		$manager->persist($genreDrame);
		
		$genreComedie = new Genre();
		$genreComedie->setIntitule("Comedie");
		$manager->persist($genreComedie);
		
		$genreAction = new Genre();
		$genreAction->setIntitule("Action");
		$manager->persist($genreAction);
		
		$genreAventure = new Genre();
		$genreAventure->setIntitule("Aventure");
		$manager->persist($genreAventure);
        
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
		
		$themeSurvie = new Thematique();
		$themeSurvie ->setIntitule("Survie-Invasion");
		$manager->persist($themeSurvie);
		
		$themeDictature = new Thematique();
		$themeDictature ->setIntitule("Dictature");
		$manager->persist($themeDictature);
		
		$themeEnquete = new Thematique();
        $themeEnquete->setIntitule("Enquête");
        $manager->persist($themeEnquete);
        
        /* ******************************************************* */
        /* Création des tranches d'âge     */
        /* ******************************************************* */
        
        $trancheAdo = new TrancheAge();
		$trancheAdo->setIntitule("Adolescent");
		$manager->persist($trancheAdo);
        
		$trancheAdulte = new TrancheAge();
		$trancheAdulte->setIntitule("Adulte");
		$manager->persist($trancheAdulte);
		
		$trancheGrandPub = new TrancheAge();
		$trancheGrandPub->setIntitule("Grand Public");
		$manager->persist($trancheGrandPub);
        
        /* ******************************************************* */
         /* Création des oeuvres          */
        /* ******************************************************* */  

		$oeuvreHG = new Oeuvre();
		$oeuvreHG -> setNom("Hunger Games")
						-> setConcept("Dans l'histoire de Hunger Games, située dans un futur indéterminé, la nation de « Panem » est née des cendres de l'Amérique du Nord et est dirigée par le Président Snow. La capitale de Panem est une ville appelée le Capitole. Le pays est divisé en douze districts, vivant sous différents seuils de pauvreté, contrôlés par le Capitole. Le district Treize a été détruit 74 ans avant le début du roman Hunger Games, durant une période appelée les Jours Obscurs, le soulèvement des districts contre le Capitole. Pour rappeler aux habitants des districts que les jours obscurs ne devaient pas se reproduire, les Hunger Games furent créés.")
						-> setProdDer("Trois tomes de ces livres Hunger Games sont déjà en vente : le Hunger Games Tome 1 (intitulé Hunger Games), le Tome 2 (intitulé L’Embrasement) et récemment le Tome 3 est aussi apparu sous le titre de Mockingjay. Et avec la sortie du film de Gary Ross en France, divers produits dérivés de la série sont actuellement disponibles sur le marché, en plus des versions du film en DVD ou en Blu Ray.")
						-> setEpoque($epoqueFuturiste)
						-> setGenre($genreScienceFiction)
						-> setThematique($themeDictature)
						-> setTrancheAge($trancheGrandPub)
						-> setCompteurVues(0);
		$manager->persist($oeuvreHG);
				
				$oeuvreNEC = new Oeuvre();
				$oeuvreNEC -> setNom("Nos Etoiles Contraires")
							-> setConcept("Deux adolescents atteints de cancer, Hazel Grace et Augustus Waters, se connaissent dans un groupe de soutien. Les deux adolescents se passionnent pour un roman de Peter Van Houten, qui se termine brutalement au milieu d'une phrase. Curieux du sort des personnages, Hazel et Augustus envisagent de se rendre à Amsterdam afin de rencontrer l'auteur. Ils effectuent le voyage grâce à une fondation d'aide aux enfants malades qui se charge d'exaucer leur vœu le plus cher…")
							-> setProdDer   ("Accessoires et vêtements avec le titre du livre ou la phrase «ok? ok.»
											B.O. avec artistes invités comme Charlie XCX
											Histoire de Esther Earl, jeune fille qui a inspiré John Green a écrire l'histoire: This Star Won't Go Out: The Life and Words of Esther Grace Earl")
							-> setEpoque($epoqueModerne)
							-> setGenre($genreDrame)
							-> setThematique($themeSens)
							-> setTrancheAge($trancheAdo)
							-> setCompteurVues(0);
				$manager->persist($oeuvreNEC);
		 
		$oeuvreFCM = new Oeuvre();
		$oeuvreFCM  -> setNom("La face cachée de Margo")
                    -> setConcept("D’après le best-seller homonyme, La Face Cachée de Margo est l’histoire de Quentin et de Margo, sa voisine énigmatique. Après l’avoir entraîné avec elle toute la nuit dans une expédition vengeresse à travers leur Orlando, Margo disparaît subitement – laissant derrière elle des indices qu’il devra déchiffrer...")
                    -> setProdDer("B.O. et Blue-Ray")
                    -> setEpoque($epoqueMoyenAge)
                    -> setGenre($genreDrame)
                    -> setThematique($themeSens)
                    -> setTrancheAge($trancheAdo)
                    -> setCompteurVues(0);
		$manager->persist($oeuvreFCM);
		
		$oeuvreLOTR = new Oeuvre();
		$oeuvreLOTR -> setNom("Le Seigneur des Anneaux")
                    -> setConcept("Un jeune Hobbit nommé Frodon Sacquet, hérite d'un anneau. Mais il se trouve que cet anneau est L'Anneau UNIQUE, un instrument de pouvoir absolu crée pour Sauron, le Seigneur des ténèbres, pour lui permettre de régner sur la Terre du Milieu et de réduire en esclavage ses peuples. Frodon a donc comme mission de détruire l'anneau en le jetant dans les laves de la Crevasse du Destin où l'Anneau à été forgé et ainsi le détruir pour toujours. Pour cela, Frodon sera aidé d'une Compagnie constituée d'Hobbits, d'Hommes, d'un Magicien, d'un Nain, et d'un Elfe, Un tel périple signifie s'aventurer très loin en Mordor, les terres du Seigneur des ténèbres, où est rassemblée son armée d'Orques maléfiques. La Compagnie doit non seulement combattre les forces extérieures du mal mais aussi les dissensions internes et l'influence corruptrice qu'exerce l'Anneau lui-même sur Frodon...")
                    -> setEpoque($epoqueAntiquite)
                    -> setGenre($genreAventure)
                    -> setThematique($themeQuete)
                    -> setTrancheAge($trancheAdulte)
                    ->setProdDer("Tous types de produits dérivés sont trouvables : jeux videos, jeux de société, vetements, l'Anneau, ainsi que des figurines en tous genres (exposition, jeu de role ou maquette à taille réelle).")
                    -> setCompteurVues(0);
		$manager->persist($oeuvreLOTR);
		
		$oeuvreCyrano = new Oeuvre();
		$oeuvreCyrano -> setNom("Cyrano De Bergerac")
                    -> setConcept("Cyrano deBergerac est un turbulent mousquetaire de la compagnie des Cadets de Gascogne. Il est amoureux de sa cousine, la belle Roxane,mais n’ose pas le lui avouer car il est complexé par son nez difforme, même s’il défend cette difformité brillamment quand un vicomte trop audacieux se risque à lui faire une remarque. Lorsque Roxane sollicite une entrevue avec lui à la rôtisserie de Ragueneau, Cyrano est plein d’espoir, mais Roxane luirévèle qu’elle aime Christian, beau jeune homme qui s’apprête à entrer chez les Cadets de Gascogne, et elle demande à Cyrano de le protéger. Cyrano accepte et va même plus loin, puisqu’il conclut un pacte avec Christian, qui est beau mais peu spirituel : il va lui dicter les mots d’amour que Christian dira à Roxane. Grâce auxbons mots de Cyrano, Christian gagne le cœur de Roxane ils se marient très rapidement. Cependant De Guiche, rival jaloux, fait envoyer les Cadets de Gascogne à la guerre, au siège d’Arras. Cyrano y protège toujours Christian et envoie tous les jours des lettres à Roxane au nom de celui-ci. Néanmoins Christian s’aperçoit que Roxane l’aime surtout pour ce qu’elle croit être son bel esprit et qu’elle aime donc en réalité, sans le savoir, Cyrano. Il refuse de prolonger l’imposture et exige de Cyrano qu’il dise la vérité à Roxane. Mais au moment où Cyrano s’apprête à tout avouer, Christian est tué au front. Cyrano décide donc de se taire à jamais. L'histoire se ﬁnit quinze ans plus tard. Roxane est retirée dans un couvent, et Cyrano vient lui rendre visite toutes les semaines. Ce jour-là, victime d’un accident qui ressemble à un attentat, mourant, il lui demande de lire la dernière lettre de Christian. Alors qu’il la récite par cœur, Roxane comprend tout. Cyrano meurt en ayant reçu d’elle un baiser sur le front.")
                    -> setEpoque($epoqueContemporaine)
                    -> setGenre($genreComedie)
                    -> setThematique($themeRomantisme)
                    ->setTrancheAge($trancheGrandPub)
                    ->setProdDer("Accessoires et déguisements d'époque, le fameux modèle d'épée du héro, la 'rapière' ainsi que de faux nez en plastique pour se mettre dans la peau du personange.")
                    ->setCompteurVues(0);
		$manager->persist($oeuvreCyrano);
		
		$oeuvreHobbit = new Oeuvre();
		$oeuvreHobbit -> setNom("Le Hobbit")
                    -> setConcept("Le hobbit Bilbo Bessac mène une existence paisible dans son trou de Cul-de-Sac jusqu’au jour où il croise le magicien Gandalf. Le lendemain, il a la surprise de voir venir prendre le thé chez lui non seulement Gandalf, mais également une compagnie de treize nains menée par Thorin Lécudechesne et composée de Balin, Dwalin, Fili, Kili, Dori, Nori, Ori, Oin, Gloin, Bifur, Bofur et Bombur. La compagnie est en route vers la Montagne Solitaire, où elle espère vaincre le dragon Smaug, qui a jadis dépossédé les nains de leur royaume et de leurs trésors. Cependant, pour mener à bien leurs projets, il leur faut un expert-cambrioleur, et Gandalf leur a recommandé Bilbo. Celui-ci est plus que réticent à l’idée de partir à l’aventure, mais il finit par accompagner la troupe.")
                    -> setEpoque($epoqueMoyenAge)
                    -> setGenre($genreAventure)
                    -> setThematique($themeQuete)
                    -> setTrancheAge($trancheGrandPub)
                    ->setProdDer("Il y a tout types de produits qui sont dérivés de cette oeuvre : des jeux vidéos, des figurines, ou encore des costumes.")
                    -> setCompteurVues(0);
		$manager->persist($oeuvreHobbit);
		
		$oeuvreDPS = new Oeuvre();
		$oeuvreDPS -> setNom("Le Cercle des Poètes Disparus")
                    -> setConcept("En 1959, aux États-Unis, Todd Anderson, un garçon timide, est envoyé dans la prestigieuse académie de Welton, dans le Vermont, réputée pour être l'une des plus fermées et austères du pays et où son frère a suivi de brillantes études. Il y fait la rencontre d'un professeur de lettres anglaises aux pratiques plutôt originales, M. Keating, qui encourage le refus du conformisme, l'épanouissement des personnalités et le goût de la liberté. Voulant au maximum suivre la voie nouvelle qui leur est présentée, certains élèves vont redonner vie au cercle des poètes disparus, un groupe d'esprits libres et oniriques, dont M. Keating fut, en son temps, l'un des membres influents. La découverte d'une autre vie va à jamais bouleverser l'avenir de ces étudiants. En effet, les situations des divers personnages ne se prêtent guère à l'exercice de ces libertés récemment découvertes.")
                    -> setProdDer("Le film a été adapté en spectacle à Broadway.")
                    -> setEpoque($epoqueModerne)
                    -> setGenre($genreDrame)
                    -> setThematique($themeEcole)
                    -> setTrancheAge($trancheGrandPub)
                    -> setCompteurVues(0);
		$manager->persist($oeuvreDPS);
		
		$oeuvreGdM = new Oeuvre();
		$oeuvreGdM -> setNom("La Guerre des Mondes")
						-> setConcept("La Guerre des mondes (The War of the Worlds) est un roman de science-fiction écrit par H. G. Wells, publié en 1898.
                            C'est l'une des premières œuvres qui confronte l'humanité et une race extraterrestre hostile1, et le reflet de l'angoisse de l'époque victorienne et de l'impérialisme.")
						-> setProdDer("On peut trouver le livre écrit en 1898 sur le net, mais aussi le film sorti en 2005. D'autres goodies sont aussi disponibles comme par exemple des figurines des fameuses 'créatures' attanquant la terre.")
						-> setEpoque($epoqueModerne)
						-> setGenre($genreScienceFiction)
						-> setThematique($themeSurvie )
						-> setTrancheAge($trancheAdulte)
						-> setCompteurVues(0);
		$manager->persist($oeuvreGdM );
		
		$oeuvreDiv = new Oeuvre();
		$oeuvreDiv -> setNom("Divergente")
						-> setConcept("Tris vit dans un monde post apocalyptique où la société est divisée en cinq clans (Audacieux, Erudits, Altruistes, Sincères, Fraternels). A 16 ans, elle doit choisir son appartenance pour le reste de sa vie. Cas rarissime, son test d’aptitudes n’est pas concluant ; elle est Divergente. Les Divergents sont des individus rares n’appartenant à aucun clan et sont traqués par le gouvernement. Dissimulant son secret, elle intègre l’univers brutal des Audacieux dont l’entrainement est basé sur la maitrise de nos peurs les plus intimes.")
						-> setProdDer("Posters, B.O. des films, Une histoire de Divergente: Quatre et Accessoires représentant les factions.")
						-> setEpoque($epoqueFuturiste)
						-> setGenre($genreAction)
						-> setThematique($themeDictature)
						-> setTrancheAge($trancheAdo)
						-> setCompteurVues(0);
		$manager->persist($oeuvreDiv);
		
		$oeuvreCOE = new Oeuvre();
		$oeuvreCOE->setNom("Le Crime de l'Orient-Express")
						-> setConcept("Hercule Poirot, venu résoudre une affaire, est en Syrie à la gare d’Alep, à 5 heures du matin. Il repart à Istanbul où il compte faire un peu de tourisme. Quand il arrive à l’hôtel, le concierge, lui donne un télégramme lui disant de retourner à Londres. Il prend alors un billet pour l’Orient-Express en direction de Londres et va manger au restaurant de l’hôtel. Il reconnait son ami M. Bouc qui va aussi en direction de Londres. Dans le train, M. Ratchett, un riche américain est tué au milieu de la nuit. Il examine le corps avec l’aide du docteur Constantine. Il a été tué de douze coups de couteau. M. Poirot découvre vite que le vrai nom de M. Ratchett est Cassetti, connu comme ayant dirigé la bande qui avait enlevé la petite Daisy Armstrong et exigé une rançon de deux cent mille dollars. Le cadavre de la petite fille fut retrouvé après le paiement de la rançon. Traumatisée, la mère de Daisy mourut en accouchant d’un deuxième enfant et son mari, désespéré, se tira une balle dans la tête. Poirot, en collaboration avec M. Bouc et le docteur Constantine, interroge les passagers du train et découvre un grand nombre d’informations complémentaires.")
						-> setProdDer("Cette histoire, en plus d'être à l'origine un livre, puis adaptée en film, a également été adaptée en feuilleton radiophonique de 5 épisodes. Il y a également eu une band dessinée et un jeu vidéo sur PC.")
						-> setEpoque($epoqueModerne)
						-> setGenre($genreAction)
						-> setThematique($themeEnquete)
						-> setTrancheAge($trancheGrandPub)
						-> setCompteurVues(0);
		$manager->persist($oeuvreCOE);
		
		/* ******************************************************* */
         /* Création des auteurs          */
        /* ******************************************************* */  
                    
		$AuteurCollins = new Auteur();
		$AuteurCollins  -> setNom("Collins")
					-> setPrenom("Suzanne");
		$manager->persist($AuteurCollins);
					
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
		
		$AuteurWells = new Auteur();
		$AuteurWells -> setNom("Wells")
				-> setPrenom("H.G");
		$manager->persist($AuteurWells);
		
		$AuteurRoth = new Auteur();
		$AuteurRoth -> setNom("Roth")
				    -> setPrenom("Veronica");
		$manager->persist($AuteurRoth);
		
		$AuteurChristie = new Auteur();
		$AuteurChristie -> setNom("Christie")
		                -> setPrenom("Agatha");
		$manager->persist($AuteurChristie);
		 
		 /* ******************************************************* */
         /* Création des éditeurs          */
        /* ******************************************************* */  

		$EditeurPocket = new Editeur();
		$EditeurPocket -> setNom("Pocket");
		$manager->persist($EditeurPocket);
		
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
	    
	    $EditeurHeinemann = new Editeur();
		$EditeurHeinemann -> setNom("Heinemann");
		$manager->persist($EditeurHeinemann );
		
		$EditeurCCC = new Editeur();
		$EditeurCCC -> setNom("Collins Crime Club");
		$manager->persist($EditeurCCC);
		
		/* ******************************************************* */
         /* Création des images pour livres           */
        /* ******************************************************* */  
		$ImageLHG1 = new Image();
		$ImageLHG1 -> setUrl("http://www.juliemag.com/files/hungergames-770x400.jpg");
		$manager->persist($ImageLHG1);
		
		 /* ******************************************************* */
         /* Création des livres           */
        /* ******************************************************* */  
         
		$LivreHG1 = new Livre();
		$LivreHG1   -> setTitre("Hunger Games")
						-> addAuteur($AuteurCollins)
						-> setEditeur($EditeurPocket)
						-> setOeuvre($oeuvreHG)
						-> setAnnee(2008)
						-> setResume("Dans un futur sombre des Etats-Unis divisés par 12 districts et un capitole, un jeu télévisé est diffusé pour contrôler le peuple par la terreur. Cette émission doit être obligatoirement visionnée par tous. Chaque année, le jour de la moisson 12 filles et 12 garçons sont tirés au sort pour participer à cette téléréalité. Ces 24 participants sont alors placés dans une vaste arène où ils devront s'entretuer. Un seul survivra à ce jeu : le gagnant. Celui-ci pourra revenir chez lui riche et célèbre et grâce à lui, le district auquel il appartient pourra manger à sa faim pendant un an. Katniss, une jeune fille de 16 ans a dû apprendre à chasser pour nourrir sa famille. Comme tous, elle redoute que son nom soit tiré au sort le jour de la moisson. Son cauchemar deviendra pire que ce qu'elle aurait pu imaginer puisque c'est le nom de sa petite soeur qui retentit dans le micro ce soir là. Sans réfléchir, elle se lancera sur la scène et demandera à prendre sa place. Elle deviendra alors, l'une des participantes des Hunger Games.")
						-> setImage($ImageLHG1);
		$manager->persist($LivreHG1);
		
		$LivreHG2 = new Livre();
		$LivreHG2   -> setTitre("Hunger Games l'Embrasement")
						-> addAuteur($AuteurCollins)
						-> setEditeur($EditeurPocket)
						-> setOeuvre($oeuvreHG)
						-> setAnnee(2009)
						-> setResume("Katniss et Peeta doivent effectuer la tournée de la victoire à travers les différents districts. Tout le monde est impatient de les retrouver mais le capitole les attend au tournant, il s'agit surtout de se rattraper et de prouver que Katniss n'a jamais voulu défier le capitole avec ces baies. Le président Snow surveille et fait bien comprendre à Katniss l'importance qu'aura son attitude lors de cette tournée. Katniss a lancé un vent de révolte dans les districts et elle en paiera le prix fort. Je m'attendais pas à ça, je croyais deviner ce qui allait se passer : Katniss et Peeta allaient faire leur tournée et Katniss finirait par tomber amoureuse de Peeta, les districts allaient se révolter et tout finirait bien dans le meilleur des mondes... Et bien tout le contraire justement ! C'est de surprise en surprise qu'on dévore une nouvelle fois ces Hunger games, on agrippe ce bouquin comme si on allait nous le voler, on ne s'attend à rien et ce jusqu'à la fin !");
		$manager->persist($LivreHG2);
		
		$LivreHG3 = new Livre();
		$LivreHG3   -> setTitre("Hunger Games la Revolte")
						-> addAuteur($AuteurCollins)
						-> setEditeur($EditeurPocket)
						-> setOeuvre($oeuvreHG)
						-> setAnnee(2010)
						-> setResume("Ce troisième et dernier tome de la série nous apporte toutes les réponses aux questions et c'est - hélas - son seul intérêt. Ecrire un troisième tome de Hunger Games sans Hunger Games, le challenge était difficile, et malheureusement le pari a été largement perdu par Suzanne Collins. Autant j'avais été épaté des rebondissements dans le tome 2, autant dans ce tome 3 l'action est très lente pour ne pas dire inexistante, même si à la fin les morts s'enfilent par dizaines y compris chez certains personnages principaux qui sont exécutés en une demi-ligne (!!!) mais cette avalanche d'hémoglobine n'insuffle pas pour autant plus de dynamisme! Contrairement aux jeux de l'arène (les Hunger Games) on ne sent aucune identification avec Katniss, on regarde ça de très loin sans se sentir impliqué...");
		$manager->persist($LivreHG3);
		
		$LivreNEC = new Livre();
		$LivreNEC   -> setTitre("Nos étoiles contraires")
                     -> addAuteur($AuteurGreen)
                     -> setEditeur($EditeurNathan)
                     -> setOeuvre($oeuvreNEC)
                     -> setAnnee(2012)
                     -> setResume("Hazel, 16 ans, est atteinte d'un cancer. Son dernier traitement semble avoir arrêté l'évolution de la maladie, mais elle se sait condamnée. Bien qu'elle s'y ennuie passablement, elle intègre un groupe de soutien, fréquenté par d'autres jeunes malades. C'est là qu'elle rencontre Augustus, un garçon en rémission, qui partage son humour et son goût de la littérature. Entre les deux adolescents, l'attirance est immédiate. Et malgré les réticences d'Hazel, qui a peur de s'impliquer dans une relation dont le temps est compté, leur histoire d'amour commence... Les entraînant vite dans un projet un peu fou, ambitieux, drôle et surtout plein de vie.");
		$manager->persist($LivreNEC);
		 
		$LivreFCM = new Livre();
		$LivreFCM   -> setTitre("La face cachée de Margo")
                    -> addAuteur($AuteurGreen)
                    -> setEditeur($EditeurGall)
                    -> setOeuvre($oeuvreFCM)
                    -> setAnnee(2008)
                    -> setResume("Margo Roth Speigelman, le nom aux six syllabes qui fait fantasmer Quentin depuis toujours. Alors forcément, quand elle s'introduit dans sa chambre, une nuit, par la fenêtre ouverte, pour l'entraîner dans une expédition vengeresse, il la suit. Mais au lendemain de leur folle nuit blanche, Margo n'apparaît pas au lycée, elle a disparu. Quentin saura-t-il décrypter les indices qu'elle lui a laissés pour la retrouver ? Plus il s'en rapproche, plus Margo semble lui échapper...");
		$manager->persist($LivreFCM);
		
		$LivreLOTR1 = new Livre();
		$LivreLOTR1 -> setTitre("La Fraternité de l'Anneau")
                     -> addAuteur($AuteurTolkien)
					 -> setEditeur($EditeurAU)
                     -> setOeuvre($oeuvreLOTR)
                     -> setAnnee(1954)
                     -> setResume("Un jeune Hobbit nommé Frodon Sacquet, hérite d'un anneau. Mais il se trouve que cet anneau est L'Anneau UNIQUE, un instrument de pouvoir absolu crée pour Sauron, le Seigneur des ténèbres, pour lui permettre de régner sur la Terre du Milieu et de réduire en esclavage ses peuples. Frodon a donc comme mission de détruire l'anneau en le jetant dans les laves de la Crevasse du Destin où l'Anneau à été forgé et ainsi le détruir pour toujours. Pour cela, Frodon sera aidé d'une Compagnie constituée d'Hobbits, d'Hommes, d'un Magicien, d'un Nain, et d'un Elfe, Un tel périple signifie s'aventurer très loin en Mordor, les terres du Seigneur des ténèbres, où est rassemblée son armée d'Orques maléfiques. La Compagnie doit non seulement combattre les forces extérieures du mal mais aussi les dissensions internes et l'influence corruptrice qu'exerce l'Anneau lui-même sur Frodon...");
		$manager->persist($LivreLOTR1);
         
		$LivreLOTR2 = new Livre();
		$LivreLOTR2 -> setTitre("Les Deux Tours")
                     -> addAuteur($AuteurTolkien)
                     -> setEditeur($EditeurAU)
                     -> setOeuvre($oeuvreLOTR)
                     -> setAnnee(1954)
                     -> setResume("Frodon le Hobbit et ses Compagnons se sont engagés, au Grand Conseil d'Elrond, à détruire l'Anneau de Puissance dont Sauron de Mordor cherche à s'emparer pour asservir tous les peuples de la terre habitée : Elfes et Nains, Hommes et Hobbits.");
		$manager->persist($LivreLOTR2);
		 
		$LivreLOTR3 = new Livre();
		$LivreLOTR3 -> setTitre("Les Retour du Roi")
                     -> addAuteur($AuteurTolkien)
                     -> setEditeur($EditeurAU)
                     -> setOeuvre($oeuvreLOTR)
                     -> setAnnee(1955)
                     -> setResume("Tandis que le continent se couvre de ténèbres, annonçant pour le peuple des Hobbits l'aube d'une ère nouvelle, Frodon poursuit son entreprise. Alors qu'il n'a pu franchir la Porte Noire, il se demande comment atteindre le Mont du Destin. Peut-être est-il trop tard : le Seigneur des Ténèbres mobilise ses troupes. Les Rohirrim n'ont plus le temps d'en finir avec le traître assiégé dans l'imprenable tour d'Orthanc ; ils doivent se rassembler pour faire face à l'ennemi. Tentant une fois de plus sa chance, Frodon passe par le Haut Col, où il sera livré à l'abominable Arachné. Survivra-t-il à son dangereux périple à travers le Pays Noir ?");
		$manager->persist($LivreLOTR3);
		
		$LivreCyrano = new Livre();
		$LivreCyrano   -> setTitre("Cyrano De Bergerac")
                     -> addAuteur($AuteurRostand)
                     -> setEditeur($EditeurLibrio)
                     -> setOeuvre($oeuvreCyrano)
                     -> setAnnee(1897)
                     -> setResume("Le nez de Cyrano s'est mis en travers de son coeur. La belle Roxane aime ailleurs, en l'espèce un cadet sans esprit mais de belle apparence, Christian de Neuvillette. La pièce de Rostand met en scène la tragique complicité entre deux moitiés d'homme, et s'achève sur une évidence en forme d'espérance : sous les traits de Christian, ce n'était pas moins que l'âme de Cyrano qu'aimait Roxane. Avec ce drame en cinq actes, au travers des reprises ou des adaptations cinématographiques, Rostand a connu et connaît un succès ininterrompu et planétaire. Pourquoi ? A cause des qualités d'écriture, des vertus dramatiques ou de la réussite du personnage principal de la pièce ? Sans doute, pour une part. Mais la raison profonde tient à son art de caresser l'un de nos plus anciens mythes : il n'est pas de justice ici-bas, ni d'amour heureux. Presque pas. Et tout est dans cette manière de nous camper sur cette frontière, entre rêve et réalité, entre lune et terre.");
		$manager->persist($LivreCyrano);
		
		$LivreHobbit = new Livre();
		$LivreHobbit -> setTitre("Le Hobbit")
                     -> addAuteur($AuteurTolkien)
					 -> setEditeur($EditeurAU)
                     -> setOeuvre($oeuvreHobbit)
                     -> setAnnee(1937)
                     -> setResume("Le hobbit Bilbo Bessac mène une existence paisible dans son trou de Cul-de-Sac jusqu’au jour où il croise le magicien Gandalf. Le lendemain, il a la surprise de voir venir prendre le thé chez lui non seulement Gandalf, mais également une compagnie de treize nains menée par Thorin Lécudechesne et composée de Balin, Dwalin, Fili, Kili, Dori, Nori, Ori, Oin, Gloin, Bifur, Bofur et Bombur. La compagnie est en route vers la Montagne Solitaire, où elle espère vaincre le dragon Smaug, qui a jadis dépossédé les nains de leur royaume et de leurs trésors. Cependant, pour mener à bien leurs projets, il leur faut un expert-cambrioleur, et Gandalf leur a recommandé Bilbo. Celui-ci est plus que réticent à l’idée de partir à l’aventure, mais il finit par accompagner la troupe.");
		$manager->persist($LivreHobbit);
		
		$LivreDPS = new Livre();
		$LivreDPS   -> setTitre("Le Cercle des Poètes Disparus")
                     -> addAuteur($AuteurKleinbaum)
                     -> setEditeur($EditeurPoche)
                     -> setOeuvre($oeuvreDPS)
                     -> setAnnee(1990)
                     -> setResume("Il fut leur inspiration. Il a transformé leur vie à jamais. A Welton, un austère collège du Vermont, dans les années 60, la vie studieuse des pensionnaires est bouleversée par l'arrivée d'un nouveau professeur de lettres, M. Keating. Ce pédagogue peu orthodoxe va leur communiquer sa passion de la poésie, de la liberté, de l'anticonformisme, secouant la poussière des autorités parentales, académiques et sociales. Même si le drame - le suicide d'un adolescent - déchire finalement cette expérience unique, même si Keating doit quitter le collège, il restera pour tous celui qui leur a fait découvrir le sens de la vie.");
		$manager->persist($LivreDPS);
		
		$LivreGdM = new Livre();
		$LivreGdM -> setTitre("La Guerre des Mondes")
						-> addAuteur($AuteurWells )
						-> setEditeur($EditeurHeinemann )
						-> setOeuvre($oeuvreGdM )
						-> setAnnee(1898)
						-> setResume("Un soir de juin 1900, un météore s'abat prés de Londres, bientôt suivi de nombreux autres. Des cratères calcinés qu'ils ont creusés dans le sol émergent alors d'énormes tripodes de métal, terrifiants engins de guerre venus de Mars pour envahir la Terre!
                            Face à leur rayon mortel, les armes terrestres s'avèrent dérisoires et les survivants ne peuvent que fuir à travers les ruines fumantes des villes et  les campagnes ravagées pour tenter d'échapper à une mort qui semble inéluctable.");
		$manager->persist($LivreGdM );
		
		$LivreDiv1 = new Livre();
		$LivreDiv1 -> setTitre("Divergente")
						-> addAuteur($AuteurRoth)
						-> setEditeur($EditeurNathan)
						-> setOeuvre($oeuvreDiv)
						-> setAnnee(2011)
						-> setResume("Tris vit dans un monde post apocalyptique où la société est divisée en cinq clans (Audacieux, Erudits, Altruistes, Sincères, Fraternels). A 16 ans, elle doit choisir son appartenance pour le reste de sa vie. Cas rarissime, son test d’aptitudes n’est pas concluant ; elle est Divergente. Les Divergents sont des individus rares n’appartenant à aucun clan et sont traqués par le gouvernement. Dissimulant son secret, elle intègre l’univers brutal des Audacieux dont l’entrainement est basé sur la maitrise de nos peurs les plus intimes.");
		$manager->persist($LivreDiv1);
		
		$LivreDiv2 = new Livre();
		$LivreDiv2 -> setTitre("Divergente 2")
						-> addAuteur($AuteurRoth)
						-> setEditeur($EditeurNathan)
						-> setOeuvre($oeuvreDiv)
						-> setAnnee(2012)
						-> setResume("Un choix peut vous transformer — ou encore vous détruire. Mais chaque choix comporte son lot de conséquences, et alors qu’elle est entourée d’une vague de mécontentement au sein des factions, Tris Prior doit encore essayer de sauver ceux qu’elle aime — ainsi qu’elle-même — tout en luttant contre des questions de douleur et de pardon, d’identité et de loyauté, de politique et d’amour. Le jour de l’initiation de Tris aurait dû être marqué par la célébration et la victoire auprès de sa faction; au contraire, cette journée se termina par des horreurs indescriptibles. La guerre menace d’éclater alors que le conflit croît entre les factions aux idéologies différentes. Et en temps de guerre, les camps se forment, les secrets émergent, et les choix se font du plus en plus irrévocables — et d’autant plus puissants. Transformée par ses propres décisions, mais aussi rongée par la douleur et le remords, des découvertes radicales et des relations changeantes, Tris devra embrasser pleinement sa Divergence, même si elle n’a pas conscience de ce qu’elle pourrait perdre en suivant cette voie.");
		$manager->persist($LivreDiv2);
		
		$LivreDiv3 = new Livre();
		$LivreDiv3 -> setTitre("Divergente 3")
						-> addAuteur($AuteurRoth)
						-> setEditeur($EditeurNathan)
						-> setOeuvre($oeuvreDiv)
						-> setAnnee(2013)
						-> setResume("Tris et ses alliés ont renversé leurs ennemis, mais le combat ne s'arrête pas là : la ville a été mise à sac par la guerre. La société en laquelle elle croyait autrefois est rongée par la violence et les luttes de pouvoir. Quand on lui offre une chance d'explorer le monde au-delà des limites qu'elle connaît, Tris est prëte. Peut-être qu'au-delà des frontières, Tobias et elle trouveront une nouvelle vie, sans mensonges ni trahisons. Mais le monde qu'il découvrent au-delà de la Clôture ne correspond en rien à ce qu'on leur a dit. Ils apprennent ainsi que leur ville, Chicago, fait partie d'une expérience censée sauver l'humanité contre sa propre dégénérescence. Mais l'Humanité peut-être être sauvée contre elle-même ?");
		$manager->persist($LivreDiv3);
		
		$LivreCOE = new Livre();
		$LivreCOE   -> setTitre("Le Crime de l'Orient-Express")
						-> addAuteur($AuteurChristie)
						-> setEditeur($EditeurCCC)
						-> setOeuvre($oeuvreCOE)
						-> setAnnee(1934)
						-> setResume("Hercule Poirot, venu résoudre une affaire, est en Syrie à la gare d’Alep, à 5 heures du matin. Il repart à Istanbul où il compte faire un peu de tourisme. Quand il arrive à l’hôtel, le concierge, lui donne un télégramme lui disant de retourner à Londres. Il prend alors un billet pour l’Orient-Express en direction de Londres et va manger au restaurant de l’hôtel. Il reconnait son ami M. Bouc qui va aussi en direction de Londres. Dans le train, M. Ratchett, un riche américain est tué au milieu de la nuit. Il examine le corps avec l’aide du docteur Constantine. Il a été tué de douze coups de couteau. M. Poirot découvre vite que le vrai nom de M. Ratchett est Cassetti, connu comme ayant dirigé la bande qui avait enlevé la petite Daisy Armstrong et exigé une rançon de deux cent mille dollars. Le cadavre de la petite fille fut retrouvé après le paiement de la rançon. Traumatisée, la mère de Daisy mourut en accouchant d’un deuxième enfant et son mari, désespéré, se tira une balle dans la tête. Poirot, en collaboration avec M. Bouc et le docteur Constantine, interroge les passagers du train et découvre un grand nombre d’informations complémentaires.");
		$manager->persist($LivreCOE);
        		 
		 /* ******************************************************* */
         /* Création des acteurs          */
        /* ******************************************************* */  

		$ActeurHemsworth = new Acteur();
		$ActeurHemsworth -> setNom("Hemsworth")
				-> setPrenom("Liam");
		$manager->persist($ActeurHemsworth);
		
		$ActeurHutcherson = new Acteur();
		$ActeurHutcherson -> setNom("Hutcherson")
				-> setPrenom("Josh");
		$manager->persist($ActeurHutcherson);
		
		$ActeurLawrence = new Acteur();
		$ActeurLawrence -> setNom("Lawrence")
				-> setPrenom("Jennifer");
		$manager->persist($ActeurLawrence);
		
		$ActeurHarrelson = new Acteur();
		$ActeurHarrelson -> setNom("Harrelson")
				-> setPrenom("Woody");
		$manager->persist($ActeurHarrelson);		
		
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
		$ActeurWilliams -> setNom("Williams")
                         -> setPrenom("Robin");
		$manager->persist($ActeurWilliams);
		
		$ActeurLeonard = new Acteur();
		$ActeurLeonard -> setNom("Leonard")
                         -> setPrenom("Robert Sean");
		$manager->persist($ActeurLeonard);
		
		$ActeurHawke = new Acteur();
		$ActeurHawke -> setNom("Hawke")
                         -> setPrenom("Ethan");
		$manager->persist($ActeurHawke);
		
		$ActeurCruise = new Acteur();
		$ActeurCruise -> setNom("Cruise")
				-> setPrenom("Tom");
		$manager->persist($ActeurCruise );

        $ActeurFanning = new Acteur();
		$ActeurFanning -> setNom("Fanning")
				-> setPrenom("Dakota");
		$manager->persist($ActeurFanning );

        $ActeurOtto = new Acteur();
		$ActeurOtto-> setNom("Otto")
				-> setPrenom("Miranda");
		$manager->persist($ActeurOtto);
		
		$ActeurJames = new Acteur();
		$ActeurJames-> setNom("James")
				-> setPrenom("Theo");
		$manager->persist($ActeurJames);
		
		$ActeurFinney = new Acteur();
	    $ActeurFinney -> setNom("Finney")
	               -> setPrenom("Albert");
	    $manager->persist($ActeurFinney);
	    
	    $ActeurBacall = new Acteur();
	    $ActeurBacall -> setNom("Bacall")
	                -> setPrenom("Laurent");
	    $manager->persist($ActeurBacall);
	    
	    $ActeurConnery = new Acteur();
	    $ActeurConnery -> setNom("Connery")
	                -> setPrenom("Sean");
	    $manager->persist($ActeurConnery);
		 
		 /* ******************************************************* */
         /* Création des réalisateurs          */
        /* ******************************************************* */  
         
		$RéalisateurRoss = new Realisateur();
		$RéalisateurRoss -> setNom("Ross")
						-> setPrenom("Gary");
		$manager->persist($RéalisateurRoss);
		
		$RéalisateurLawrence = new Realisateur();
		$RéalisateurLawrence -> setNom("Lawrence")
							-> setPrenom("Francis");
		$manager->persist($RéalisateurLawrence);
		 
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
		$RéalisateurWeir -> setNom("Weir")
                             -> setPrenom("Peter");
		$manager->persist($RéalisateurWeir);
		
		$RéalisateurSpielberg = new Realisateur();
		$RéalisateurSpielberg -> setNom("Spielberg")
						-> setPrenom("Steven");
		$manager->persist($RéalisateurSpielberg );
		
		$RéalisateurBurger = new Realisateur();
		$RéalisateurBurger -> setNom("Burger")
						-> setPrenom("Neil");
		$manager->persist($RéalisateurBurger);
		
		$RéalisateurSchwentke = new Realisateur();
		$RéalisateurSchwentke -> setNom("Schwentke")
						-> setPrenom("Robert");
		$manager->persist($RéalisateurSchwentke);
		
		$RéalisateurLumet = new Realisateur();
		$RéalisateurLumet -> setNom("Lumet")
		                -> setPrenom("Sydney");
		$manager->persist($RéalisateurLumet);
		 
		 /* ******************************************************* */
         /* Création des types          */
        /* ******************************************************* */  
         
		$TypeLongMetrage = new Type();
		$TypeLongMetrage -> setIntitule("Long Métrage");
		$manager->persist($TypeLongMetrage);
		 
		 /* ******************************************************* */
         /* Création des films          */
        /* ******************************************************* */  
         
		$FilmHG1 = new Film();
		$FilmHG1 -> setTitre("Hunger Games")
						-> setDuree(142)
						-> setType($TypeLongMetrage)
						-> setRealisateur($RéalisateurRoss)
						-> addActeur($ActeurHemsworth)
						-> addActeur($ActeurHutcherson)
						-> addActeur($ActeurLawrence)
						-> addActeur($ActeurHarrelson)
						-> setOeuvre($oeuvreHG)
						-> setAnnee(2012)
						-> setSynopsis("Chaque année, dans les ruines de ce qui était autrefois l'Amérique du Nord, le Capitole, l'impitoyable capitale de la nation de Panem, oblige chacun de ses douze districts à envoyer un garçon et une fille - les Tributs - concourir aux Hunger Games. A la fois sanction contre la population pour s'être rebellée et stratégie d'intimidation de la part du gouvernement, les Hunger Games sont un événement télévisé national au cours duquel les tributs doivent s'affronter jusqu'à la mort. L'unique survivant est déclaré vainqueur.La jeune Katniss, 16 ans, se porte volontaire pour prendre la place de sa jeune sœur dans la compétition. Elle se retrouve face à des adversaires surentraînés qui se sont préparés toute leur vie. Elle a pour seuls atouts son instinct et un mentor, Haymitch Abernathy, qui gagna les Hunger Games il y a des années mais n'est plus désormais qu'une épave alcoolique. Pour espérer pouvoir revenir un jour chez elle, Katniss va devoir, une fois dans l'arène, faire des choix impossibles entre la survie et son humanité, entre la vie et l'amour...");
		$manager->persist($FilmHG1);
		
		$FilmHG2 = new Film();
		$FilmHG2 -> setTitre("Hunger Games l'Embrasement")
						-> setDuree(146)
						-> setType($TypeLongMetrage)
						-> setRealisateur($RéalisateurLawrence)
						-> addActeur($ActeurHemsworth)
						-> addActeur($ActeurHutcherson)
						-> addActeur($ActeurLawrence)
						-> addActeur($ActeurHarrelson)
						-> setOeuvre($oeuvreHG)
						-> setAnnee(2013)
						-> setSynopsis("Katniss Everdeen est rentrée chez elle saine et sauve après avoir remporté la 74e édition des Hunger Games avec son partenaire Peeta Mellark.Puisqu’ils ont gagné, ils sont obligés de laisser une fois de plus leur famille et leurs amis pour partir faire la Tournée de la victoire dans tous les districts. Au fil de son voyage, Katniss sent que la révolte gronde, mais le Capitole exerce toujours un contrôle absolu sur les districts tandis que le Président Snow prépare la 75e édition des Hunger Games, les Jeux de l’Expiation – une compétition qui pourrait changer Panem à jamais…");
		$manager->persist($FilmHG2);
		
		$FilmHG3 = new Film();
		$FilmHG3 -> setTitre("Hunger Games la Revolte partie 1")
						-> setDuree(123)
						-> setType($TypeLongMetrage)
						-> setRealisateur($RéalisateurLawrence)
						-> addActeur($ActeurHemsworth)
						-> addActeur($ActeurHutcherson)
						-> addActeur($ActeurLawrence)
						-> addActeur($ActeurHarrelson)
						-> setOeuvre($oeuvreHG)
						-> setAnnee(2014)
						-> setSynopsis("Après l'explosion de l'arène des jeux, Katniss Everdeen et deux autres survivants des 75e Hunger Games (ou troisièmes Jeux de l'Expiation), Finnick Odair et Beetee Latier, ainsi que le Haut Juge des jeux Plutarch Heavensbee, tous impliqués dans la rébellion, ont pris la fuite vers le District 13. Elle y retrouve sa mère, sa sœur Prim et son ami Gale. Elle rencontre la Présidente Coin qui veut que Katniss incarne le Geai moqueur, symbole de la révolte, dans des spots de propagande afin d'unifier les Districts contre le Capitole. Réticente au début, elle finit par accepter devant l'horreur commise par le Capitole sur ordre du Président Snow contre les actes de rébellion, notamment au District 12, complètement rasé après la fin des 75e Hunger Games. Elle devra alors devenir le symbole de la rébellion, et pousser les Districts à la guerre ouverte contre le Capitole.");
		$manager->persist($FilmHG3);
		
		$FilmHG4 = new Film();
		$FilmHG4 -> setTitre("Hunger Games la Revolte partie 2")
						-> setDuree(137)
						-> setType($TypeLongMetrage)
						-> setRealisateur($RéalisateurLawrence)
						-> addActeur($ActeurHemsworth)
						-> addActeur($ActeurHutcherson)
						-> addActeur($ActeurLawrence)
						-> addActeur($ActeurHarrelson)
						-> setOeuvre($oeuvreHG)
						-> setAnnee(2015)
						-> setSynopsis("Avec toute la nation de Panem dans une guerre à grande échelle, Katniss affronte le président Snow dans une confrontation finale. Associée à un groupe de proches, Gale, Finnick et Peeta, Katniss part en mission avec une unité militaire du District 13. Ils risquent leur vie pour tenter d'assassiner le président Snow, qui est devenu de plus en plus obsédé par la destruction des districts en représailles des révoltes de ceux-ci. Les pièges de l’ennemi ainsi que les choix moraux et mortels qui attendent Katniss vont la contredire de plus en plus dans n’importe quel domaine. Comme elle a dû faire face dans les Hunger Games, elle va devoir se battre pour gagner la bataille finale.");
		$manager->persist($FilmHG4);
		 
		$FilmNEC = new Film();
		$FilmNEC -> setTitre("Nos étoiles contraires")
                  -> setDuree(133)
                  -> setType($TypeLongMetrage)
                  -> setRealisateur($RéalisateurBoone)
                  -> addActeur($ActeurWoodley)
                  -> addActeur($ActeurElgort)
                  -> addActeur($ActeurWolff)
                  -> setOeuvre($oeuvreNEC)
                  -> setAnnee(2014)
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
                 -> setAnnee(2015)
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
                   -> setAnnee(2001)
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
                   -> setAnnee(2002)
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
                   -> setAnnee(2003)
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
                  -> setAnnee(1950)
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
                  -> setAnnee(1960)
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
                  -> setAnnee(1990)
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
                   -> setAnnee(2012)
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
                   -> setAnnee(2013)
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
                   -> setAnnee(2014)
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
                  -> setAnnee(1989)
                  -> setSynopsis("Todd Anderson, un garçon plutôt timide, est envoyé dans la prestigieuse académie de Welton, réputée pour être l'une des plus fermées et austères des États-Unis, là où son frère avait connu de brillantes études.C'est dans cette université qu'il va faire la rencontre d'un professeur de lettres anglaises plutôt étrange, Mr Keating, qui les encourage à toujours refuser l'ordre établi. Les cours de Mr Keating vont bouleverser la vie de l'étudiant réservé et de ses amis...");
		$manager->persist($FilmDPS);
		
		$FilmGdM = new Film();
		$FilmGdM -> setTitre("La Guerre des Mondes")
						-> setDuree(118)
						-> setType($TypeLongMetrage)
						-> setRealisateur($RéalisateurSpielberg )
						-> addActeur($ActeurCruise )
						-> addActeur($ActeurFanning )
						-> addActeur($ActeurOtto)
						-> setOeuvre($oeuvreGdM)
						-> setAnnee(2005)
						-> setSynopsis("Ray Ferrier est un père divorcé vivant dans le New Jersey, en banlieue de New York. Un matin, son ex-épouse lui confie la garde de leurs deux enfants, Rachel et Robbie, le temps de quelques jours. Mais le soir même, un orage éclate et déclenche d'étranges phénomènes comme l'arrêt total des véhicules. Bientôt, d'énormes engins mécaniques surgissent de sous terre et désintègrent les êtres humains dans le chaos le plus total. Ray et ses enfants réussissent à survivre dans une des quelques voitures qui fonctionnent encore (les véhicules ne fonctionnent plus à cause d'éclairs électromagnétiques) après avoir été réparée. Il pense trouver refuge chez son ex-épouse, mais celle-ci est déjà partie pour Boston et la maison est inoccupée. Durant la nuit, un Boeing 747 s'écrase dans le quartier. Au milieu des débris, une équipe de journalistes leur apprend que des créatures extra-terrestres sont à l'origine des événements et que le monde est déjà en ruines. L'armée américaine, en dépit de sa puissance de feu, est écrasée à chaque affrontement avec les extraterrestres. Ray, Rachel et Robbie décident de se rendre à Boston, traversant une série d'épreuves qui va à la fois les réunir et les séparer…");
		$manager->persist($FilmGdM );
		
		$FilmDiv1 = new Film();
		$FilmDiv1 -> setTitre("Divergente")
						-> setDuree(140)
						-> setType($TypeLongMetrage)
						-> setRealisateur($RéalisateurBurger)
						-> addActeur($ActeurWoodley)
						-> addActeur($ActeurJames)
						-> addActeur($ActeurElgort)
						-> setOeuvre($oeuvreDiv)
						-> setAnnee(2014)
						-> setSynopsis("Tris vit dans un monde post apocalyptique où la société est divisée en cinq clans (Audacieux, Erudits, Altruistes, Sincères, Fraternels). A 16 ans, elle doit choisir son appartenance pour le reste de sa vie. Cas rarissime, son test d’aptitudes n’est pas concluant ; elle est Divergente. Les Divergents sont des individus rares n’appartenant à aucun clan et sont traqués par le gouvernement. Dissimulant son secret, elle intègre l’univers brutal des Audacieux dont l’entrainement est basé sur la maitrise de nos peurs les plus intimes.");
		$manager->persist($FilmDiv1);
		
		$FilmDiv2 = new Film();
		$FilmDiv2 -> setTitre("Divergente 2 : l'insurrection")
						-> setDuree(119)
						-> setType($TypeLongMetrage)
						-> setRealisateur($RéalisateurBurger)
						-> addActeur($ActeurWoodley)
						-> addActeur($ActeurJames)
						-> addActeur($ActeurElgort)
						-> setOeuvre($oeuvreDiv)
						-> setAnnee(2015)
						-> setSynopsis("Un choix peut vous transformer — ou encore vous détruire. Mais chaque choix comporte son lot de conséquences, et alors qu’elle est entourée d’une vague de mécontentement au sein des factions, Tris Prior doit encore essayer de sauver ceux qu’elle aime — ainsi qu’elle-même — tout en luttant contre des questions de douleur et de pardon, d’identité et de loyauté, de politique et d’amour. Le jour de l’initiation de Tris aurait dû être marqué par la célébration et la victoire auprès de sa faction; au contraire, cette journée se termina par des horreurs indescriptibles. La guerre menace d’éclater alors que le conflit croît entre les factions aux idéologies différentes. Et en temps de guerre, les camps se forment, les secrets émergent, et les choix se font du plus en plus irrévocables — et d’autant plus puissants. Transformée par ses propres décisions, mais aussi rongée par la douleur et le remords, des découvertes radicales et des relations changeantes, Tris devra embrasser pleinement sa Divergence, même si elle n’a pas conscience de ce qu’elle pourrait perdre en suivant cette voie.");
		$manager->persist($FilmDiv2);
		
		$FilmDiv3 = new Film();
		$FilmDiv3 -> setTitre("Divergente 3 : au-delà du mur partie 1")
						-> setDuree(121)
						-> setType($TypeLongMetrage)
						-> setRealisateur($RéalisateurSchwentke)
						-> addActeur($ActeurWoodley)
						-> addActeur($ActeurJames)
						-> addActeur($ActeurElgort)
						-> setOeuvre($oeuvreDiv)
						-> setAnnee(2016)
						-> setSynopsis("Tris et ses alliés ont renversé leurs ennemis, mais le combat ne s'arrête pas là : la ville a été mise à sac par la guerre. La société en laquelle elle croyait autrefois est rongée par la violence et les luttes de pouvoir. Quand on lui offre une chance d'explorer le monde au-delà des limites qu'elle connaît, Tris est prëte. Peut-être qu'au-delà des frontières, Tobias et elle trouveront une nouvelle vie, sans mensonges ni trahisons. Mais le monde qu'il découvrent au-delà de la Clôture ne correspond en rien à ce qu'on leur a dit. Ils apprennent ainsi que leur ville, Chicago, fait partie d'une expérience censée sauver l'humanité contre sa propre dégénérescence. Mais l'Humanité peut-être être sauvée contre elle-même ?");
		$manager->persist($FilmDiv3);
		
		$FilmCOE = new Film();
		$FilmCOE -> setTitre("Le Crime de l'Orient-Express")
						-> setDuree(128)
						-> setType($TypeLongMetrage)
						-> setRealisateur($RéalisateurLumet)
						-> addActeur($ActeurFinney)
						-> addActeur($ActeurBacall)
						-> addActeur($ActeurConnery)
						-> setOeuvre($oeuvreCOE)
						-> setAnnee(1974)
						-> setSynopsis("Hiver 1935, à Istambul. Le célèbre détective belge Hercule Poirot en visite en Turquie doit rentrer prématurément en France et ce retour imprévu lui pose un problème car rentrer de la Turquie en France nécessite au début du xxe siècle une réservation préalable quelques jours à l'avance pour une traversée de la Méditerranée par bateau, l'avion n'étant pas encore un moyen de transport international très courant. À la recherche d'une solution il se rend dans l'hôtel de luxe de la gare d'Istanbul où il espère que la chance pourra lui donner un petit coup de pouce. Et en effet, rencontrant dans le grand salon de l'hôtel son ami monsieur Bianchi qui est le directeur de la luxueuse ligne de l'Orient-Express, il obtient par son intermédiaire une place dans une voiture du prochain train en partance pour Calais. Lui-même, le directeur de la ligne, sera du voyage. Le train prend son départ et commence la traversée des premiers pays de l'est européen sur l'itinéraire. En chemin, lors de la traversée de la Yougoslavie, un homme d'affaires, un certain Samuel Ratchett, estimant sa vie en danger, demande l'aide de Poirot pour le protéger, ce que ce dernier refuse. Mais au matin suivant, Ratchett est retrouvé à l'aube dans sa couchette poignardé de douze coups de couteau à la poitrine. Durant la même nuit, une coulée de neige imprévue a immobilisé le train dans cette région très montagneuse. Le soleil s'est levé sur une campagne totalement déserte aux alentours, il n'est pas tombé de nouvelle neige depuis la veille au soir, et l'état immaculé du manteau de neige autour du train montre que personne ne s'est éloigné du convoi. Le coupable est donc probablement encore dans le train. Par ailleurs l'attente devra durer de très longues heures avant l'arrivée du train chasse-neige de service pour le déblaiement de la voie. Le directeur de la ligne, qui est du voyage, propose alors à son ami Hercule Poirot de tenter de résoudre ce meurtre tant que le train est immobilisé car lorsqu'il repartira après le déblayage de la coulée de neige il lui faudra s'en remettre aux autorités yougoslaves et il serait préférable pour tout le monde que le coupable soit déjà démasqué afin d'éviter une rétention des voyageurs innocents par les Yougoslaves. Commence alors une des plus passionnantes enquêtes de l'histoire du roman policier...");
		$manager->persist($FilmCOE);
		 
		 /* ******************************************************* */
         /* Création des images                  */
        /* ******************************************************* */  
		$ImageHG = new Image();
		$ImageHG -> setUrl("http://cdn02.cdn.justjared.com/wp-content/uploads/headlines/2015/03/hunger-games-mockingjay-available-dvd.jpg")
				-> setOeuvre($oeuvreHG);
		$manager->persist($ImageHG);
		
		$ImageNEC = new Image();
		$ImageNEC  -> setUrl("http://www.photogeniques.fr/wp-content/uploads/2014/09/The-Fault-in-Our-Stars_tfios_Nos-etoiles-contraires_okay-okay.jpg")
                    -> setOeuvre($oeuvreNEC);
		$manager->persist($ImageNEC);
		
		$ImageFCM = new Image();
		$ImageFCM  -> setUrl("https://parfoissarah.files.wordpress.com/2015/08/ii.png?w=300&h=300")
                    -> setOeuvre($oeuvreFCM);
		$manager->persist($ImageFCM);
		
		$ImageLOTR = new Image();
		$ImageLOTR  -> setUrl("https://www.nivsbling.com/wp-content/uploads/imported/8MM-Gold-Silver-Black-Lord-of-The-Rings-HOBBIT-Tungsten-Carbide-Band-Mens-Ring-201355151163-2.jpg")
                    ->setOeuvre($oeuvreLOTR);
		$manager->persist($ImageLOTR);
		
		$ImageCyrano = new Image();
		$ImageCyrano -> setUrl("http://thewrittenreel.files.wordpress.com/2011/10/418984_cyrano-de-bergerac.jpg")
                      -> setOeuvre($oeuvreCyrano);
		$manager->persist($ImageCyrano);
		
		$ImageHobbit = new Image();
		$ImageHobbit -> setUrl("http://www.lescinemasaixois.com/films/medias/photo18_8616.jpg")
                      -> setOeuvre($oeuvreHobbit);
		$manager->persist($ImageHobbit);
		
		$ImageDPS = new Image();
		$ImageDPS -> setUrl("http://www.glamourparis.com/uploads/images/thumbs/201130/robin_153092376_north_607x.jpg")
                      -> setOeuvre($oeuvreDPS);
		$manager->persist($ImageDPS);
		
		$ImageGdM = new Image();
		$ImageGdM -> setUrl("http://fr.web.img6.acsta.net/medias/nmedia/18/35/50/73/18430317.jpg")
				-> setOeuvre($oeuvreGdM);
		$manager->persist($ImageGdM );
		
		$ImageDiv = new Image();
		$ImageDiv -> setUrl("http://www.junkiexl.com/wp-content/uploads/2015/04/tom-holkenborg-junkie-xl-divergent-soundtrack.jpg")
				-> setOeuvre($oeuvreDiv);
		$manager->persist($ImageDiv);
		
		$ImageCOE = new Image();
		$ImageCOE -> setURL("http://fr.web.img4.acsta.net/pictures/14/08/14/15/42/182502.jpg")
		          -> setOeuvre($oeuvreCOE);
		$manager->persist($ImageCOE);
		
		/* ******************************************************* */
         /* Création des images                  */
        /* ******************************************************* */  
        
        $noteHG = new Note();
        $noteHG -> setValeur(3)
                -> setOeuvre($oeuvreHG);
        $manager->persist($noteHG);
        
        $noteNEC = new Note();
        $noteNEC -> setValeur(2)
                -> setOeuvre($oeuvreNEC);
        $manager->persist($noteNEC);
        
        $noteFCM = new Note();
        $noteFCM -> setValeur(4)
                -> setOeuvre($oeuvreFCM);
        $manager->persist($noteFCM);
        
        $noteLOTR = new Note();
        $noteLOTR -> setValeur(4)
                -> setOeuvre($oeuvreLOTR);
        $manager->persist($noteLOTR);
        
        $noteCyrano = new Note();
        $noteCyrano->setValeur(3)
                ->setOeuvre($oeuvreCyrano);
        $manager->persist($noteCyrano);
        
        $noteHobbit = new Note();
        $noteHobbit -> setValeur(5)
                    -> setOeuvre($oeuvreHobbit);
        $manager->persist($noteHobbit);
        
        $noteDPS = new Note();
        $noteDPS->setValeur(2)
                ->setOeuvre($oeuvreDPS);
        $manager->persist($noteDPS);
        
        $noteGdM = new Note();
        $noteGdM->setValeur(5)
                ->setOeuvre($oeuvreGdM);
        $manager->persist($noteGdM);
        
        $noteDiv = new Note();
        $noteDiv -> setValeur(3)
                -> setOeuvre($oeuvreDiv);
        $manager->persist($noteDiv);
        
        $noteCOE = new Note();
        $noteCOE->setValeur(1)
                ->setOeuvre($oeuvreCOE);
        $manager->persist($noteCOE);
		
		/* ******************************************************* */
        /*                    Enregistrement en BD                 */
        /* ******************************************************* */

        // On déclenche l'enregistrement de toutes les données en BD
		$manager->flush();
    }
}




?>