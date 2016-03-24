<?php
namespace MyNamespace;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MyClassAjaxController extends Controller
{
    /**
     * @Route("/ajax_oeuvre", name="ajax_oeuvre")
     */
    public function ajaxMemberAction(Request $request)
    {
        $value = $request->get('term');

        $em = $this->getDoctrine()->getEntityManager();
        $oeuvres = $em->getRepository('OeuvresBundle:Oeuvre')->findAjaxValue($value);

        $json = array();
        foreach ($oeuvres as $oeuvre) {
            $json[] = array(
                'value' => $oeuvre->getNom()
            );
        }

        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }
}