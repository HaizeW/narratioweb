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
    
    public function getOeuvreChoix($choixEpoque, $choixGenre, $choixTrancheAge) // OK
    {
        
        // appel du gestionnaire d'entité
        $gestionnaireEntite = $this->_em;
        
        // ecriture de la requete personnalisée
        $requetePerso = $gestionnaireEntite->createQuery('SELECT o FROM NarratioWebOeuvresBundle:Oeuvre o
                                                                        WHERE 
                                                                        (o.genre = :choixGenre
                                                                        AND o.epoque = :choixEpoque
                                                                        AND o.trancheAge = :choixTrancheAge)
                                                                        OR
                                                                        (o.genre = :choixGenre
                                                                        AND o.epoque = :choixEpoque
                                                                        AND (NOT o.trancheAge = :choixTrancheAge))
                                                                        OR
                                                                        (o.genre = :choixGenre
                                                                        AND (NOT o.epoque = :choixEpoque)
                                                                        AND  o.trancheAge = :choixTrancheAge)
                                                                        OR
                                                                        ((NOT o.genre = :choixGenre)
                                                                        AND o.epoque = :choixEpoque
                                                                        AND  o.trancheAge = :choixTrancheAge)
                                                                        OR
                                                                        (o.genre = :choixGenre
                                                                        AND (NOT o.epoque = :choixEpoque)
                                                                        AND (NOT o.trancheAge = :choixTrancheAge))
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
    
    public function getOeuvreRecentes() // 
    {
         // appel du gestionnaire d'entité
        $gestionnaireEntite = $this->_em;
        
        // ecriture de la requete personnalisée
        $requetePerso = $gestionnaireEntite->createQuery('SELECT o.id, o.nom, o FROM NarratioWebOeuvresBundle:Oeuvre o ORDER BY o.id DESC');
        
        //je fixe ma limite à 4 résultats
        $requetePerso->setMaxResults(5);
                                            
        // execution de la requete et recup du resultat
        $tabResultats = $requetePerso -> getResult();
        
        // retour du resultat
        return $tabResultats;
    }
    
    public function getOeuvrePlusVues() // OK
    {
         // appel du gestionnaire d'entité
        $gestionnaireEntite = $this->_em;
        
        // ecriture de la requete personnalisée
        $requetePerso = $gestionnaireEntite->createQuery('SELECT o.id, o.nom, o FROM NarratioWebOeuvresBundle:Oeuvre o ORDER BY o.compteurVues DESC');
                                            
        //je fixe ma limite à 4 résultats
        $requetePerso->setMaxResults(5);
        
        // execution de la requete et recup du resultat
        $tabResultats = $requetePerso -> getResult();
        
        // retour du resultat
        return $tabResultats;
    }
    
    public function getDerniereOeuvre() // OK
    {
         // appel du gestionnaire d'entité
        $gestionnaireEntite = $this->_em;
        
        // ecriture de la requete personnalisée
        $requetePerso = $gestionnaireEntite->createQuery('SELECT o.id, o.nom, o FROM NarratioWebOeuvresBundle:Oeuvre o ORDER BY o.compteurVues DESC');
                                            
        //je fixe ma limite à 1 résultat
        $requetePerso->setMaxResults(1);
        
        // execution de la requete et recup du resultat
        $tabResultats = $requetePerso -> getResult();
        
        // retour du resultat
        return $tabResultats;
    }
    
    public function getOeuvreChoixAvancee($choixEpoque, $choixGenre, $choixTrancheAge, $choixThematique) // OK
    {
        
        // appel du gestionnaire d'entité
        $gestionnaireEntite = $this->_em;
        
        // ecriture de la requete personnalisée
        $requetePerso = $gestionnaireEntite->createQuery('SELECT o FROM NarratioWebOeuvresBundle:Oeuvre o
                                                                        WHERE (o.genre = :choixGenre
                                                                        AND o.epoque = :choixEpoque
                                                                        AND o.trancheAge = :choixTrancheAge
                                                                        AND o.thematique = :choixThematique)
                                                                        OR
                                                                        ((NOT o.genre = :choixGenre)
                                                                        AND o.epoque = :choixEpoque
                                                                        AND o.trancheAge = :choixTrancheAge
                                                                        AND o.thematique = :choixThematique)
                                                                        OR
                                                                        (o.genre = :choixGenre
                                                                        AND (NOT o.epoque = :choixEpoque)
                                                                        AND o.trancheAge = :choixTrancheAge
                                                                        AND o.thematique = :choixThematique)
                                                                        OR
                                                                        (o.genre = :choixGenre
                                                                        AND o.epoque = :choixEpoque
                                                                        AND (NOT o.trancheAge = :choixTrancheAge)
                                                                        AND o.thematique = :choixThematique)
                                                                        OR
                                                                        (o.genre = :choixGenre
                                                                        AND o.epoque = :choixEpoque
                                                                        AND o.trancheAge = :choixTrancheAge
                                                                        AND (NOT o.thematique = :choixThematique))
                                                                                                                                                
                                                                        
                                                        ');
                                            
                                            
        // je definis mes parametres
        $requetePerso->setParameter('choixEpoque', $choixEpoque);
        $requetePerso->setParameter('choixGenre', $choixGenre);
        $requetePerso->setParameter('choixTrancheAge', $choixTrancheAge);
        $requetePerso->setParameter('choixThematique', $choixThematique);
        
        // execution de la requete et recup du resultat
        $tabResultats = $requetePerso -> getResult();
        
        // retour du resultat
        return $tabResultats;
        
    }
    

    
}




/*






*/