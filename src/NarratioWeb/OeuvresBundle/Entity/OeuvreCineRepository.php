<?php

namespace NarratioWeb\OeuvresBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * OeuvreCineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OeuvreCineRepository extends EntityRepository
{
    

    
        public function getFilmsByOeuvreCine($idCine)
    {
        // appel du gestionnaire d'entité
        $gestionnaireEntite = $this->_em;
        
        // ecriture de la requete personnalisée
        $requetePerso = $gestionnaireEntite->createQuery('SELECT f, o FROM NarratioWebOeuvresBundle:Film f
                                                                    FROM NarratioWebOeuvresBundle:OeuvreCine o
                                                                        WHERE f.oeuvrecine = o.id
                                                        ');
                                         
        // execution de la requete et recup du resultat
        $tabResultats = $requetePerso -> getResult();
        
        // retour du resultat
        return $tabResultats;
    }
    
    
    
}

/*


    

                                                                        
*/