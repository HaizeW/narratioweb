<?php

namespace NarratioWeb\OeuvresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OC\PlatformBundle\Entity\Advert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//use Oeuvre;

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
            ->add('nom','text',array('required'=>false))
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
        if ($this->getRequest()->get('action-type-films') =='Rechercher') //($formulaireRechAvanceeFilms->isSubmitted())
        {
            
            if($page=)
            
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
                for($q=0; $q < count($tabFilms)-1; $q++)
                {
                    
                    $tabRes[$q][$c] = $tabFilms[$q];
                    $c++;
                    $tabRes[$q][$c] = $tabImages[$q][0];
                    $c=0;
                }
                
            
            //var_dump($tabRes);
            
                return $this->render('NarratioWebOeuvresBundle:Default:oeuvreAvanceeFilms.html.twig', 
                                array(
                                        'tabRes'=>$tabRes,
                                        'page'=>$page
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

                return $this->render('NarratioWebOeuvresBundle:Default:oeuvreAvanceeLivres.html.twig', 
                                array(
                                        'tabRes'=>$tabRes
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
                // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
                $tabImage = $repositoryImage->getImageByOeuvre($idOeuvre);
                               
                               //var_dump($tabOeuvreChoix);

                                        // je definis l image principale
                                        $image = $tabImage[0];
                                                
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
                            $note = $note / count($tabNotes);
                            // je l'arrondis pour afficher n étoiles
                            $note = round($note);
                        }
                        
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



    public function connexionAction(){
        return $this->render('NarratioWebOeuvresBundle:Default:seConnecter.html.twig');
    }
 
    public function inscriptionAction(){
        return $this->render('NarratioWebOeuvresBundle:Default:sInscrire.html.twig');
    }

}


/*



    




*/