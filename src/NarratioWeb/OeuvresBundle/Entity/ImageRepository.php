<?php

namespace NarratioWeb\OeuvresBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ImageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ImageRepository extends EntityRepository
{
    
    
    public function getImageByOeuvreLitt($idLitt)
    {
        // appel du gestionnaire d'entité
        $gestionnaireEntite = $this->_em;
        
        // ecriture de la requete personnalisée
        $requetePerso = $gestionnaireEntite->createQuery('SELECT i.url FROM NarratioWebOeuvresBundle:Image i
                                                                    WHERE i.oeuvreLitt = :idLitt
                                                        ');
                                         
        // je definis mes parametres
        $requetePerso->setParameter('idLitt', $idLitt);
        
        // execution de la requete et recup du resultat
        $tabResultats = $requetePerso -> getResult();
        
        // retour du resultat
        return $tabResultats;
    }
    
    
}
