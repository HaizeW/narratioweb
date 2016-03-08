<?php

namespace NarratioWeb\OeuvresBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * OeuvreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OeuvreRepository extends EntityRepository
{
    
    public function getOeuvreChoix($choixEpoque, $choixGenre, $choixTrancheAge)
    {
        
        // appel du gestionnaire d'entité
        $gestionnaireEntite = $this->_em;
        
        // ecriture de la requete personnalisée
        $requetePerso = $gestionnaireEntite->createQuery('SELECT o.id, o FROM NarratioWebOeuvresBundle:Oeuvre o
                                                                        WHERE o.genre = :choixGenre
                                                                        AND o.epoque = :choixEpoque
                                                                        AND o.trancheAge = :choixTrancheAge
                                                        ');
                                            
                                            
        // je definis mes parametres
        $requetePerso->setParameter('choixEpoque', $choixEpoque);
        $requetePerso->setParameter('choixGenre', $choixGenre);
        $requetePerso->setParameter('choixTrancheAge', $choixTrancheAge);
                        
        // execution de la requete et recup du resultat
        $tabResultats = $requetePerso -> getResult();
        
        // retour du resultat
        return $tabResultats;
        
    }
    
    public function getOeuvreRecentes()
    {
         // appel du gestionnaire d'entité
        $gestionnaireEntite = $this->_em;
        
        // ecriture de la requete personnalisée
        $requetePerso = $gestionnaireEntite->createQuery('SELECT DISTINCT o.id, o FROM NarratioWebOeuvresBundle:Oeuvre o ORDER BY o.id DESC');
                                            
        // execution de la requete et recup du resultat
        $tabResultats = $requetePerso -> getResult();
        
        // retour du resultat
        return $tabResultats;
    }
}




/*



SELECT DISTINCT o.nom, o FROM NarratioWebOeuvresBundle:Oeuvre o
                                                                        WHERE o.genre = :choixGenre
                                                                        AND o.epoque = :choixEpoque
                                                                        AND o.trancheAge = :choixTrancheAge



*/