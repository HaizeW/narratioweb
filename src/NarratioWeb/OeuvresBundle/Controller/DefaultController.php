<?php

namespace NarratioWeb\OeuvresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        
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
            'choices'=>array('1950 - 1960','2010 - 2020')))
        -> getForm();
        
        return $this->render('NarratioWebOeuvresBundle:Default:index.html.twig', array('createurFormulaire'=>$createurFormulaire->createView()));
        

    }



    public function rechercheAvanceeAction()
{
    
        return $this->render('NarratioWebOeuvresBundle:Default:rechercheAvancee.html.twig');
    
}



    public function histoireAction($id)
{
    
    $menu = array(
    array('route' => 'narration_web_oeuvres_histoire', 'icon' => 'home', 'libelle' => 'Histoire'),
    array('route' => 'narration_web_oeuvres_livres', 'icon' => 'envelope', 'libelle' => 'Livres'),
    array('route' => 'narration_web_oeuvres_films', 'icon' => 'eye-open', 'libelle' => 'Films'),
    array('route' => 'narration_web_oeuvres_autres', 'icon' => 'eject', 'libelle' => 'Autres')
    );
    
    
    return $this->render('NarratioWebOeuvresBundle:Default:histoire.html.twig', array('id'=> $id, 'menu' => $menu));
    
}


}


