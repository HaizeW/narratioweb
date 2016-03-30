<?php

namespace NarratioWeb\OeuvresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OC\PlatformBundle\Entity\Advert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


use NarratioWeb\OeuvresBundle\Form\RealisateurRepository;

use NarratioWeb\OeuvresBundle\Entity\Oeuvre;
use NarratioWeb\OeuvresBundle\Entity\Image;
use NarratioWeb\OeuvresBundle\Entity\Livre;
use NarratioWeb\OeuvresBundle\Entity\Film;
use NarratioWeb\OeuvresBundle\Entity\Note;
use NarratioWeb\OeuvresBundle\Entity\Auteur;
use NarratioWeb\OeuvresBundle\Entity\Acteur;
use NarratioWeb\OeuvresBundle\Entity\Realisateur;
use NarratioWeb\OeuvresBundle\Entity\Editeur;

use NarratioWeb\OeuvresBundle\Form\AuteurType;
use NarratioWeb\OeuvresBundle\Form\ActeurType;
use NarratioWeb\OeuvresBundle\Form\RealisateurType;
use NarratioWeb\OeuvresBundle\Form\EditeurType;
use NarratioWeb\OeuvresBundle\Form\OeuvreType;
use NarratioWeb\OeuvresBundle\Form\ImageType;
use NarratioWeb\OeuvresBundle\Form\LivreType;
use NarratioWeb\OeuvresBundle\Form\FilmType;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
                        
                        // je definis l'image de l'oeuvre
                        $image = $oeuvre->getImage();
            
                        // je charge mon repository de Image pour executer une requete sur la BD
                        $repositoryImage = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Image');
                        // je recup des images de sugg
                        $tabImagesSuggestions = $repositoryImage->getImageSugg();

                                
                                
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
                                                                                'note'=>$note,
                                                                                'tabOeuvreChoix'=>$tabOeuvreChoix
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
                                if ($nbOeuvres < 4)
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
                                                
                                                // je definis l'image de l'oeuvre
                                                $image = $oeuvre->getImage();
                                                
                                                // IMAGE DE SUGGESTION A FAIRE
                                                $tabImagesSuggestionsBrut = array();
                                                $s=0;
                                                        while ($s<count($tabOeuvreChoix))
                                                        {
                                                                $tabImagesSuggestionsBrut[$s] = $tabOeuvreChoix[$s]->getImage();
                                                                $s++;
                                                        }
                                                        
                                                // je met en forme le tableau pour qu'il soit utilisable facilement
                                                $tabImagesSuggestions = array();
                                                $l=0;
                                                        while ($l<count($tabImagesSuggestionsBrut))
                                                        {
                                                                $tabImagesSuggestions[$l] = $tabImagesSuggestionsBrut[$l];
                                                                $l++;
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
                                                                                'note'=>$note,
                                                                                'tabOeuvreChoix'=>$tabOeuvreChoix
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
                                        while ($i<count($alea))
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
                                                
                                                // je definis l'image de l'oeuvre
                                                $image = $oeuvre->getImage();
                                                
                                                // IMAGE DE SUGGESTION A FAIRE
                                                $tabImagesSuggestionsBrut = array();
                                                $s=0;
                                                        while ($s<count($tabOeuvreChoix))
                                                        {
                                                                $tabImagesSuggestionsBrut[$s] = $tabOeuvreChoix[$s]->getImage();
                                                                $s++;
                                                        }
                                                        
                                                // je met en forme le tableau pour qu'il soit utilisable facilement
                                                $tabImagesSuggestions = array();
                                                $l=0;
                                                        while ($l<count($tabImagesSuggestionsBrut))
                                                        {
                                                                $tabImagesSuggestions[$l] = $tabImagesSuggestionsBrut[$l];
                                                                $l++;
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
                
                // je definis l image principale
                $image = $oeuvre->getImage();
                
                               //var_dump($tabOeuvreChoix);
                               
                                        if(count($tabOeuvreChoix) > 3)
                                        {        
                                                // IMAGE DE SUGGESTION A FAIRE
                                                $tabImagesSuggestionsBrut = array();
                                                $s=0;
                                                        while ($s<count($tabOeuvreChoix))
                                                        {
                                                                $tabImagesSuggestionsBrut[$s] = $tabOeuvreChoix[$s]->getImage();
                                                                $s++;
                                                        }
                                                      
                                                // je met en forme le tableau pour qu'il soit utilisable facilement
                                                $tabImagesSuggestions = array();
                                                $l=0;
                                                        while ($l<count($tabImagesSuggestionsBrut))
                                                        {
                                                                $tabImagesSuggestions[$l][0] = $tabImagesSuggestionsBrut[$l];
                                                                $l++;
                                                        }
                                                        
                                                //var_dump($tabOeuvreChoix);
                                        }
                                        else
                                        {
                                            $repositoryImage = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Image');
                                                $tabImagesSuggestions = array();
                                                $tabImagesSuggestions = $repositoryImage->getImageSugg();
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
                                                                                'oeuvre'=>$oeuvre,
                                                                                'tabImagesSuggestions'=>$tabImagesSuggestions,
                                                                                'id'=>$idOeuvre,
                                                                                'note'=>$note,
                                                                                'tabOeuvreChoix'=>$tabOeuvreChoix
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
        // Contrôle d'accès sur cette action métier
        if (false === $this->get('security.context')->isGranted('ROLE_USER')){
            throw new AccessDeniedException();
        }
        
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


public function ajouterFilmLivreAction($type, $id, Request $requeteUtilisateurF, Request $requeteUtilisateurL)
{
    // Contrôle d'accès sur cette action métier
   if (false === $this->get('security.context')->isGranted('ROLE_USER')){
            throw new AccessDeniedException();
        } 
    // je charge mon repository de Oeuvre pour executer une requete sur la BD
                            $repositoryOeuvres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
                            // j'execute la requete perso pour remplir un tableau de oeuvre en accord avec le formulaire de page d'acceuil
                            $oeuvre = $repositoryOeuvres->findById($id);
                            $obj=$oeuvre;
    
    // je prepare mes formulaires !!!
    // Tableau dans lequel les données du formulaire seront recueillies
        $tabFilm = array();
        $tabLivre = array();

    switch ($type)
        {
            case 'monFilm':
                // code...
                            
                            // Créateur formulaire FILM
                            $formFilm = $this->createFormBuilder($tabFilm)
                                ->add('Acteur','collection', array('label'=>null,
                                                                    'type'=> new ActeurType(),
                                                                    'allow_add'=> true,
                                                                    'allow_delete'=> true,
                                                                    'by_reference'=>false,
                                                                    'query_builder' => function(EntityRepository $er) {
                                                                        return $er->createQueryBuilder('a')
                                                                            ->groupBy('a.prenom')
                                                                            ->orderBy('a.prenom', 'ASC');
                                                                    }))
                                ->add('Realisateur', new RealisateurType(), array('label'=>'Realisateur'
                                                                    ))                                           
                                ->add('Type','entity', array('label'=>'Type',
                                                                    'class'=>'NarratioWebOeuvresBundle:Type',
                                                                    'property'=>'intitule',
                                                                    'multiple' => false,
                                                                    'expanded' => false
                                                                    ))
                                                                    
                                ->add('Synopsis','textarea', array('label'=>'Synopsis'
                                                                    ))
                                ->add('Annee','text', array('label'=>'Annee de parution'
                                                                    ))
                                ->add('Duree','integer', array('label'=>'Duree du film'
                                                                    ))
                                ->add('Image','url', array('label'=>'Image du film'
                                                                    ))  
                                ->add('Titre','text', array('label'=>'Titre du film'
                                                                    )) 
                                ->getForm();
                            $monForm=$formFilm;
                            
                break;
            case 'monLivre':
                // code...
                            
                            // Créateur formulaire LIVRE
                            $formLivre = $this->createFormBuilder($tabLivre)
                                ->add('Resume','textarea', array('label'=>'Resume',
                                                                    ))
                                ->add('Annee','text', array('label'=>'Annee de parution',
                                                                    ))     
                                ->add('Auteur', 'collection', array('label'=>null,
                                                                    'type'=> new AuteurType(),
                                                                    'allow_add'=> true,
                                                                    'allow_delete'=> true,
                                                                    'by_reference'=>false
                                                                    ))
                                ->add('Editeur', new EditeurType(), array('label'=>'Editeur'
                                                                    ))
                                ->add('Image','url', array('label'=>'Image du livre'
                                                                    ))  
                                ->add('Titre','text', array('label'=>'Titre du livre'
                                                                    )) 
                                ->getForm();
                            $monForm=$formLivre;
                            
                break;
        }
        
        if ($this->getRequest()->get('action-type-livre') =='Valider')
        {
            
            $formLivre->handleRequest($requeteUtilisateurL);
            
            $tabLivre = $formLivre -> getData();
            
            // je recup mes variables
            $Resume = $tabLivre['Resume'];
            $image = $tabLivre['Image'];
            $Annee = $tabLivre['Annee'];
            $Titre = $tabLivre['Titre'];
            $editeur=$tabLivre['Editeur'];
            $auteurs=$tabLivre['Auteur'];
            
            $livre = new Livre();  
            
            $Image = new Image();
            $Image->setUrl($image);
            //On met en BD !!
                    $gestionnaireEntite = $this->getDoctrine()->getManager();
                    $gestionnaireEntite->persist($Image);
                    $gestionnaireEntite->flush();
            
            $p=0;
            for($p=0; $p<count($auteurs); $p++)
            {
            
            $Auteur = new Auteur();
            $Auteur=$auteurs[$p];
            //On met en BD !!
                    $gestionnaireEntite = $this->getDoctrine()->getManager();
                    $gestionnaireEntite->persist($Auteur);
                    $gestionnaireEntite->flush();
                    
            $livre->addAuteur($Auteur);
            
            }
            
            $Editeur = new Editeur();
            $Editeur=$editeur;
            //On met en BD !!
                    $gestionnaireEntite = $this->getDoctrine()->getManager();
                    $gestionnaireEntite->persist($Editeur);
                    $gestionnaireEntite->flush();
                    
//var_dump($Editeur);
            $livre->setTitre($Titre);
            $livre->setAnnee($Annee);
            $livre->setResume($Resume);
            $livre->setEditeur($Editeur);
            $livre->setImageLivre($Image);
            $livre->setOeuvre($oeuvre[0]);
            
                    //On met en BD !!
                    $gestionnaireEntite = $this->getDoctrine()->getManager();
                    $gestionnaireEntite->persist($livre);
                    $gestionnaireEntite->flush();
            
        return $this->voirOeuvreAction($id);
                
        }
        
        if ($this->getRequest()->get('action-type-film') =='Valider')
        {
            
            $formFilm->handleRequest($requeteUtilisateurF);
            
            $tabFilm = $formFilm -> getData();
            
            // je recup mes variables
            $Titre = $tabFilm['Titre'];
            $image = $tabFilm['Image'];
            $Duree = $tabFilm['Duree'];
            $Annee = $tabFilm['Annee'];
            $Synopsis = $tabFilm['Synopsis'];
            $Type = $tabFilm['Type'];
            $realisateur=$tabFilm['Realisateur'];
            $acteurs=$tabFilm['Acteur'];
            
            $film = new Film();  
            
            $Image = new Image();
            $Image->setUrl($image);
            //On met en BD !!
                    $gestionnaireEntite = $this->getDoctrine()->getManager();
                    $gestionnaireEntite->persist($Image);
                    $gestionnaireEntite->flush();
            
            $p=0;
            for($p=0; $p<count($acteurs); $p++)
            {
            
            $Acteur = new Acteur();
            $Acteur=$acteurs[$p];
            //On met en BD !!
                    $gestionnaireEntite = $this->getDoctrine()->getManager();
                    $gestionnaireEntite->persist($Acteur);
                    $gestionnaireEntite->flush();
                    
            $film->addActeur($Acteur);
            
            }
            
            $Realisateur = new Realisateur();
            $Realisateur=$realisateur;
            //On met en BD !!
                    $gestionnaireEntite = $this->getDoctrine()->getManager();
                    $gestionnaireEntite->persist($Realisateur);
                    $gestionnaireEntite->flush();
                    
//var_dump($acteurs);
            $film->setTitre($Titre);
            $film->setAnnee($Annee);
            $film->setDuree($Duree);
            $film->setRealisateur($Realisateur);
            $film->setSynopsis($Synopsis);
            $film->setImageFilm($Image);
            $film->setType($Type);
            $film->setOeuvre($oeuvre[0]);
            
                    //On met en BD !!
                    $gestionnaireEntite = $this->getDoctrine()->getManager();
                    $gestionnaireEntite->persist($film);
                    $gestionnaireEntite->flush();
            
        return $this->voirOeuvreAction($id);
                
        }
        
        
    // Envoi du formulaire à la vue chargée de l'afficher 
        return $this->render('NarratioWebOeuvresBundle:Default:ajouterFilmLivre.html.twig', array(
                                                                                'type'=>$type,
                                                                                'id'=>$id,
                                                                                'monForm'=>$monForm->createView(),
                                                                                'obj'=>$obj
                                                                                ));
                                                                                
                                                                                
                                                                                
}

        
public function ajouterOeuvreAction(Request $requeteUtilisateur)
{
    // Contrôle d'accès sur cette action métier
    if (false === $this->get('security.context')->isGranted('ROLE_USER')){
            throw new AccessDeniedException();
        }        
    
    // je prepare mes formulaires !!!
    // Tableau dans lequel les données du formulaire seront recueillies
        $tabOeuvre = array();

                // Créateur formulaire OEUVRE
                $formOeuvre = $this->createFormBuilder($tabOeuvre)
                    ->add('TrancheAge','entity', array('label'=>'Tranche d Age',
                                                        'class'=>'NarratioWebOeuvresBundle:TrancheAge',
                                                        'property'=>'intitule',
                                                        'multiple' => false,
                                                        'expanded' => false
                                                        
                                                        ))
                    ->add('Genre','entity', array('label'=>'Genre',
                                                        'class'=>'NarratioWebOeuvresBundle:Genre',
                                                        'property'=>'intitule',
                                                        'multiple' => false,
                                                        'expanded' => false
                                                        ))
                    ->add('Epoque','entity', array('label'=>'Epoque',
                                                        'class'=>'NarratioWebOeuvresBundle:Epoque',
                                                        'property'=>'intitule',
                                                        'multiple' => false,
                                                        'expanded' => false
                                                        ))
                    ->add('Thematique','entity', array('label'=>'Thematique',
                                                        'class'=>'NarratioWebOeuvresBundle:Thematique',
                                                        'property'=>'intitule',
                                                        'multiple' => false,
                                                        'expanded' => false
                                                        ))                                                
                    ->add('ProduitDerive','textarea', array('label'=>'Produits dérivés'
                                                        ))   
                    ->add('Concept','textarea', array('label'=>'Concept de l oeuvre'
                                                        ))   
                    ->add('Image','url', array('label'=>'Image de l oeuvre'
                                                        )) 
                    ->add('Nom','text', array('label'=>'Nom de l oeuvre'
                                                        )) 
                    ->getForm();
                $monForm=$formOeuvre;
             
        if ($this->getRequest()->get('action-type-oeuvre') =='ajouter')
        {
            
            $formOeuvre->handleRequest($requeteUtilisateur);
            
            $tabOeuvre = $formOeuvre -> getData();
            
            // je recup mes variables
            $Epoque = $tabOeuvre['Epoque'];
            $Genre = $tabOeuvre['Genre'];
            $TrancheAge = $tabOeuvre['TrancheAge'];
            $Thematique = $tabOeuvre['Thematique'];
            $ProduitDerive = $tabOeuvre['ProduitDerive'];
            $Concept = $tabOeuvre['Concept'];
            $image=$tabOeuvre['Image'];
            $Nom=$tabOeuvre['Nom'];
            
            $oeuvre = new Oeuvre();  
            
            $Image = new Image();
            $Image->setUrl($image);
            //On met en BD !!
                    $gestionnaireEntite = $this->getDoctrine()->getManager();
                    $gestionnaireEntite->persist($Image);
                    $gestionnaireEntite->flush();
                    
            $Note = new Note();
            $Note->setValeur(0);
            //On met en BD !!
                    $gestionnaireEntite = $this->getDoctrine()->getManager();
                    $gestionnaireEntite->persist($Note);
                    $gestionnaireEntite->flush();
                    
            $oeuvre->setEpoque($Epoque);
            $oeuvre->setGenre($Genre);
            $oeuvre->setTrancheAge($TrancheAge);
            $oeuvre->setThematique($Thematique);
            $oeuvre->setConcept($Concept);
            $oeuvre->setProdDer($ProduitDerive);
            $oeuvre->setImage($Image);
            $oeuvre->setNom($Nom);
            $oeuvre->setCompteurVues(0);
            
                    //On met en BD !!
                    $gestionnaireEntite = $this->getDoctrine()->getManager();
                    $gestionnaireEntite->persist($oeuvre);
                    $gestionnaireEntite->flush();
            
        return $this->voirOeuvreAction($oeuvre->getId());
                
        }
             
             
             
    // Envoi du formulaire à la vue chargée de l'afficher 
        return $this->render('NarratioWebOeuvresBundle:Default:ajouterOeuvre.html.twig', array(
                                                                                'monForm'=>$monForm->createView()
                                                                                ));
}

        
public function modifierOeuvreAction($type, $id, Request $requeteUtilisateurL, Request $requeteUtilisateurF, Request $requeteUtilisateurO)
{
    // Contrôle d'accès sur cette action métier
    if (false === $this->get('security.context')->isGranted('ROLE_USER')){
            throw new AccessDeniedException();
        }    
    
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
                            
                            $ImageOeuvre=$oeuvre[0]->getImage();
                            $image=$ImageOeuvre->getUrl();
                            //var_dump($idImage);
                            
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
                                $ImageFilm=$film[0]->getImageFilm();
                            
                //var_dump($ImageFilm);
                            
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
                                $ImageLivre=$livre[0]->getImageLivre();
                            
                //var_dump($ImageLivre);
                            
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
        $Image=$tabOeuvre['Image'];
        
        // je remet l'url a l'image
        $ImageOeuvre->setUrl($Image);
        //On met en BD !!
                $gestionnaireEntite = $this->getDoctrine()->getManager();
                $gestionnaireEntite->persist($ImageOeuvre);
                $gestionnaireEntite->flush();
        
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
        $oeuvre->setImage($ImageOeuvre);
        
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
        $Image=$tabFilm['Image'];
        
        // je remet l'url a l'image
        $ImageFilm->setUrl($Image);
        //On met en BD !!
                $gestionnaireEntite = $this->getDoctrine()->getManager();
                $gestionnaireEntite->persist($ImageFilm);
                $gestionnaireEntite->flush();
                
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
        $film->setImageFilm($ImageFilm);
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
        $Image=$tabLivre['Image'];
        
        // je remet l'url a l'image
        $ImageLivre->setUrl($Image);
        //On met en BD !!
                $gestionnaireEntite = $this->getDoctrine()->getManager();
                $gestionnaireEntite->persist($ImageLivre);
                $gestionnaireEntite->flush();
        
            // je charge mon repository de Film pour executer une requete sur la BD
            $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
            // j'execute la requete perso
            $livre = $repositoryLivres->findById($id);
        $livre=$livre[0];
        
        $livre->setEditeur($Editeur);
        $livre->setResume($Resume);
        $livre->setAnnee($Annee);
        $livre->setImageLivre($ImageLivre);
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



*/