<?php

namespace NarratioWeb\OeuvresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('NarratioWebOeuvresBundle:Default:index.html.twig');
    }

    public function voirFicheAction($id)
{
    return $this->render('NarratioWebOeuvresBundle:Default:voirFiche.html.twig', array('id'=> $id));
}

    public function affFormulaireAction()
{
    $tabChoix = array();
    
    $createurFormulaire = $this->createFormBuilder($tabchoix);
    
    $createurFormulaire
        ->add('TrancheAge','choice',
        array('label'=>'Tranche d Age',
               'choices'=>array('Adulte','Adolescent')))
        ->add('Genre','choice',
            array('label'=>'Genre',
                'choices'=>array('Fantastique','Romance')))
        ->add('Genre','choice',
            array('label'=>'Epoque',
            'choices'=>array('1950 - 1960','2010 - 2020')));
    
    $formChoix = $createurFormulaire -> getForm();
    
    $representationFormChoix = $formChoix -> createView();
    
    return $this->render('NarratioWebOeuvresBundle:Default:index.html.twig', array('FormChoix'=> $representationFormChoix));
}

}