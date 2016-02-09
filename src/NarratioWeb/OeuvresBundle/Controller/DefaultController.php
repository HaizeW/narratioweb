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



}