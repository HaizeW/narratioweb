<?php

namespace NarratioWeb\OeuvresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OC\PlatformBundle\Entity\Advert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Oeuvre;

class DefaultController extends Controller
{
    public function indexAction(Request $requeteUtilisateur)
    {
        
        // Tableau dans lequel les données du formulaire seront recueillies       
        $tabChoix = array();
        
        // creation du formulaire
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
        
        // enregistrement des données dans $tabChoix apres soumission
        $formulaireChoix->handleRequest($requeteUtilisateur);
        // si le form a été soumis
        if ($formulaireChoix->isSubmitted())
        {
            // on recupere les données du form dans un tableau de 3 cases indicés par 'TrancheAge' 'Genre' et 'Epoque'
            $tabChoixRes = $formulaireChoix -> getData();
            
            // je recup mes variables
            $choixEpoque = $tabChoixRes['Epoque'] -> getId();
            $choixGenre = $tabChoixRes['Genre'] -> getId();
            $choixTrancheAge = $tabChoixRes['TrancheAge'] -> getId();
            
            // on traite les données du formulaire en generant l url relative
            $url = $this->generateUrl('narratio_web_oeuvres_oeuvre',
                                        array('choixGenre'=>$choixGenre,'choixEpoque'=>$choixEpoque,'choixTrancheAge'=>$choixTrancheAge), true);
            return $this->redirect($url);
            
        }
        
        // recup des livres pour remplir le menu déroulant
        $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
        $tabLivres = $repositoryLivres->findAll();
            
        // recup des films pour remplir le menu déroulant
        $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
        $tabFilms = $repositoryFilms->findAll();
        
        // ici, on affiche la page dont le formulaire permettant le choix d'une oeuvre via Random
        return $this->render('NarratioWebOeuvresBundle:Default:index.html.twig', array('form'=>$formulaireChoix->createView(), 'tabFilms'=>$tabFilms, 'tabLivres'=>$tabLivres));

    }

    
    public function rechercheAvanceeAction(Request $requeteUtilisateur)
    {
        
        // Tableau dans lequel les données du formulaire seront recueillies
        $tabRechercheAvanceeFilms = array();
        
        // Créateur formulaire
        $formulaireRechAvancee = $this->createFormBuilder($tabRechercheAvanceeFilms)
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
            ->add('Acteur','entity', array('label'=>'Acteur',
                                                'class'=>'NarratioWebOeuvresBundle:Acteur',
                                                'property'=>'nom',
                                                'property'=>'prenom',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('Realisateur','entity', array('label'=>'Realisateur',
                                                'class'=>'NarratioWebOeuvresBundle:Realisateur',
                                                'property'=>'nom',
                                                'property'=>'prenom',
                                                'multiple' => false,
                                                'expanded' => false))                                                                     
            ->add('Thematique','entity', array('label'=>'Thematique',
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
        
        // enregistrement des données dans $tabChoix apres soumission
        $formulaireRechAvancee->handleRequest($requeteUtilisateur);
        // si le form a été soumis
        if ($formulaireRechAvancee->isSubmitted())
        {
            // on recupere les données du form dans un tableau de 3 cases indicés par 'TrancheAge' 'Genre' et 'Epoque'
            $tabChoixRes = $formulaireRechAvancee -> getData();
            
            // je recup mes variables
            $choixEpoque = $tabChoixRes['Epoque'] -> getId();
            $choixGenre = $tabChoixRes['Genre'] -> getId();
            $choixTrancheAge = $tabChoixRes['TrancheAge'] -> getId();
            $choixActeur = $tabChoixRes['Acteur'] -> getId();
            $choixRealisateur = $tabChoixRes['Realisateur'] -> getId();
            $choixThematique = $tabChoixRes['Thematique'] -> getId();
            $choixType = $tabChoixRes['Type'] -> getId();

            // on traite les données du formulaire en generant l url relative
            $url = $this->generateUrl('narratio_web_oeuvres_oeuvre',
                                        array('choixGenre'=>$choixGenre,'choixEpoque'=>$choixEpoque,'choixTrancheAge'=>$choixTrancheAge,'choixActeur'=>$choixActeur,'choixRealisateur'=>$choixRealisateur,'choixThematique'=>$choixThematique,'choixType'=>$choixType), true);
            return $this->redirect($url);
            
        }
        
        return $this->render('NarratioWebOeuvresBundle:Default:rechercheAvancee.html.twig', array('form'=>$formulaireRechAvancee->createView()));
    
    }

    
    
    
    public function oeuvreAction($choixEpoque, $choixGenre, $choixTrancheAge)
    {
     ///* CECI EST FAIT APRES QUE LE FORM DE CHOIX A ETE SUBMIT
        
        // je charge mon repository de Oeuvre pour executer une requete sur la BD
        $repositoryOeuvre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
        // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
        $tabOeuvreChoix = $repositoryOeuvre->getOeuvreChoix($choixEpoque, $choixGenre, $choixTrancheAge);
        
        //var_dump($tabOeuvreChoix);
        // oeuvre répondant le mieux aux critères
        $oeuvreChoisie = $tabOeuvreChoix[0];
        
        //J'incrémente mon compteur de vues
        $oeuvreChoisie->setCompteurVues($oeuvreChoisie->getCompteurVues()+1);
        
        // je retourne la vue avec les oeuvres a mettre en forme
        return $this->render('NarratioWebOeuvresBundle:Default:oeuvre.html.twig', array('tabOeuvreChoix'=>$tabOeuvreChoix, 'oeuvreChoisie'=>$oeuvreChoisie));
        
     //*/  
     
    }
    
    
    public function oeuvreAvanceeFilmAction($choixEpoque, $choixGenre, $choixTrancheAge, $choixActeur, $choixRealisateur, $choixType, $choixThematique)
    {
     ///* CECI EST FAIT APRES QUE LE FORM DE CHOIX A ETE SUBMIT
        
        // je charge mon repository de Oeuvre pour executer une requete sur la BD
        $repositoryOeuvre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:OeuvreCine');
        // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
        $tabOeuvreChoix = $repositoryOeuvre->getOeuvreCine($choixEpoque, $choixGenre, $choixTrancheAge, $choixActeur, $choixRealisateur, $choixType, $choixThematique);
        
        //var_dump($tabOeuvreChoix);
        // oeuvre répondant le mieux aux critères
        $oeuvreChoisie = $tabOeuvreChoix[0];
        
        //J'incrémente mon compteur de vues
        $oeuvreChoisie->setCompteurVues($oeuvreChoisie->getCompteurVues()+1);
        
        // je retourne la vue avec les oeuvres a mettre en forme
        return $this->render('NarratioWebOeuvresBundle:Default:oeuvre.html.twig', array('tabOeuvreChoix'=>$tabOeuvreChoix, 'oeuvreChoisie'=>$oeuvreChoisie));
        
     //*/
     
    }




}