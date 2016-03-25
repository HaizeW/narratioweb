<?php

namespace NarratioWeb\OeuvresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OC\PlatformBundle\Entity\Advert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use NarratioWeb\OeuvresBundle\Entity\Oeuvre;
use NarratioWeb\OeuvresBundle\Entity\Image;
use NarratioWeb\OeuvresBundle\Entity\Livre;
use NarratioWeb\OeuvresBundle\Entity\Film;
use NarratioWeb\OeuvresBundle\Entity\Note;
use NarratioWeb\OeuvresBundle\Entity\Auteur;
use NarratioWeb\OeuvresBundle\Entity\Acteur;

use NarratioWeb\OeuvresBundle\Form\AuteurType;
use NarratioWeb\OeuvresBundle\Form\ActeurType;
use NarratioWeb\OeuvresBundle\Form\RealisateurType;
use NarratioWeb\OeuvresBundle\Form\EditeurType;
use NarratioWeb\OeuvresBundle\Form\OeuvreType;
use NarratioWeb\OeuvresBundle\Form\ImageType;
use NarratioWeb\OeuvresBundle\Form\LivreType;
use NarratioWeb\OeuvresBundle\Form\FilmType;

class OeuvreController extends Controller
{
        
public function indexAction(Request $requeteUtilisateurChoix, Request $requeteUtilisateurNom)
    {
        
        // Tableau dans lequel les données du formulaire seront recueillies       
        $tabChoix = array();
        $rechercheNominale = array();
        
        // -- FORMULAIRE DE RECHERCHE
        $formulaireChoix = $this->createFormBuilder($tabChoix)
            ->add('TrancheAge','entity', array('label'=>'Tranche d Age',
                                                'class'=>'NarratioWebOeuvresBundle:TrancheAge',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('Genre','entity', array('label'=>'Genre',
                                                'class'=>'NarratioWebOeuvresBundle:Genre',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('Epoque','entity', array('label'=>'Epoque',
                                                'class'=>'NarratioWebOeuvresBundle:Epoque',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            -> getForm();
        
        // -- FORMULAIRE DE RECHERCHE NOMINALE
        $formulaireRechercheNominale = $this->createFormBuilder($rechercheNominale)
            ->add('nom', 'genemu_jqueryautocomplete_entity', array('route_name' => 'ajax_oeuvre',
                                                                    'class' => 'NarratioWeb\OeuvresBundle\Entity\Oeuvre',))
        	->getForm();
        
        // enregistrement des données dans $tabChoix apres soumission
        $formulaireChoix->handleRequest($requeteUtilisateurChoix);
        $formulaireRechercheNominale->handleRequest($requeteUtilisateurNom);

        // si le form de recherche NOMINAL a été soumis
        if($this->getRequest()->get('action-type') =='Rechercher')//($this->getRequest()->get('action-type') =='Films')
        {
            // je recup les donnees dans un tab
        	$tabNomRes = $formulaireRechercheNominale -> getData();
        	
        	// je recup mes variables
            $nomOeuvre = $tabNomRes['nom'];
            
            // je charge mon repository de Oeuvre pour executer une requete sur la BD
            $repositoryOeuvre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
        	$oeuvre=$repositoryOeuvre->findOneByNom($nomOeuvre);
        
        	if($oeuvre == null)
        	{
        	    return $this->render('NarratioWebOeuvresBundle:Default:erreur.html.twig');
        	}
        	else
        	{
        	    $idOeuvre = $oeuvre->getId();
        	
                    	// je charge mon repository de Livre pour executer une requete sur la BD
                        $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
                        // j'execute la requete perso pour remplir un tableau de livre en accord avec le formulaire de page d'acceuil
                        $tabLivres = $repositoryLivres->getLivresByOeuvre($idOeuvre);
                        
                        // je charge mon repository de Film pour executer une requete sur la BD
                        $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
                        // j'execute la requete perso pour remplir un tableau de film en accord avec le formulaire de page d'acceuil
                        $tabFilms = $repositoryFilms->getFilmsByOeuvre($idOeuvre);
                        
                        // je charge mon repository de Image pour executer une requete sur la BD
                        $repositoryImage = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Image');
                        // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
                        $tabImage = $repositoryImage->getImageByOeuvre($idOeuvre);
                        
                        // je definis l'image de l'oeuvre
                        $image = $tabImage[0];
            
                        // je recup des images de sugg
                        $tabImagesSuggestions = $repositoryImage->getImageSugg();
                        
                        
                                // WEB SERVICE IMDB pour plus d'infos
                                if ($json=file_get_contents("http://www.omdbapi.com/?t=titanic&y=1997") != null)
                                {

                                        $titre = $oeuvre->getNom();
                                        
                                        //$annee = $oeuvre ->getAnnee();
                                        
                                        // je recupere le json
                                        $json=file_get_contents("http://www.omdbapi.com/?t=titanic&y=1997");
                                        
                                        // je decode le json
                                        $resImdb=json_decode($json);
                                        
                                        
                                        
                                        //var_dump($resImdb);
                                        
                                }
                                else
                                {
                                    
                                    $resImdb = null;
                                    
                                }
                                
                                
                // je charge mon repository de Note pour executer une requete sur la BD
                $repositoryNotes = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Note');
                // j'execute la requete perso pour remplir un tableau de notes en accord avec le formulaire de page d'acceuil
                $tabNotes = $repositoryNotes->getNotesByOeuvre($idOeuvre);
                    
                    if($tabNotes != null)
                    {
                        $note=0;
                        $q=0;
                        for($q=0; $q<count($tabNotes); $q++)
                        {
                            // je calcule la note
                            $note = $note + $tabNotes[$q]->getValeur();
                            $note = $note / count($tabNotes);
                            // je l'arrondis pour afficher n étoiles
                            $note = round($note);
                        }
                        
                    }
                    else
                    {
                        $note = null;
                    }
                        
        	
                    //On augmente le compteur de vues de l'oeuvre !
                    $compteur = $oeuvre->getCompteurVues();
                    $oeuvre->setCompteurVues($compteur+1);
                    $gestionnaireEntite = $this->getDoctrine()->getManager();
                    $gestionnaireEntite->persist($oeuvre);
                    $gestionnaireEntite->flush();
        	
        	// je retourne la vue avec les oeuvres a mettre en forme
            return $this->render('NarratioWebOeuvresBundle:Default:oeuvre.html.twig', array(  'tabLivres'=>$tabLivres,
                                                                                'tabFilms'=>$tabFilms,
                                                                                'image'=>$image,
                                                                                'oeuvre'=>$oeuvre,
                                                                                'tabImagesSuggestions'=>$tabImagesSuggestions,
                                                                                'id'=>$idOeuvre,
                                                                                'resImdb'=>$resImdb,
                                                                                'note'=>$note
                                                                                ));
        	}
    	}
        
        // si le form a été soumis
        if ($this->getRequest()->get('action-type') =='Random')//($formulaireChoix->isSubmitted())
        {
            // on recupere les données du form dans un tableau de 3 cases indicés par 'TrancheAge' 'Genre' et 'Epoque'
            $tabChoixRes = $formulaireChoix -> getData();
            
            // je recup mes variables
            $choixEpoque = $tabChoixRes['Epoque'] -> getId();
            $choixGenre = $tabChoixRes['Genre'] -> getId();
            $choixTrancheAge = $tabChoixRes['TrancheAge'] -> getId();
            
                    // je charge mon repository de Oeuvre pour executer une requete sur la BD
                    $repositoryOeuvre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
                    // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'accueil
                    $tabOeuvreChoix = $repositoryOeuvre->getOeuvreChoix($choixEpoque, $choixGenre, $choixTrancheAge);
                
                    //var_dump($tabOeuvreChoix);
                    
                            if(count($tabOeuvreChoix) == 0)
                            {
                                return $this->render('NarratioWebOeuvresBundle:Default:erreur.html.twig');
                            }
                            else
                            {
                                $nbOeuvres = count($tabOeuvreChoix);
                                // choix aléatoire des oeuvres SI il y en a plus de 6
                                if ($nbOeuvres < 6)
                                    {
                                        // je prepare mes parametres pour les prochaines requetes
                                        $nbChoixMax = count($tabOeuvreChoix);
                                        $alea = array();
                                        //FCT DE CHOIX DES CHIFFRES ALEATOIRES
                                        while (count($alea) < $nbChoixMax)
                                        {
                                            $r = mt_rand(0,$nbOeuvres-1);
                                            if ( !in_array($r,$alea) ) 
                                            {
                                                $alea[] = $r;
                                            }
                                        }
                                        //var_dump($alea);
                                        //var_dump($nbOeuvres);
                                        //var_dump($tabOeuvreChoix);
                                        
                                        $tabOeuvreHasard = array();
                                        $i=0;
                                        if(count($tabOeuvreChoix) > 2)
                                        {
                                                while ($i<$nbChoixMax)
                                                {
                                                        $tabOeuvreHasard[$i] = $tabOeuvreChoix[$alea[$i]];
                                                        $i++;
                                                }
                                                $oeuvre = $tabOeuvreHasard[0];
                                                $idOeuvre = $oeuvre->getId();
                                        }
                                        else
                                        {
                                                $oeuvre = $tabOeuvreChoix[0];
                                                $idOeuvre = $oeuvre->getId();        
                                        }
                                                // je charge mon repository de Livre pour executer une requete sur la BD
                                                $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
                                                // j'execute la requete perso pour remplir un tableau de livre en accord avec le formulaire de page d'acceuil
                                                $tabLivres = $repositoryLivres->getLivresByOeuvre($idOeuvre);
                                        
                                                // je charge mon repository de Film pour executer une requete sur la BD
                                                $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
                                                // j'execute la requete perso pour remplir un tableau de film en accord avec le formulaire de page d'acceuil
                                                $tabFilms = $repositoryFilms->getFilmsByOeuvre($idOeuvre);
                                                
                                                // je charge mon repository de Image pour executer une requete sur la BD
                                                $repositoryImage = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Image');
                                                // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
                                                $tabImage = $repositoryImage->getImageByOeuvre($idOeuvre);

                                                // je definis l'image de l'oeuvre
                                                $image = $tabImage[0];
                                                
                                                // IMAGE DE SUGGESTION A FAIRE
                                                $tabImagesId = array();
                                                $s=0;
                                                        while ($s<count($tabOeuvreChoix))
                                                        {
                                                                $tabImagesId[$s] = $tabOeuvreChoix[$s]->getId();
                                                                $s++;
                                                        }
                                                $tabImagesSuggestionsBrut = array();
                                                $j=0;
                                                        // je récupere les images grace a une requete et l'id des oeuvres
                                                        while ($j<count($tabImagesId))
                                                        {
                                                                $tabImagesSuggestionsBrut[$j] = $repositoryImage->getImageByOeuvre($tabImagesId[$j]);
                                                                $j++;
                                                        }
                                                      
                                                // je met en forme le tableau pour qu'il soit utilisable facilement
                                                $tabImagesSuggestions = array();
                                                $l=0;
                                                        while ($l<count($tabImagesSuggestionsBrut))
                                                        {
                                                                $tabImagesSuggestions[$l] = $tabImagesSuggestionsBrut[$l][0];
                                                                $l++;
                                                        }
                                        
                                // je prepare mes parametres pour le web service de IMDB
                                $titre = $tabFilms[0]->getOeuvre()->getNom();     
                                $annee = $tabFilms[0]->getAnnee();
                                // j'ajoute le %20 a la place des espaces
                                $titreUrl=rawurlencode($titre);
                                 
                                // je recupere le web service pour voir si ca echoue ou pas
                                $resImdbBrut=file_get_contents("http://www.omdbapi.com/?t=$titreUrl&y=$annee&plot=short&r=json");
                                // je le decode pour avoir l objet et non la string
                                $resImdb=json_decode($resImdbBrut);
                                $resImdbBool=$resImdb->{'Response'};
                                
                                if ($resImdbBool != "False")
                                {
                                            
                                    // je recupere le json
                                    $json=file_get_contents("http://www.omdbapi.com/?t=$titreUrl&y=$annee&plot=short&r=json");
                                    
                                    // je decode le json
                                    $resImdb=json_decode($json);
                                        
                                }
                                else
                                {
                                    
                                    $resImdb = null;
                                    
                                }
                                
                                
                // je charge mon repository de Note pour executer une requete sur la BD
                $repositoryNotes = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Note');
                // j'execute la requete perso pour remplir un tableau de notes en accord avec le formulaire de page d'acceuil
                $tabNotes = $repositoryNotes->getNotesByOeuvre($idOeuvre);
                    
                    //var_dump($tabNotes);
                    
                    if($tabNotes != null)
                    {
                        $note=0;
                        $q=0;
                        for($q=0; $q<count($tabNotes); $q++)
                        {
                            // je calcule la note
                            $note = $note + $tabNotes[$q]->getValeur();
                            $note = $note / count($tabNotes);
                            // je l'arrondis pour afficher n étoiles
                            $note = round($note);
                        }
                        
                    }
                    else
                    {
                        $note = null;
                    }    
                                        
                                        
                                        //On augmente le compteur de vues de l'oeuvre !
                                        $compteur = $oeuvre->getCompteurVues();
                                        $oeuvre->setCompteurVues($compteur+1);
                                        $gestionnaireEntite = $this->getDoctrine()->getManager();
                                        $gestionnaireEntite->persist($oeuvre);
                                        $gestionnaireEntite->flush();

                                        return $this->render('NarratioWebOeuvresBundle:Default:oeuvre.html.twig', array(  'tabLivres'=>$tabLivres,
                                                                                'tabFilms'=>$tabFilms,
                                                                                'image'=>$image,
                                                                                'oeuvre'=>$oeuvre,
                                                                                'tabImagesSuggestions'=>$tabImagesSuggestions,
                                                                                'id'=>$idOeuvre,
                                                                                'resImdb'=>$resImdb,
                                                                                'note'=>$note
                                                                                ));
                                    }
                                else 
                                    {
                                        // je prepare mes parametres pour les prochaines requetes
                                        $nbChoixMax = 6;
                                        $alea = array();
                                        //FCT DE CHOIX DES CHIFFRES ALEATOIRES
                                        while (count($alea) < $nbChoixMax)
                                        {
                                            $r = mt_rand(0,$nbOeuvres-1);
                                            if ( !in_array($r,$alea) ) 
                                            {
                                                $alea[] = $r;
                                            }
                                        }
                                        //var_dump($alea);
                                        
                                        $tabOeuvreHasard = array();
                                        $i=0;
                                        while ($i<count($tabOeuvreChoix))
                                        {
                                                $tabOeuvreHasard[$i] = $tabOeuvreChoix[$alea[$i]];
                                                $i++;
                                        }
                                        $oeuvre = $tabOeuvreHasard[0];
                                        $idOeuvre = $oeuvre->getId();

                                                // je charge mon repository de Livre pour executer une requete sur la BD
                                                $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
                                                // j'execute la requete perso pour remplir un tableau de livre en accord avec le formulaire de page d'acceuil
                                                $tabLivres = $repositoryLivres->getLivresByOeuvre($idOeuvre);
                                        
                                                // je charge mon repository de Film pour executer une requete sur la BD
                                                $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
                                                // j'execute la requete perso pour remplir un tableau de film en accord avec le formulaire de page d'acceuil
                                                $tabFilms = $repositoryFilms->getFilmsByOeuvre($idOeuvre);
                                                
                                                // je charge mon repository de Image pour executer une requete sur la BD
                                                $repositoryImage = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Image');
                                                // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
                                                $tabImage = $repositoryImage->getImageByOeuvre($idOeuvre);
                                                
                                                // je definis l image principale
                                                $image = $tabImage[0];
                                                
                                                // IMAGE DE SUGGESTION A FAIRE
                                                $tabImagesId = array();
                                                $i=0;
                                                while ($i<count($tabOeuvreChoix))
                                                {
                                                        $tabImagesId[$i] = $tabOeuvreChoix[$i+1]->getId();
                                                        $i++;
                                                }
                                                $tabImagesSuggestions = array();
                                                $j=0;
                                                while ($j<count($tabImagesId))
                                                {
                                                        $tabImagesSuggestions[$j] = $repositoryImage->getImageByOeuvre($tabImagesId[$j]);
                                                        $j++;
                                                }
                                                
                                        
                                // je prepare mes parametres pour le web service de IMDB
                                $titre = $tabFilms[0]->getOeuvre()->getNom();     
                                $annee = $tabFilms[0]->getAnnee();
                                // j'ajoute le %20 a la place des espaces
                                $titreUrl=rawurlencode($titre);
                                 
                                // je recupere le web service pour voir si ca echoue ou pas
                                $resImdbBrut=file_get_contents("http://www.omdbapi.com/?t=$titreUrl&y=$annee&plot=short&r=json");
                                // je le decode pour avoir l objet et non la string
                                $resImdb=json_decode($resImdbBrut);
                                $resImdbBool=$resImdb->{'Response'};
                                
                                if ($resImdbBool != "False")
                                {
                                            
                                    // je recupere le json
                                    $json=file_get_contents("http://www.omdbapi.com/?t=$titreUrl&y=$annee&plot=short&r=json");
                                    
                                    // je decode le json
                                    $resImdb=json_decode($json);
                                        
                                }
                                else
                                {
                                    
                                    $resImdb = null;
                                    
                                }
                                
                                
                // je charge mon repository de Note pour executer une requete sur la BD
                $repositoryNotes = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Note');
                // j'execute la requete perso pour remplir un tableau de notes en accord avec le formulaire de page d'acceuil
                $tabNotes = $repositoryNotes->getNotesByOeuvre($idOeuvre);
                    
                    //var_dump($tabNotes);
                    
                    if($tabNotes != null)
                    {
                        $note=0;
                        $q=0;
                        for($q=0; $q<count($tabNotes); $q++)
                        {
                            // je calcule la note
                            $note = $note + $tabNotes[$q]->getValeur();
                            $note = $note / count($tabNotes);
                            // je l'arrondis pour afficher n étoiles
                            $note = round($note);
                        }
                        
                    }
                    else
                    {
                        $note = null;
                    }                
                                        
                                        //On augmente le compteur de vues de l'oeuvre !
                                        $compteur = $oeuvre->getCompteurVues();
                                        $oeuvre->setCompteurVues($compteur+1);
                                        $gestionnaireEntite = $this->getDoctrine()->getManager();
                                        $gestionnaireEntite->persist($oeuvre);
                                        $gestionnaireEntite->flush();

                                        return $this->render('NarratioWebOeuvresBundle:Default:oeuvre.html.twig', array(  'tabLivres'=>$tabLivres,
                                                                                'tabFilms'=>$tabFilms,
                                                                                'image'=>$image,
                                                                                'oeuvre'=>$oeuvre,
                                                                                'tabImagesSuggestions'=>$tabImagesSuggestions,
                                                                                'id'=>$idOeuvre,
                                                                                'resImdb'=>$resImdb,
                                                                                'note'=>$note
                                                                                ));
                                    }
                                   
                            }
   

    }
        
    // -- MENU DEROULANT
    
        //Création du repository
        $repositoryOeuvre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
                //Récupération des oeuvres les plus récentes
                $tabNewOeuvres = $repositoryOeuvre->getOeuvreRecentes();
                //Récupération des oeuvres les plus vues
                $tabOeuvreVues = $repositoryOeuvre->getOeuvrePlusVues();

        // ici, on affiche la page dont le formulaire permettant le choix d'une oeuvre via Random
        return $this->render('NarratioWebOeuvresBundle:Default:index.html.twig', array('form'=>$formulaireChoix->createView(),
                                                                                        'formulaireRechercheNominale'=>$formulaireRechercheNominale->createView(),
                                                                                        'tabOeuvreNew'=>$tabNewOeuvres, 'tabOeuvreVues'=>$tabOeuvreVues));

    }
        
    
    
public function rechercheAvanceeAction(Request $requeteUtilisateurL, Request $requeteUtilisateurF)
    {
        
        // Tableau dans lequel les données du formulaire seront recueillies
        $tabRechercheAvanceeFilms = array();
        $tabRechercheAvanceeLivres = array();
        
        // Créateur formulaire FILMS
        $formulaireRechAvanceeFilms = $this->createFormBuilder($tabRechercheAvanceeFilms)
            ->add('TrancheAgeF','entity', array('label'=>'Tranche d Age',
                                                'class'=>'NarratioWebOeuvresBundle:TrancheAge',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('GenreF','entity', array('label'=>'Genre',
                                                'class'=>'NarratioWebOeuvresBundle:Genre',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('EpoqueF','entity', array('label'=>'Epoque',
                                                'class'=>'NarratioWebOeuvresBundle:Epoque',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('Acteur','entity', array('label'=>'Acteur',
                                                'class'=>'NarratioWebOeuvresBundle:Acteur',
                                                'property'=>'label', // affiche prenom + nom (méthode getLabel dans Acteur)
                                                'multiple' => true,
                                                'expanded' => false))
            ->add('Realisateur','entity', array('label'=>'Realisateur',
                                                'class'=>'NarratioWebOeuvresBundle:Realisateur',
                                                'property'=>'label', // affiche prenom + nom
                                                'multiple' => true,
                                                'expanded' => false))                                                                     
            ->add('ThematiqueF','entity', array('label'=>'Thematique',
                                                'class'=>'NarratioWebOeuvresBundle:Thematique',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))                                                
            ->add('Type','entity', array('label'=>'Type',
                                                'class'=>'NarratioWebOeuvresBundle:Type',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))                                                 
            ->getForm();
        
        
        // Créateur formulaire LIVRES
        $formulaireRechAvanceeLivres = $this->createFormBuilder($tabRechercheAvanceeLivres)
            ->add('TrancheAgeL','entity', array('label'=>'Tranche d Age',
                                                'class'=>'NarratioWebOeuvresBundle:TrancheAge',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('GenreL','entity', array('label'=>'Genre',
                                                'class'=>'NarratioWebOeuvresBundle:Genre',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('EpoqueL','entity', array('label'=>'Epoque',
                                                'class'=>'NarratioWebOeuvresBundle:Epoque',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('ThematiqueL','entity', array('label'=>'Thematique',
                                                'class'=>'NarratioWebOeuvresBundle:Thematique',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))       
            ->add('Auteur','entity', array('label'=>'Auteur',
                                                'class'=>'NarratioWebOeuvresBundle:Auteur',
                                                'property'=>'label',
                                                'multiple' => true,
                                                'expanded' => false))
            ->add('Editeur','entity', array('label'=>'Editeur',
                                                'class'=>'NarratioWebOeuvresBundle:Editeur',
                                                'property'=>'nom',
                                                'multiple' => true,
                                                'expanded' => false)) 
            ->getForm();
        
        
        // enregistrement des données dans $tabChoixResFilms apres soumission
        $formulaireRechAvanceeFilms->handleRequest($requeteUtilisateurF);
        $formulaireRechAvanceeLivres->handleRequest($requeteUtilisateurL);
        
        
        // si le form FILMS a été soumis
        if (($this->getRequest()->get('action-type-films') =='Rechercher')) // or ($this->getRequest()->get('action-type-films') =='Suivant')
        {
        
                // on recupere les données du form dans un tableau
                $tabChoixResFilms = $formulaireRechAvanceeFilms -> getData();
            
                //var_dump($tabChoixResFilms);
            
                // je recup mes variables
                $choixEpoqueF = $tabChoixResFilms['EpoqueF'] -> getId();
                $choixGenreF = $tabChoixResFilms['GenreF'] -> getId();
                $choixTrancheAgeF = $tabChoixResFilms['TrancheAgeF'] -> getId();
                $choixActeur = $tabChoixResFilms['Acteur'][0] -> getId();
                $choixRealisateur = $tabChoixResFilms['Realisateur'][0] -> getId();
                $choixThematiqueF = $tabChoixResFilms['ThematiqueF'] -> getId();
                $choixType = $tabChoixResFilms['Type'] -> getId();
                        
                        // je charge mon repository de Film pour executer une requete sur la BD
                        $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
                        // j'execute la requete perso pour remplir un tableau de film en accord avec le formulaire de page d'acceuil
                        $tabFilms = $repositoryFilms->getFilmsAvancee($choixActeur, $choixRealisateur, $choixType, $choixThematiqueF, $choixGenreF, $choixEpoqueF, $choixTrancheAgeF);
                        
        //var_dump($tabFilms);
                    $g=0;
                    $tabFilmsIdBrut="";
                    for ($g=0; $g < count($tabFilms); $g++)
                    {
                        $tabFilmsIdBrut = $tabFilms[$g]->getId() . ";" . $tabFilmsIdBrut;
                    }
                    $filmsId=$tabFilmsIdBrut;
    //var_dump($filmsId);
                                if(count($tabFilms) == 0)
                                {
                                        return $this->render('NarratioWebOeuvresBundle:Default:erreur.html.twig');
                                }
                                else
                                {
                                        
                                                // je charge mon repository de Image pour executer une requete sur la BD
                                                $repositoryImages = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Image');
                                                // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
                                
                                        // je prepare mon tableau d'images des oeuvres 
                                        $tabImages = array();
                                        $k=0;
                                                for($k=0;$k<count($tabFilms);$k++)
                                                {
                                                
                                                    $tabImages[$k] = $repositoryImages->getImageByFilm($tabFilms[$k]->getImageFilm());
                                                    
                                                }
                                
                                }
                             
                $q = 0;
                $c =0;
                $tabRes = array();
                for($q=0; $q < count($tabFilms); $q++)
                {
                    
                    $tabRes[$q][$c] = $tabFilms[$q];
                    $c++;
                    $tabRes[$q][$c] = $tabImages[$q][0];
                    $c=0;
                }

//var_dump($tabRes);    
//var_dump($tabFilmsIdBrut);
            $page = 0;
            
                return $this->render('NarratioWebOeuvresBundle:Default:oeuvreAvanceeFilms.html.twig', 
                                array(
                                        'tabRes'=>$tabRes,
                                        'page'=>$page,
                                        'tabFilmsIdBrut'=>$tabFilmsIdBrut,
                                        'filmsId'=>$filmsId
                                ));
        }
        
        // si le form LIVRES a été soumis
        if ($this->getRequest()->get('action-type-livres') =='Rechercher') //($formulaireRechAvanceeLivres->isSubmitted())
        {
                    
            // on recupere les données du form dans un tableau de 3 cases indicés par 'TrancheAge' 'Genre' et 'Epoque'
            $tabChoixResLivres = $formulaireRechAvanceeLivres -> getData();
            
            //var_dump($tabChoixResLivres);
            
            // je recup mes variables
            $choixEpoqueL = $tabChoixResLivres['EpoqueL'] -> getId();
            $choixGenreL = $tabChoixResLivres['GenreL'] -> getId();
            $choixTrancheAgeL = $tabChoixResLivres['TrancheAgeL'] -> getId();
            $choixThematiqueL = $tabChoixResLivres['ThematiqueL'] -> getId();
            $choixAuteur = $tabChoixResLivres['Auteur'][0] -> getId();
            $choixEditeur = $tabChoixResLivres['Editeur'][0] -> getId();

                        // je charge mon repository de Livre pour executer une requete sur la BD
                        $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
                        // j'execute la requete perso pour remplir un tableau de livre en accord avec le formulaire de page d'acceuil
                        $tabLivres = $repositoryLivres->getLivresAvancee($choixAuteur, $choixEditeur, $choixEpoqueL, $choixGenreL, $choixTrancheAgeL, $choixThematiqueL);
        //var_dump($tabLivres);
        
                    $g=0;
                    $tabLivresIdBrut="";
                    for ($g=0; $g < count($tabLivres); $g++)
                    {
                        $tabLivresIdBrut = $tabLivres[$g]->getId() . ";" . $tabLivresIdBrut;
                    }
                    $livresId=$tabLivresIdBrut;
    //var_dump($filmsId);
                        
                                if(count($tabLivres) == 0)
                                {
                                        return $this->render('NarratioWebOeuvresBundle:Default:erreur.html.twig');
                                }
                                else
                                {

                                                // je charge mon repository de Image pour executer une requete sur la BD
                                                $repositoryImages = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Image');
                                                // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
                                            
                                        // je prepare mon tableau d'images des oeuvres 
                                        $tabImages = array();
                                        $k=0;
                                                for($k=0;$k<count($tabLivres);$k++)
                                                {
                                                
                                                    $tabImages[$k] = $repositoryImages->getImageByLivre($tabLivres[$k]->getImageLivre());
                                                    
                                                }
                                
                                }
                                    
                $q = 0;
                $c =0;
                $tabRes = array();
                for($q=0; $q < count($tabLivres); $q++)
                {
                    
                    $tabRes[$q][$c] = $tabLivres[$q];
                    $c++;
                    $tabRes[$q][$c] = $tabImages[$q][0];
                    $c=0;
                    
                }
                
    //var_dump($tabRes);

            $page = 0;

                return $this->render('NarratioWebOeuvresBundle:Default:oeuvreAvanceeLivres.html.twig', 
                                array(
                                        'tabRes'=>$tabRes,
                                        'page'=>$page,
                                        'tabLivresIdBrut'=>$tabLivresIdBrut,
                                        'livresId'=>$livresId
                                ));
        }
        
        // je met page a 0 pour la premiere fois que ca affiche
        $page=0;
        
        // ici, on affiche la page dont le formulaire permettant le choix d'une oeuvre via Random
        return $this->render('NarratioWebOeuvresBundle:Default:rechercheAvancee.html.twig', 
        array(
            'formFilms'=>$formulaireRechAvanceeFilms->createView(), 
            'formLivres'=>$formulaireRechAvanceeLivres->createView(),
            'page'=>$page
            
            ));
        
    }

    
            
public function voirOeuvreAction($id)
    {
            
        // recup des oeuvres pour remplir le menu déroulant
        $repositoryOeuvre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
        // On récupère l'oeuvre ayant pour identifiant $id
        $oeuvre = $repositoryOeuvre->findOneById($id);
        $idOeuvre = $oeuvre->getId();
        
        $tabOeuvreChoix = $repositoryOeuvre->getOeuvreChoix($oeuvre->getEpoque(), $oeuvre->getGenre(), $oeuvre->getTrancheAge());
            
            //var_dump($oeuvre);
            
                // je charge mon repository de Livre pour executer une requete sur la BD
                $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
                // j'execute la requete perso pour remplir un tableau de livre en accord avec le formulaire de page d'acceuil
                $tabLivres = $repositoryLivres->getLivresByOeuvre($idOeuvre);
                
                // je charge mon repository de Film pour executer une requete sur la BD
                $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
                // j'execute la requete perso pour remplir un tableau de film en accord avec le formulaire de page d'acceuil
                $tabFilms = $repositoryFilms->getFilmsByOeuvre($idOeuvre);
                
                // je charge mon repository de Image pour executer une requete sur la BD
                $repositoryImage = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Image');
                // j'execute la requete perso pour remplir mon image de l oeuvre
                $tabImage = $repositoryImage->getImageByOeuvre($idOeuvre);
                // je definis l image principale
                $image = $tabImage[0];
                
                               //var_dump($tabOeuvreChoix);
                               
                                        if(count($tabFilms) > 3)
                                        {        
                                                // IMAGE DE SUGGESTION A FAIRE
                                                $tabImagesId = array();
                                                $s=0;
                                                        while ($s<count($tabOeuvreChoix))
                                                        {
                                                                $tabImagesId[$s] = $tabOeuvreChoix[$s]->getId();
                                                                $s++;
                                                        }
                                                $tabImagesSuggestionsBrut = array();
                                                $j=0;
                                                        // je récupere les images grace a une requete et l'id des oeuvres
                                                        while ($j<count($tabImagesId)-1)
                                                        {
                                                                $tabImagesSuggestionsBrut[$j] = $repositoryImage->getImageByOeuvre($tabImagesId[$j]);
                                                                $j++;
                                                        }
                                                      
                                                      
                                                        
                                                // je met en forme le tableau pour qu'il soit utilisable facilement
                                                $tabImagesSuggestions = array();
                                                $l=0;
                                                        while ($l<count($tabImagesSuggestionsBrut)-1)
                                                        {
                                                                $tabImagesSuggestions[$l] = $tabImagesSuggestionsBrut[$l][0];
                                                                $l++;
                                                        }
                                                        
                                                //var_dump($tabOeuvreChoix);
                                        }
                                        else
                                        {
                                                $tabImagesSuggestions = array();
                                                $tabImagesSuggestions = $repositoryImage->getImageSugg();
                                        }
                                        
                                
                                // je prepare mes parametres pour le web service de IMDB
                                $titre = $tabFilms[0]->getOeuvre()->getNom();     
                                $annee = $tabFilms[0]->getAnnee();
                                // j'ajoute le %20 a la place des espaces
                                $titreUrl=rawurlencode($titre);
                                 
                                // je recupere le web service pour voir si ca echoue ou pas
                                $resImdbBrut=file_get_contents("http://www.omdbapi.com/?t=$titreUrl&y=$annee&plot=short&r=json");
                                // je le decode pour avoir l objet et non la string
                                $resImdb=json_decode($resImdbBrut);
                                $resImdbBool=$resImdb->{'Response'};
                                
                                if ($resImdbBool != "False")
                                {
                                            
                                    // je recupere le json
                                    $json=file_get_contents("http://www.omdbapi.com/?t=$titreUrl&y=$annee&plot=short&r=json");
                                    
                                    // je decode le json
                                    $resImdb=json_decode($json);
                                        
                                }
                                else
                                {
                                    
                                    $resImdb = null;
                                    
                                }
                                
                                
                // je charge mon repository de Note pour executer une requete sur la BD
                $repositoryNotes = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Note');
                // j'execute la requete perso pour remplir un tableau de notes en accord avec le formulaire de page d'acceuil
                $tabNotes = $repositoryNotes->getNotesByOeuvre($idOeuvre);
                    
                    if($tabNotes != null)
                    {
                        $note=0;
                        $q=0;
                        for($q=0; $q<count($tabNotes); $q++)
                        {
                            // je calcule la note
                            $note = $note + $tabNotes[$q]->getValeur();
                        }
                            $note = $note / count($tabNotes);
                            // je l'arrondis pour afficher n étoiles
                            $note = round($note);
                    }
                    else
                    {
                        $note = null;
                    }
                            
                                    //var_dump($note);
                                        
                                //On augmente le compteur de vues de l'oeuvre !
                                $compteur = $oeuvre->getCompteurVues();
                                $oeuvre->setCompteurVues($compteur+1);
                                $gestionnaireEntite = $this->getDoctrine()->getManager();
                                $gestionnaireEntite->persist($oeuvre);
                                $gestionnaireEntite->flush();               
            
            // je retourne la vue avec les oeuvres a mettre en forme
            return $this->render('NarratioWebOeuvresBundle:Default:oeuvre.html.twig', array(  
                                                                                'tabLivres'=>$tabLivres,
                                                                                'tabFilms'=>$tabFilms,
                                                                                'image'=>$image,
                                                                                'oeuvre'=>$oeuvre,
                                                                                'tabImagesSuggestions'=>$tabImagesSuggestions,
                                                                                'id'=>$idOeuvre,
                                                                                'resImdb'=>$resImdb,
                                                                                'note'=>$note
                                                                                ));
            
        }


public function oeuvreAvanceeFilmsAction($page, $tabFilmsIdBrut, $filmsId)
    {
        
        if (isset($_POST["page"]) & isset($_POST["tabFilmsIdBrut"]) & isset($_POST["filmsId"]))
        {
            $page = $_POST["page"];
            $tabFilmsIdBrut = $_POST["tabFilmsIdBrut"];
            $filmsId = $_POST["filmsId"];
        }
        
    //var_dump($filmsId,$filmsId,$page);
            
            $tabFilmsIdCONS = array();
            $tabFilmsIdCONS = explode(";", $filmsId);
            
            $tabFilmsId = array();
            $tabFilmsId = explode(";", $tabFilmsIdBrut);
            
            //j'inverse les tableaux
            $tabFilmsIdCONS=array_reverse($tabFilmsIdCONS);
            //$tabFilmsId=array_reverse($tabFilmsId);
            
            /*On efface le premier élément du tableau*/
            //unset($tabFilmsId[0]);
            unset($tabFilmsIdCONS[0]);
            
    //var_dump($tabFilmsIdCONS);
    
            // je charge mon repository de Film pour executer une requete sur la BD
            $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
            // je prepare mon tableau de film des oeuvres 
            $tabFilms = array();
            $e=0;
            $k=1;
            //je commence a 1 car j'ai suppprimer le premier indice : 0
            for($k=1;$k<count($tabFilmsIdCONS)+1;$k++)
            {
            
                $tabFilms[$e] = $repositoryFilms->findById($tabFilmsIdCONS[$k]);
                $e++;
                
            }
            //var_dump($tabFilms);
            
                            // je charge mon repository de Image pour executer une requete sur la BD
                            $repositoryImages = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Image');
                            // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
                                
                            // je prepare mon tableau d'images des oeuvres 
                            $tabImages = array();
                            $k=0;
                                    for($k=0;$k<count($tabFilms);$k++)
                                    {
                                    
                                        $tabImages[$k] = $repositoryImages->getImageByFilm($tabFilms[$k][0]->getImageFilm());
                                        
                                    }
    //var_dump($tabImages);
    
                $q = 0;
                $c = 0;
                $tabRes = array();
                for($q=0; $q < count($tabFilms); $q++)
                {
                    
                    $tabRes[$q][$c] = $tabFilms[$q][0];
                    $c++;
                    $tabRes[$q][$c] = $tabImages[$q][0];
                    $c=0;
                    
                }
                
            //var_dump($tabRes);
    // JE GERE LE DECALAGE DES FILMS
            if(($page >= 0) & (count($tabRes)>5))
            {
                
                // je coupe mon tableau de 5 * le nb de page car 5 elements par page
                $tabRes = array_splice($tabRes, 5*$page);
                
            }
            //var_dump($tabRes);
                    $g=0;
                    $tabFilmsIdBrut="";
                    for ($g=0; $g < count($tabRes); $g++)
                    {
                        $tabFilmsIdBrut = $tabRes[$g][0]->getId() . ";" . $tabFilmsIdBrut;
                    }
           
            //var_dump($tabRes);
            
                return $this->render('NarratioWebOeuvresBundle:Default:oeuvreAvanceeFilms.html.twig', 
                                array(
                                        'tabRes'=>$tabRes,
                                        'page'=>$page,
                                        'tabFilmsIdBrut'=>$tabFilmsIdBrut,
                                        'filmsId'=>$filmsId
                                ));
        
    }



public function oeuvreAvanceeLivresAction($page, $tabLivresIdBrut, $livresId)
    {
        
        if (isset($_POST["page"]) & isset($_POST["tabLivresIdBrut"]) & isset($_POST["livresId"]))
        {
            $page = $_POST["page"];
            $tabFilmsIdBrut = $_POST["tabLivresIdBrut"];
            $filmsId = $_POST["livresId"];
        }
            
            $tabLivresIdCONS = array();
            $tabLivresIdCONS = explode(";", $livresId);
            
            $tabLivresId = array();
            $tabLivresId = explode(";", $tabLivresIdBrut);
            
            //j'inverse les tableaux
            $tabLivresIdCONS=array_reverse($tabLivresIdCONS);
            
            /*On efface le premier élément du tableau*/
            unset($tabLivresIdCONS[0]);
            
    //var_dump($tabFilmsIdCONS);
    
            // je charge mon repository de Film pour executer une requete sur la BD
            $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
            // je prepare mon tableau de film des oeuvres 
            $tabLivres = array();
            $e=0;
            $k=1;
            //je commence a 1 car j'ai suppprimer le premier indice : 0
            for($k=1;$k<count($tabLivresIdCONS)+1;$k++)
            {
            
                $tabLivres[$e] = $repositoryLivres->findById($tabLivresIdCONS[$k]);
                $e++;
                
            }
            
                            // je charge mon repository de Image pour executer une requete sur la BD
                            $repositoryImages = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Image');
                            // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
                                
                            // je prepare mon tableau d'images des oeuvres 
                            $tabImages = array();
                            $k=0;
                                    for($k=0;$k<count($tabLivres);$k++)
                                    {
                                    
                                        $tabImages[$k] = $repositoryImages->getImageByLivre($tabLivres[$k][0]->getImageLivre());
                                        
                                    }
    //var_dump($tabImages);
    
                $q = 0;
                $c = 0;
                $tabRes = array();
                for($q=0; $q < count($tabLivres); $q++)
                {
                    
                    $tabRes[$q][$c] = $tabLivres[$q][0];
                    $c++;
                    $tabRes[$q][$c] = $tabImages[$q][0];
                    $c=0;
                    
                }
                
            //var_dump($tabRes);
    // JE GERE LE DECALAGE DES LIVRES
            if(($page >= 0) & (count($tabRes)>5))
            {
                
                // je coupe mon tableau de 5 * le nb de page car 5 elements par page
                $tabRes = array_splice($tabRes, 5*$page);
                
            }
            //var_dump($tabRes);
                    $g=0;
                    $tabLivresIdBrut="";
                    for ($g=0; $g < count($tabRes); $g++)
                    {
                        $tabLivresIdBrut = $tabRes[$g][0]->getId() . ";" . $tabLivresIdBrut;
                    }
           
            //var_dump($tabRes);
            
                return $this->render('NarratioWebOeuvresBundle:Default:oeuvreAvanceeLivres.html.twig', 
                                array(
                                        'tabRes'=>$tabRes,
                                        'page'=>$page,
                                        'tabLivresIdBrut'=>$tabLivresIdBrut,
                                        'livresId'=>$livresId
                                ));
        
    }


    public function espaceMembreAction(){
        return $this->render('NarratioWebOeuvresBundle:Default:.html.twig');
    }



public function voteAction($id, $nEtoile)
    {
        
        
        switch ($nEtoile)
        {
            case 1:     $note =  1;
                        
                        break;
                        
            case 2:     $note =  2;
                        break;
                        
            case 3:     $note =  3;
                        break;
                        
            case 4:     $note =  4;
                        break;
                        
            case 5:     $note =  5;
                        break;
                        
        }
        
        // je recupère l'oeuvre noté
        $repositoryOeuvre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
        // On récupère l'oeuvre ayant pour identifiant $id
        $oeuvre = $repositoryOeuvre->findOneById($id);
        
        // J'ajoute la note
        $laNote = new Note();
        $laNote->setValeur($note);
        $laNote->setOeuvre($oeuvre);
                //On met en BD !!
                $gestionnaireEntite = $this->getDoctrine()->getManager();
                $gestionnaireEntite->persist($laNote);
                $gestionnaireEntite->flush();
//var_dump($laNote);

        // je retourne vers la même oeuvre
        return $this->voirOeuvreAction($id);
    }


public function ajouterOeuvreAction(Request $requeteUtilisateur)
    {
         // Créer un objet oeuvre vide
		$oeuvre = new Oeuvre();
		
		// Création du formulaire d'ajout d'une oeuvre
		$formulaireOeuvre = $this -> createForm(new OeuvreType, $oeuvre);
			
		// Enregistrer après soumission du formulaire les données dans l'objet $oeuvre
		$formulaireOeuvre -> handleRequest($requeteUtilisateur);
		
		if ($formulaireOeuvre -> isValid())
		{
		// on enregistre l'oeuvre en BD
		$gestionnaireEntite = $this -> getDoctrine() -> getManager();
		$gestionnaireEntite -> persist($oeuvre);
		$gestionnaireEntite -> flush();
		
		// on redirige l'utilisateur vers la page de l'oeuvre nouvellement ajoutée
		// return $this ->redirect($this -> generateUrl('narratio_web_oeuvres_oeuvre', array ('id'=>$oeuvre -> getId())));	
        }
        
        // Créer un objet image vide
		$image = new Image();
		
		$formulaireImage = $this -> createForm(new ImageType, $image);
			
		// Enregistrer après soumission du formulaire les données dans l'objet $image
		$formulaireImage -> handleRequest($requeteUtilisateur);
		
		if ($formulaireImage -> isValid())
		{
		// on enregistre l'image en BD
		$gestionnaireEntite = $this -> getDoctrine() -> getManager();
		$gestionnaireEntite -> persist($image);
		$gestionnaireEntite -> flush();
		
        }
        
        // Créer un objet livre vide
		$livre = new Livre();
		
		$formulaireLivre = $this -> createForm(new LivreType, $livre);
			
		// Enregistrer après soumission du formulaire les données dans l'objet $livre
		$formulaireLivre -> handleRequest($requeteUtilisateur);
		
		if ($formulaireLivre -> isValid())
		{
		// on enregistre l'livre en BD
		$gestionnaireEntite = $this -> getDoctrine() -> getManager();
		$gestionnaireEntite -> persist($livre);
		$gestionnaireEntite -> flush();
		
        }
        
        // Créer un objet film vide
		$film = new Film();
		
		$formulaireFilm = $this -> createForm(new FilmType, $film);
			
		// Enregistrer après soumission du formulaire les données dans l'objet $film
		$formulaireFilm -> handleRequest($requeteUtilisateur);
		
		if ($formulaireFilm -> isValid())
		{
		// on enregistre l'film en BD
		$gestionnaireEntite = $this -> getDoctrine() -> getManager();
		$gestionnaireEntite -> persist($film);
		$gestionnaireEntite -> flush();
		
        }
        
         // Envoi du formulaire à la vue chargée de l'afficher 
    return $this->render('NarratioWebOeuvresBundle:Default:ajouterOeuvre.html.twig', array('formulaireOeuvre' => $formulaireOeuvre -> createView(),
                                                                                            'formulaireImage' => $formulaireImage -> createView(),
                                                                                            'formulaireLivre' => $formulaireLivre -> createView(),
                                                                                            'formulaireFilm' => $formulaireFilm -> createView()));
}

        
    

        

public function modifierOeuvreAction($type, $id, Request $requeteUtilisateurL, Request $requeteUtilisateurF, Request $requeteUtilisateurO)
{
        
    
    // je prepare mes formulaires !!!
    // Tableau dans lequel les données du formulaire seront recueillies
        $tabFilm = array();
        $tabLivre = array();
        $tabOeuvre = array();

            
    switch ($type)
        {
            case 'monOeuvre':
                // code...
                            // je charge mon repository de Oeuvre pour executer une requete sur la BD
                            $repositoryOeuvres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
                            // j'execute la requete perso pour remplir un tableau de oeuvre en accord avec le formulaire de page d'acceuil
                            $oeuvre = $repositoryOeuvres->findById($id);
                            $obj=$oeuvre;
                            //var_dump($oeuvre);
                            
                            // je charge mon repository de Image pour executer une requete sur la BD
                            $repositoryImage = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Image');
                            // j'execute la requete perso pour remplir mon image de l oeuvre
                            $tabImage = $repositoryImage->getImageByOeuvre($id);
                            // je definis l image principale
                            $image = $tabImage[0]->getUrl();
                            
                            // Créateur formulaire OEUVRE
                            $formOeuvre = $this->createFormBuilder($tabOeuvre)
                                ->add('TrancheAge','entity', array('label'=>'Tranche d Age',
                                                                    'class'=>'NarratioWebOeuvresBundle:TrancheAge',
                                                                    'property'=>'intitule',
                                                                    'multiple' => false,
                                                                    'expanded' => false,
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getTrancheAge()
                                                                    
                                                                    ))
                                ->add('Genre','entity', array('label'=>'Genre',
                                                                    'class'=>'NarratioWebOeuvresBundle:Genre',
                                                                    'property'=>'intitule',
                                                                    'multiple' => false,
                                                                    'expanded' => false,
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getGenre()
                                                                    ))
                                ->add('Epoque','entity', array('label'=>'Epoque',
                                                                    'class'=>'NarratioWebOeuvresBundle:Epoque',
                                                                    'property'=>'intitule',
                                                                    'multiple' => false,
                                                                    'expanded' => false,
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getEpoque()
                                                                    ))
                                ->add('Thematique','entity', array('label'=>'Thematique',
                                                                    'class'=>'NarratioWebOeuvresBundle:Thematique',
                                                                    'property'=>'intitule',
                                                                    'multiple' => false,
                                                                    'expanded' => false,
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getThematique()
                                                                    ))                                                
                                ->add('ProduitDerive','textarea', array('label'=>'Produits dérivés',
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getProdDer()
                                                                    ))   
                                ->add('Concept','textarea', array('label'=>'Concept de l oeuvre',
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getConcept()
                                                                    ))   
                                ->add('Image','url', array('label'=>'Image de l oeuvre',
                                                                    'required'=>false,
                                                                    'data'=>$image
                                                                    )) 
                                ->getForm();
                            $monForm=$formOeuvre;
                            
                break;
            case 'monFilm':
                // code...
                            // je charge mon repository de Film pour executer une requete sur la BD
                            $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
                            // j'execute la requete perso pour remplir un tableau de film en accord avec le formulaire de page d'acceuil
                            $film = $repositoryFilms->findById($id);
                            $obj=$film;
                            //var_dump($film);
                            $image=$film[0]->getImageFilm()->getUrl();
                            
                            // Créateur formulaire FILM
                            $formFilm = $this->createFormBuilder($tabFilm)
                                ->add('Acteur','collection', array('label'=>null,
                                                                    'type'=> new ActeurType(),
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getActeurs(),
                                                                    'allow_add'=> true,
                                                                    'allow_delete'=> true,
                                                                    'by_reference'=>false
                                                                    ))
                                ->add('Realisateur', new RealisateurType(), array('label'=>'Realisateur',
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getRealisateur()
                                                                    ))                                           
                                ->add('Type','entity', array('label'=>'Type',
                                                                    'class'=>'NarratioWebOeuvresBundle:Type',
                                                                    'property'=>'intitule',
                                                                    'multiple' => false,
                                                                    'expanded' => false,
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getType()
                                                                    ))
                                                                    
                                ->add('Synopsis','textarea', array('label'=>'Synopsis',
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getSynopsis()
                                                                    ))
                                ->add('Annee','text', array('label'=>'Annee de parution',
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getAnnee()
                                                                    ))
                                ->add('Duree','integer', array('label'=>'Duree du film',
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getDuree()
                                                                    ))
                                ->add('Image','url', array('label'=>'Image du film',
                                                                    'required'=>false,
                                                                    'data'=>$image
                                                                    )) 
                                ->getForm();
                            $monForm=$formFilm;
                            
                break;
            case 'monLivre':
                // code...
                            // je charge mon repository de Livre pour executer une requete sur la BD
                            $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
                            // j'execute la requete perso pour remplir un tableau de Livre en accord avec le formulaire de page d'acceuil
                            $livre = $repositoryLivres->findById($id);
                            $obj=$livre;
                            //var_dump($livre);
                            $image=$livre[0]->getImageLivre()->getUrl();
                            
                            // Créateur formulaire LIVRE
                            $formLivre = $this->createFormBuilder($tabLivre)
                                ->add('Resume','textarea', array('label'=>'Resume',
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getResume()
                                                                    ))
                                ->add('Annee','text', array('label'=>'Annee de parution',
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getAnnee()
                                                                    ))     
                                ->add('Auteur', 'collection', array('label'=>null,
                                                                    'type'=> new AuteurType(),
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getAuteur(),
                                                                    'allow_add'=> true,
                                                                    'allow_delete'=> true,
                                                                    'by_reference'=>false
                                                                    ))
                                ->add('Editeur', new EditeurType(), array('label'=>'Editeur',
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getEditeur()
                                                                    ))
                                ->add('Image','url', array('label'=>'Image du livre',
                                                                    'required'=>false,
                                                                    'data'=>$image
                                                                    )) 
                                ->getForm();
                            $monForm=$formLivre;
                            
                break;
        }
    

        //var_dump($formLivre);
        
    
    
    
    if ($this->getRequest()->get('action-type-oeuvre') =='Valider')
    {
        $formOeuvre->handleRequest($requeteUtilisateurO);
        
        $tabOeuvre = $formOeuvre -> getData();
        
        // je recup mes variables
        $Epoque = $tabOeuvre['Epoque'];
        $Genre = $tabOeuvre['Genre'];
        $TrancheAge = $tabOeuvre['TrancheAge'];
        $Thematique = $tabOeuvre['Thematique'];
        $ProduitDerive = $tabOeuvre['ProduitDerive'];
        $Concept = $tabOeuvre['Concept'];
        
            // je charge mon repository de Oeuvre pour executer une requete sur la BD
            $repositoryOeuvres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
            // j'execute la requete perso pour remplir un tableau de oeuvre en accord avec le formulaire de page d'acceuil
            $oeuvre = $repositoryOeuvres->findById($id);
        $oeuvre=$oeuvre[0];    
        
        $oeuvre->setEpoque($Epoque);
        $oeuvre->setGenre($Genre);
        $oeuvre->setTrancheAge($TrancheAge);
        $oeuvre->setThematique($Thematique);
        $oeuvre->setConcept($Concept);
        $oeuvre->setProdDer($ProduitDerive);
        
                //On met en BD !!
                $gestionnaireEntite = $this->getDoctrine()->getManager();
                $gestionnaireEntite->persist($oeuvre);
                $gestionnaireEntite->flush();
        
        return $this->voirOeuvreAction($oeuvre->getId());
        
    }
    if ($this->getRequest()->get('action-type-film') =='Valider')
    {
        $formFilm->handleRequest($requeteUtilisateurF);
        
        $tabFilm = $formFilm -> getData();
        
        // je recup mes variables
        $Type = $tabFilm['Type'];
        $Synopsis = $tabFilm['Synopsis'];
        $Annee = $tabFilm['Annee'];
        $Realisateur = $tabFilm['Realisateur'];
        $Duree = $tabFilm['Duree'];
        $Acteur = $tabFilm['Acteur'];
        
            // je charge mon repository de Film pour executer une requete sur la BD
            $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
            // j'execute la requete perso pour remplir un tableau de film en accord avec le formulaire de page d'acceuil
            $film = $repositoryFilms->findById($id);
        $film=$film[0];
        
        $film->setType($Type);
        $film->setSynopsis($Synopsis);
        $film->setAnnee($Annee);
        $film->setRealisateur($Realisateur);
        $film->setDuree($Duree);
        $tabActeur=$Acteur->toArray();
                
//var_dump($tabActeur);

    $acteurDuFilm = $film->getActeurs()->toArray();
    $w=0;
    for($w=0; $w < count($acteurDuFilm); $w++)
    {
        
        if((in_array($acteurDuFilm[$w], $tabActeur)) == false)
        {
            //var_dump($auteurDuLivre[$w]);
            $monActeur=$acteurDuFilm[$w];
            $film -> removeActeur($monActeur);
        }
        else
        {
            
        }
        
    }
    
    // je calcule mon indice d'arret pour trier et enlever les cases vide d'un tableau
    $indicesTab=array_keys($tabActeur);
    $lastIndice = $indicesTab[count($indicesTab)-1];
//var_dump($lastIndice);

    $tabTri=array();
    $v=0;
    $b=0;
    for($v=0;$v<=$lastIndice;$v++)
    {
        if(!empty($tabActeur[$v]))
        {
            $tabTri[$b]=$tabActeur[$v];
            $b++;
        }
        
    }
    $tabActeur=$tabTri;
    
//var_dump($tabActeur);
        $repositoryActeur = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Acteur');
        $t=0;
        for ($t=0; $t < count($tabActeur); $t++)
        {
            
            if(($repositoryActeur -> findById($tabActeur[$t]->getId())) != null)
            {   
                $leActeur = $repositoryActeur -> findById($tabActeur[$t]->getId());
                $leActeur=$leActeur[0];
                $leActeur -> setNom($tabActeur[$t]->getNom());
                $leActeur -> setPrenom($tabActeur[$t]->getPrenom());
                
                $gestionnaireEntite = $this->getDoctrine()->getManager();
                $gestionnaireEntite->persist($leActeur);
                $gestionnaireEntite->flush();
            }
            else
            {
                $monActeur = new Acteur();
                $monActeur -> setNom($tabActeur[$t]->getNom());
                $monActeur -> setPrenom($tabActeur[$t]->getPrenom());
                
                $gestionnaireEntite = $this->getDoctrine()->getManager();
                $gestionnaireEntite->persist($monActeur);
                $gestionnaireEntite->flush();
                
                $film -> addActeur($monActeur);
            }
            
        }

                //On met en BD !!
                $gestionnaireEntite = $this->getDoctrine()->getManager();
                $gestionnaireEntite->persist($film);
                $gestionnaireEntite->flush();
        
        return $this->voirOeuvreAction($film->getOeuvre()->getId());
        
    }
    if ($this->getRequest()->get('action-type-livre') =='Valider')
    {
        $formLivre->handleRequest($requeteUtilisateurL);
        
        $tabLivre = $formLivre -> getData();
        
        // je recup mes variables
        $Editeur = $tabLivre['Editeur'];
        $Resume = $tabLivre['Resume'];
        $Annee = $tabLivre['Annee'];
        $Auteur = $tabLivre['Auteur'];
        
            // je charge mon repository de Film pour executer une requete sur la BD
            $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
            // j'execute la requete perso
            $livre = $repositoryLivres->findById($id);
        $livre=$livre[0];
        
        $livre->setEditeur($Editeur);
        $livre->setResume($Resume);
        $livre->setAnnee($Annee);
        $tabAuteur = $Auteur->toArray();
        
//var_dump($tabAuteur);

    $auteurDuLivre = $livre->getAuteur()->toArray();
    $w=0;
    for($w=0; $w < count($auteurDuLivre); $w++)
    {
        
        if((in_array($auteurDuLivre[$w], $tabAuteur)) == false)
        {
            //var_dump($auteurDuLivre[$w]);
            $monAuteur=$auteurDuLivre[$w];
            $livre -> removeAuteur($monAuteur);
        }
        else
        {
            
        }
        
    }
    
    
//var_dump($auteurDuLivre);
        $repositoryAuteur = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Auteur');
        $t=0;
        for ($t=0; $t < count($tabAuteur)+1; $t++)
        {
            if($t == 1){}
            else
            {
            if(($repositoryAuteur -> findById($tabAuteur[$t]->getId())) != null)
            {   
                $leAuteur = $repositoryAuteur -> findById($tabAuteur[$t]->getId());
                $leAuteur=$leAuteur[0];
                $leAuteur -> setNom($tabAuteur[$t]->getNom());
                $leAuteur -> setPrenom($tabAuteur[$t]->getPrenom());
                
                $gestionnaireEntite = $this->getDoctrine()->getManager();
                $gestionnaireEntite->persist($leAuteur);
                $gestionnaireEntite->flush();
            }
            else
            {
                $monAuteur = new Auteur();
                $monAuteur -> setNom($tabAuteur[$t]->getNom());
                $monAuteur -> setPrenom($tabAuteur[$t]->getPrenom());
                
                $gestionnaireEntite = $this->getDoctrine()->getManager();
                $gestionnaireEntite->persist($monAuteur);
                $gestionnaireEntite->flush();
                
                $livre -> addAuteur($monAuteur);
            }
            }
        }

                //On met en BD !!
                $gestionnaireEntite = $this->getDoctrine()->getManager();
                $gestionnaireEntite->persist($livre);
                $gestionnaireEntite->flush();
        
        return $this->voirOeuvreAction($livre->getOeuvre()->getId());
        
    }
    


        // Envoi du formulaire à la vue chargée de l'afficher 
        return $this->render('NarratioWebOeuvresBundle:Default:modifierOeuvre.html.twig', array(
                                                                                'type'=>$type,
                                                                                'id'=>$id,
                                                                                'monForm'=>$monForm->createView(),
                                                                                'obj'=>$obj,
                                                                                'image'=>$image
            ));
            
}




}
/*


->add('Auteur', CollectionType::class, array(
                                                // each entry in the array will be an "email" field
                                                'type' => 'text',
                                                'data'=>$obj[0]->getAuteur(),
                                                // these options are passed to each "email" type
                                                'entry_options' => array(
                                                    'required' => false,
                                                    'attr' => array('class' => 'Auteur')
                                                )))


->add('Auteur','text', array('label'=>'Auteur',
                                                                    'required'=>false,
                                                                    'data'=>$obj[0]->getAuteur()->getLabel()
                                                                    ))

*/