<?php

namespace NarratioWeb\OeuvresBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * FilmRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FilmRepository extends EntityRepository
{
    
    public function getFilmsPlusVus()
    {
        // appel du gestionnaire d'entité
        $gestionnaireEntite = $this->_em;
        
        // ecriture de la requete personnalisée
        $requetePerso = $gestionnaireEntite->createQuery('SELECT f FROM NarratioWebOeuvresBundle:Film f ORDER BY f.id DESC');
                                                                        
        //je fixe ma limite à 3 résultats
        $requetePerso->setMaxResults(3);
        
        // execution de la requete et recup du resultat
        $tabResultats = $requetePerso -> getResult();
        
        // retour du resultat
        return $tabResultats;
    }
    
    public function getFilmsNew()
    {
        // appel du gestionnaire d'entité
        $gestionnaireEntite = $this->_em;
        
        // ecriture de la requete personnalisée
        $requetePerso = $gestionnaireEntite->createQuery('SELECT f, o FROM NarratioWebOeuvresBundle:Film f  JOIN f.oeuvreCine o ORDER BY o.compteurVues DESC');
                                                                        
        //je fixe ma limite à 3 résultats
        $requetePerso->setMaxResults(3);
        
        // execution de la requete et recup du resultat
        $tabResultats = $requetePerso -> getResult();
        
        // retour du resultat
        return $tabResultats;
    }
    
    
    
    
    public function getOeuvreCine($choixEpoqueF, $choixGenreF, $choixTrancheAgeF, $choixActeur, $choixRealisateur, $choixType, $choixThematiqueF)
    {
        
        // appel du gestionnaire d'entité
        $gestionnaireEntite = $this->_em;
        
        // ecriture de la requete personnalisée
        $requetePerso = $gestionnaireEntite->createQuery('SELECT f, oc, o FROM NarratioWebOeuvresBundle:Film f 
                                                                JOIN f.oeuvreCineId oc
                                                                JOIN oc.id o
                                                                        WHERE o.id = oc.id
                                                                        
                                                                        AND f.realisateur = :choixRealisateur                        
                                                                        AND f.type = :choixType     
                                                                        
                                                                        
                                                                        AND o.genre = :choixGenre
                                                                        AND o.epoque = :choixEpoque
                                                                        AND o.trancheAge = :choixTrancheAge                                 
                                                                        AND o.thematique = :choixThematique
                                                                        AND o.discr = "oeuvrecine"
                                                                        ');
        
        // je definis mes parametres
        $requetePerso->setParameter('choixEpoque', $choixEpoqueF);
        $requetePerso->setParameter('choixGenre', $choixGenreF);
        $requetePerso->setParameter('choixTrancheAge', $choixTrancheAgeF);
        $requetePerso->setParameter('choixActeur', $choixActeur);
        $requetePerso->setParameter('choixRealisateur', $choixRealisateur);
        $requetePerso->setParameter('choixType', $choixType);
        $requetePerso->setParameter('choixThematique', $choixThematiqueF);
        
        // execution de la requete et recup du resultat
        $tabResultats = $requetePerso -> getResult();
        
        // retour du resultat
        return $tabResultats;
        
    }
    
    
    
    
}



                             
//                                                              AND o.acteur = :choixActeur  