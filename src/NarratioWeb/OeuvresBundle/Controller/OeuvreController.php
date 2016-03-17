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
        	    throw $this->createNotFoundException('The product does not exist');
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
                                                                                'id'=>$idOeuvre
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
                                throw $this->createNotFoundException('The product does not exist');
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
                                                                                'id'=>$idOeuvre
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
                                                                                'id'=>$idOeuvre
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
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('Editeur','entity', array('label'=>'Editeur',
                                                'class'=>'NarratioWebOeuvresBundle:Editeur',
                                                'property'=>'nom',
                                                'multiple' => false,
                                                'expanded' => false)) 
            ->getForm();
        
        
        // enregistrement des données dans $tabChoixResFilms apres soumission
        $formulaireRechAvanceeFilms->handleRequest($requeteUtilisateurF);
        $formulaireRechAvanceeLivres->handleRequest($requeteUtilisateurL);
        
        
        // si le form FILMS a été soumis
        if ($this->getRequest()->get('action-type') =='Films') //($formulaireRechAvanceeFilms->isSubmitted())
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
                        $tabFilms = $repositoryFilms->getFilmsAvancee($choixActeur, $choixRealisateur, $choixType);
                        
                        // je charge mon repository de Oeuvre pour executer une requete sur la BD
                        $repositoryOeuvre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
                                $idOeuvre = $tabFilms[0]->getOeuvre()->getId();
                        $oeuvre = $repositoryOeuvre->findOneById($idOeuvre);
                        
                                if(count($tabFilms) == 0)
                                {
                                        throw $this->createNotFoundException('The product does not exist');
                                }
                                else
                                {
                                                // je charge mon repository de Livre pour executer une requete sur la BD
                                                $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
                                                // j'execute la requete perso pour remplir un tableau de livre en accord avec le formulaire de page d'acceuil
                                                $tabLivres = $repositoryLivres->getLivresByOeuvre($idOeuvre);
                                        
                                                // je charge mon repository de Image pour executer une requete sur la BD
                                                $repositoryImage = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Image');
                                                // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
                                                $tabImage = $repositoryImage->getImageByOeuvre($idOeuvre);

                                                // je definis l'image de l'oeuvre
                                                $image = $tabImage[0];
                                                
                                                // je recup des images de sugg
                                                $tabImagesSuggestions = $repositoryImage->getImageSugg();
                                }
                
                                //var_dump($tabImagesSuggestions);
                
                                //On augmente le compteur de vues de l'oeuvre !
                                $compteur = $oeuvre->getCompteurVues();
                                $oeuvre->setCompteurVues($compteur+1);
                                $gestionnaireEntite = $this->getDoctrine()->getManager();
                                $gestionnaireEntite->persist($oeuvre);
                                $gestionnaireEntite->flush();    

                return $this->render('NarratioWebOeuvresBundle:Default:oeuvre.html.twig', array(  
                                        'tabLivres'=>$tabLivres,
                                        'tabFilms'=>$tabFilms,
                                        'image'=>$image,
                                        'oeuvre'=>$oeuvre,
                                        'tabImagesSuggestions'=>$tabImagesSuggestions,
                                        'id'=>$idOeuvre
                                        ));
        }
        
        // si le form LIVRES a été soumis
        if ($this->getRequest()->get('action-type') =='Livres') //($formulaireRechAvanceeLivres->isSubmitted())
        {
        
            // on recupere les données du form dans un tableau de 3 cases indicés par 'TrancheAge' 'Genre' et 'Epoque'
            $tabChoixResLivres = $formulaireRechAvanceeLivres -> getData();
            
            //var_dump($tabChoixResLivres);
            
            // je recup mes variables
            $choixEpoqueL = $tabChoixResLivres['EpoqueL'] -> getId();
            $choixGenreL = $tabChoixResLivres['GenreL'] -> getId();
            $choixTrancheAgeL = $tabChoixResLivres['TrancheAgeL'] -> getId();
            $choixThematiqueL = $tabChoixResLivres['ThematiqueL'] -> getId();
            $choixAuteur = $tabChoixResLivres['Auteur'] -> getId();
            $choixEditeur = $tabChoixResLivres['Editeur'] -> getId();

                        // je charge mon repository de Livre pour executer une requete sur la BD
                        $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
                        // j'execute la requete perso pour remplir un tableau de livre en accord avec le formulaire de page d'acceuil
                        $tabLivres = $repositoryLivres->getLivresAvancee($choixAuteur, $choixEditeur);

                
                        // je charge mon repository de Oeuvre pour executer une requete sur la BD
                        $repositoryOeuvre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
                                $idOeuvre = $tabLivres[0]->getOeuvre()->getId();
                        $oeuvre = $repositoryOeuvre->findOneById($idOeuvre);
                        
                                if(count($tabLivres) == 0)
                                {
                                        throw $this->createNotFoundException('The product does not exist');
                                }
                                else
                                {
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
                                                
                                                //var_dump($tabImagesSuggestions);
                                }
                                //On augmente le compteur de vues de l'oeuvre !
                                $compteur = $oeuvre->getCompteurVues();
                                $oeuvre->setCompteurVues($compteur+1);
                                $gestionnaireEntite = $this->getDoctrine()->getManager();
                                $gestionnaireEntite->persist($oeuvre);
                                $gestionnaireEntite->flush();    

                return $this->render('NarratioWebOeuvresBundle:Default:oeuvre.html.twig', array(  
                                        'tabLivres'=>$tabLivres,
                                        'tabFilms'=>$tabFilms,
                                        'image'=>$image,
                                        'oeuvre'=>$oeuvre,
                                        'tabImagesSuggestions'=>$tabImagesSuggestions,
                                        'id'=>$idOeuvre
                                        ));
        }
        
        
        // ici, on affiche la page dont le formulaire permettant le choix d'une oeuvre via Random
        return $this->render('NarratioWebOeuvresBundle:Default:rechercheAvancee.html.twig', array('formFilms'=>$formulaireRechAvanceeFilms->createView(), 'formLivres'=>$formulaireRechAvanceeLivres->createView()));
        
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
                                                
                                        if(count($tabOeuvreChoix) > 3)
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
                            
                                    //var_dump($tabImagesSuggestions);
                                        
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
                                                                                'id'=>$idOeuvre
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