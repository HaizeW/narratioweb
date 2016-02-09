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

    public function voirFicheAction($id)
{
    return $this->render('NarratioWebOeuvresBundle:Default:voirFiche.html.twig', array('id'=> $id));
}

    public function affFormulaireAction()
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



}


