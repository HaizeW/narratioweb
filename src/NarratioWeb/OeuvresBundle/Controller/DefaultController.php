<?php

namespace NarratioWeb\OeuvresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        
        $repositoryEpoque = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Epoque');
        $tabEpoque = $repositoryEpoque->intituleEpoque();
        
        $repositoryTrancheAge = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:TrancheAge');
        $tabTrancheAge = $repositoryTrancheAge->intituleTrancheAge();
        
        $repositoryGenre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Genre');
        $tabGenre = $repositoryGenre->intituleGenre();
 
        // Tableau dans lequel les données du formulaire seront recueillies       
        $tabChoix = array();
        
        $createurFormulaire = $this->createFormBuilder($tabChoix)
            ->add('TrancheAge','choice', array('label'=>'Tranche d Age', 'choices'=>$tabTrancheAge))
            ->add('Genre','choice', array('label'=>'Genre', 'choices'=>$tabGenre))
            ->add('Epoque','choice', array('label'=>'Epoque', 'choices'=>$tabEpoque))
            -> getForm();
        
        $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
        $tabLivres = $repositoryLivres->findAll();
    
        $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
        $tabFilms = $repositoryFilms->findAll();
        
        return $this->render('NarratioWebOeuvresBundle:Default:index.html.twig', array('form'=>$createurFormulaire->createView(), 'tabFilms'=>$tabFilms, 'tabLivres'=>$tabLivres));

    }

    
    public function rechercheAvanceeAction()
    {
        
        $repositoryEpoque = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Epoque');
        $tabEpoque = $repositoryEpoque->intituleEpoque();
        
        $repositoryTrancheAge = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:TrancheAge');
        $tabTrancheAge = $repositoryTrancheAge->intituleTrancheAge();
        
        $repositoryGenre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Genre');
        $tabGenre = $repositoryGenre->intituleGenre();
        
        // Tableau dans lequel les données du formulaire seront recueillies
        $tabRechercheAvancee = array();
        
        // Créateur formulaire
        $createurFormulaires = $this->createFormBuilder($tabRechercheAvancee)
            ->add('TrancheAge','choice', array('label'=>'Tranche d Age', 'choices'=>$tabTrancheAge))
            ->add('Genre','choice', array('label'=>'Genre', 'choices'=>$tabGenre))
            ->add('Epoque','choice', array('label'=>'Epoque', 'choices'=>$tabEpoque))
            
            
            
            -> getForm();    
        
        
        
        // Constructeur de formulaires
        $createurFormulaires = 
        
        return $this->render('NarratioWebOeuvresBundle:Default:rechercheAvancee.html.twig', array('form'=>$createurFormulaire->createView()));
    
    }


    public function oeuvreAction($id)
    {
    
    $repositoryOeuvres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
    $tabOeuvres= $repositoryOeuvres->find($id);
    
    return $this->render('NarratioWebOeuvresBundle:Default:oeuvre.html.twig', array('id'=> $id, 'menu' => $menu, 'tabOeuvres' => $tabOeuvres));
    
    }

}