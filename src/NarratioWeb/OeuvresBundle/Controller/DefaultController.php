<?php

namespace NarratioWeb\OeuvresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        
        $repositoryEpoque = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Epoque');
        $tabEpoque = $repositoryEpoque->Intitule(5);

        $tabChoix = array();
    
    $createurFormulaire = $this->createFormBuilder($tabChoix)
        ->add('TrancheAge','choice',
            array('label'=>'Tranche d Age',
               'choices'=>array('Adulte','Adolescent')))
        ->add('Genre','choice',
            array('label'=>'Genre',
                'choices'=>array('Fantastique','Romance')))
        ->add('Epoque','choice',
            array('label'=>'Epoque',
            'choices'=>$tabEpoque))
        -> getForm();
        
    $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
    $tabLivres = $repositoryLivres->findAll();
    
    $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
    $tabFilms = $repositoryFilms->findAll();
        
        return $this->render('NarratioWebOeuvresBundle:Default:index.html.twig', array('form'=>$createurFormulaire->createView(), 'tabFilms'=>$tabFilms, 'tabLivres'=>$tabLivres));
        

    }



    public function rechercheAvanceeAction()
{
    
        return $this->render('NarratioWebOeuvresBundle:Default:rechercheAvancee.html.twig');
    
}



    public function histoireAction($id)
{
    
    $repositoryOeuvres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
    $tabOeuvres= $repositoryOeuvres->find($id);
    
    $menu = array(
    array('route' => 'narratio_web_oeuvres_histoire_', 'icon' => 'home', 'libelle' => 'Histoire'),
    array('route' => 'narratio_web_oeuvres_livres', 'icon' => 'envelope', 'libelle' => 'Livres'),
    array('route' => 'narratio_web_oeuvres_films', 'icon' => 'eye-open', 'libelle' => 'Films'),
    array('route' => 'narratio_web_oeuvres_autres', 'icon' => 'eject', 'libelle' => 'Autres')
    );
    
    
    return $this->render('NarratioWebOeuvresBundle:Default:histoire.html.twig', array('id'=> $id, 'menu' => $menu, 'tabOeuvres' => $tabOeuvres));
    
}



    public function livresAction($id)
{
    
    $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
    $tabLivres = $repositoryLivres->find($id);
    
    
    return $this->render('NarratioWebOeuvresBundle:Default:livres.html.twig', array('tabLivres' => $tabLivres));
    
}


    public function filmsAction($id)
{
    
    $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
    $tabFilms = $repositoryFilms->find($id);
    
    
    return $this->render('NarratioWebOeuvresBundle:Default:films.html.twig', array('tabFilms' => $tabFilms));
    
}


    public function autresAction($id)
{
    
    $repositoryAutres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:ProduitDer');
    $tabAutres = $repositoryAutres->find($id);
    
    
    return $this->render('NarratioWebOeuvresBundle:Default:autres.html.twig', array('tabAutres' => $tabAutres));
    
}

}


