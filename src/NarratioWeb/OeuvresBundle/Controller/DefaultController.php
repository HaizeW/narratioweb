<?php

namespace NarratioWeb\OeuvresBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OC\PlatformBundle\Entity\Advert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Oeuvre;

class DefaultController extends Controller
{
    public function indexAction(Request $requeteUtilisateur)
    {
        
        // Tableau dans lequel les données du formulaire seront recueillies       
        $tabChoix = array();
        
        // -- FORMULAIRE DE RECHERCHE
        $formulaireChoix = $this->createFormBuilder($tabChoix)
            ->add('TrancheAge','entity', array('label'=>'Tranche d Age',
                                                'class'=>'NarratioWebOeuvresBundle:TrancheAge',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('Genre','entity', array('label'=>'Genre',
                                                'class'=>'NarratioWebOeuvresBundle:Genre',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('Epoque','entity', array('label'=>'Epoque',
                                                'class'=>'NarratioWebOeuvresBundle:Epoque',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            -> getForm();
        
        // enregistrement des données dans $tabChoix apres soumission
        $formulaireChoix->handleRequest($requeteUtilisateur);
        // si le form a été soumis
        if ($formulaireChoix->isSubmitted())
        {
            // on recupere les données du form dans un tableau de 3 cases indicés par 'TrancheAge' 'Genre' et 'Epoque'
            $tabChoixRes = $formulaireChoix -> getData();
            
            // je recup mes variables
            $choixEpoque = $tabChoixRes['Epoque'] -> getId();
            $choixGenre = $tabChoixRes['Genre'] -> getId();
            $choixTrancheAge = $tabChoixRes['TrancheAge'] -> getId();
            
            // on traite les données du formulaire en generant l url relative
            $url = $this->generateUrl('narratio_web_oeuvres_oeuvre',
                                        array('choixGenre'=>$choixGenre,'choixEpoque'=>$choixEpoque,'choixTrancheAge'=>$choixTrancheAge), true);
            return $this->redirect($url);
        }
        
       // -- MENU DEROULANT
       // recup des livres pour remplir le menu déroulant
        $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
        $tabNewLivres = $repositoryLivres->getLivresNew();
            
        // recup des films pour remplir le menu déroulant
        $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
        $tabNewFilms = $repositoryFilms->getFilmsNew();
        
        // récup des films les plus vus
        $repositoryFilmsVus = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
        $tabFilmsVus = $repositoryFilmsVus->getFilmsPlusVus();
        
        // récup des livres les plus lus
        $repositoryLivresLus = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
        $tabLivresLus = $repositoryLivresLus->getLivresPlusLus();
    
        // *********************
        // En gros : Il faut récupérer les oeuvres récentes/plus vues, puis récupérer leurs livres et films pour les afficher.
        // Soucis : Comment récupérer les films et livres ? Et comment faire le lien vers l'oeuvre depuis le menu déroulant, vu qu'il faut l'id ??
        // *********************
        
       /* //recup des nouveaux livres
        $repositoryOeuvres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
        $tabOeuvresRec = $repositoryOeuvres->getOeuvreRecentes();
        
        $repositoryOeuvresLitt = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:OeuvreLitt');
        $tabNewLivres = $repositoryOeuvresLitt->getLivres($id);
        
        //recup des nouveaux films
        $tabNewFilms = $tabOeuvresRec->getFilms($id);
        
        //recup des livres les plus lus
        $tabOeuvresVues = $repositoryOeuvres->getOeuvrePlusVues();
        $id = $tabOeuvresVues->getId();
        $tabLivresLus = $tabOeuvresVues->getLivres($id);
        
        //recup des nouveaux films
        $tabFilmsVus = $tabOeuvresVues->getFilms($id);*/
        
        // ici, on affiche la page dont le formulaire permettant le choix d'une oeuvre via Random
        return $this->render('NarratioWebOeuvresBundle:Default:index.html.twig', array('form'=>$formulaireChoix->createView(), 'tabFilms'=>$tabNewFilms, 'tabLivres'=>$tabNewLivres, 'tabFilmsVus'=>$tabFilmsVus, 'tabLivresLus'=>$tabLivresLus));

    }
        
    
    public function rechercheAvanceeAction(Request $requeteUtilisateur)
    {
        
        // Tableau dans lequel les données du formulaire seront recueillies
        $tabRechercheAvanceeFilms = array();
        $tabRechercheAvanceeLivres = array();
        
        // Créateur formulaire FILMS
        $formulaireRechAvanceeFilms = $this->createFormBuilder($tabRechercheAvanceeFilms)
            ->add('TrancheAgeF','entity', array('label'=>'Tranche d Age',
                                                'class'=>'NarratioWebOeuvresBundle:TrancheAge',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('GenreF','entity', array('label'=>'Genre',
                                                'class'=>'NarratioWebOeuvresBundle:Genre',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('EpoqueF','entity', array('label'=>'Epoque',
                                                'class'=>'NarratioWebOeuvresBundle:Epoque',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('Acteur','entity', array('label'=>'Acteur',
                                                'class'=>'NarratioWebOeuvresBundle:Acteur',
                                                'property'=>'label', // affiche prenom + nom (méthode getLabel dans Acteur)
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('Realisateur','entity', array('label'=>'Realisateur',
                                                'class'=>'NarratioWebOeuvresBundle:Realisateur',
                                                'property'=>'label', // affiche prenom + nom
                                                'multiple' => false,
                                                'expanded' => false))                                                                     
            ->add('ThematiqueF','entity', array('label'=>'Thematique',
                                                'class'=>'NarratioWebOeuvresBundle:Thematique',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))                                                
            ->add('Type','entity', array('label'=>'Type',
                                                'class'=>'NarratioWebOeuvresBundle:Type',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))                                                 
            ->getForm();
        
        
        // Créateur formulaire LIVRES
        $formulaireRechAvanceeLivres = $this->createFormBuilder($tabRechercheAvanceeLivres)
            ->add('TrancheAgeL','entity', array('label'=>'Tranche d Age',
                                                'class'=>'NarratioWebOeuvresBundle:TrancheAge',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('GenreL','entity', array('label'=>'Genre',
                                                'class'=>'NarratioWebOeuvresBundle:Genre',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('EpoqueL','entity', array('label'=>'Epoque',
                                                'class'=>'NarratioWebOeuvresBundle:Epoque',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('ThematiqueL','entity', array('label'=>'Thematique',
                                                'class'=>'NarratioWebOeuvresBundle:Thematique',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))       
            ->add('Auteur','entity', array('label'=>'Auteur',
                                                'class'=>'NarratioWebOeuvresBundle:Auteur',
                                                'property'=>'label',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('Editeur','entity', array('label'=>'Editeur',
                                                'class'=>'NarratioWebOeuvresBundle:Editeur',
                                                'property'=>'nom',
                                                'multiple' => false,
                                                'expanded' => false)) 
            ->getForm();
        
        
        
        // enregistrement des données dans $tabChoix apres soumission
        $formulaireRechAvanceeFilms->handleRequest($requeteUtilisateur);
        $formulaireRechAvanceeLivres->handleRequest($requeteUtilisateur);   
        
        // si le form FILMS a été soumis
        if ($formulaireRechAvanceeFilms->isSubmitted())
        {
            // on recupere les données du form dans un tableau de 3 cases indicés par 'TrancheAge' 'Genre' et 'Epoque'
            $tabChoixResFilms = $formulaireRechAvanceeFilms -> getData();
            
            // je recup mes variables
            $choixEpoqueF = $tabChoixResFilms['EpoqueF'] -> getId();
            $choixGenreF = $tabChoixResFilms['GenreF'] -> getId();
            $choixTrancheAgeF = $tabChoixResFilms['TrancheAgeF'] -> getId();
            $choixActeur = $tabChoixResFilms['Acteur'] -> getId();
            $choixRealisateur = $tabChoixResFilms['Realisateur'] -> getId();
            $choixThematiqueF = $tabChoixResFilms['ThematiqueF'] -> getId();
            $choixType = $tabChoixResFilms['Type'] -> getId();

            // on traite les données du formulaire en generant l url relative
            $url = $this->generateUrl('narratio_web_oeuvres_oeuvreAvanceeFilm',
                                        array('choixGenreF'=>$choixGenreF,'choixEpoqueF'=>$choixEpoqueF,'choixTrancheAgeF'=>$choixTrancheAgeF,'choixActeur'=>$choixActeur,'choixRealisateur'=>$choixRealisateur,'choixThematiqueF'=>$choixThematiqueF,'choixType'=>$choixType), true);
            return $this->redirect($url);
            
        }
        
                
        // si le form LIVRES a été soumis
        if ($formulaireRechAvanceeLivres->isSubmitted())
        {
            // on recupere les données du form dans un tableau de 3 cases indicés par 'TrancheAge' 'Genre' et 'Epoque'
            $tabChoixResLivres = $formulaireRechAvanceeLivres -> getData();
            
            // je recup mes variables
            $choixEpoqueL = $tabChoixResLivres['EpoqueL'] -> getId();
            $choixGenreL = $tabChoixResLivres['GenreL'] -> getId();
            $choixTrancheAgeL = $tabChoixResLivres['TrancheAgeL'] -> getId();
            $choixThematiqueL = $tabChoixResLivres['ThematiqueL'] -> getId();
            $choixAuteur = $tabChoixResLivres['Auteur'] -> getId();
            $choixEditeur = $tabChoixResLivres['Editeur'] -> getId();

            // je choisis l'attribut disant que c'est un livres
        
            // on traite les données du formulaire en generant l url relative
            $url = $this->generateUrl('narratio_web_oeuvres_oeuvreAvanceeFilm',
                                        array('choixGenreL'=>$choixGenreL,'choixEpoqueL'=>$choixEpoqueL,'choixTrancheAgeL'=>$choixTrancheAgeL,'choixThematiqueL'=>$choixThematiqueL,'choixAuteur'=>$choixAuteur,'choixEditeur'=>$choixEditeur), true);
            return $this->redirect($url);
            
        }
        
        return $this->render('NarratioWebOeuvresBundle:Default:rechercheAvancee.html.twig', array('formFilms'=>$formulaireRechAvanceeFilms->createView(),
                                                                                                    'formLivres'=>$formulaireRechAvanceeLivres->createView()
                                                                                                ));
    
    }

    
    
    public function oeuvreAvanceeFilmAction($choixEpoqueF, $choixGenreF, $choixTrancheAgeF, $choixActeur, $choixRealisateur, $choixType, $choixThematiqueF)
    {
     ///* CECI EST FAIT APRES QUE LE FORM DE CHOIX A ETE SUBMIT
        
        // je charge mon repository de Oeuvre pour executer une requete sur la BD
        $repositoryOeuvre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
        // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
        $tabOeuvreChoix = $repositoryOeuvre->getOeuvreCine($choixEpoqueF, $choixGenreF, $choixTrancheAgeF, $choixActeur, $choixRealisateur, $choixType, $choixThematiqueF);
        
        var_dump($tabOeuvreChoix);
        
        // oeuvre répondant le mieux aux critères
        $oeuvreChoisie = $tabOeuvreChoix[0];
        
        // je retourne la vue avec les oeuvres a mettre en forme
        return $this->render('NarratioWebOeuvresBundle:Default:oeuvre.html.twig', array('tabOeuvreChoix'=>$tabOeuvreChoix, 'oeuvreChoisie'=>$oeuvreChoisie));
        
     //*/
     
    }
    
    public function testAction(Request $requeteUtilisateur)
    {
        
        // Tableau dans lequel les données du formulaire seront recueillies       
        $tabChoix = array();
        
        // -- FORMULAIRE DE RECHERCHE
        $formulaireChoix = $this->createFormBuilder($tabChoix)
            ->add('TrancheAge','entity', array('label'=>'Tranche d Age',
                                                'class'=>'NarratioWebOeuvresBundle:TrancheAge',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('Genre','entity', array('label'=>'Genre',
                                                'class'=>'NarratioWebOeuvresBundle:Genre',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            ->add('Epoque','entity', array('label'=>'Epoque',
                                                'class'=>'NarratioWebOeuvresBundle:Epoque',
                                                'property'=>'intitule',
                                                'multiple' => false,
                                                'expanded' => false))
            -> getForm();
        
        // enregistrement des données dans $tabChoix apres soumission
        $formulaireChoix->handleRequest($requeteUtilisateur);
        // si le form a été soumis
        if ($formulaireChoix->isSubmitted())
        {
            // on recupere les données du form dans un tableau de 3 cases indicés par 'TrancheAge' 'Genre' et 'Epoque'
            $tabChoixRes = $formulaireChoix -> getData();
            
            // je recup mes variables
            $choixEpoque = $tabChoixRes['Epoque'] -> getId();
            $choixGenre = $tabChoixRes['Genre'] -> getId();
            $choixTrancheAge = $tabChoixRes['TrancheAge'] -> getId();
            
            // on traite les données du formulaire en generant l url relative
            $url = $this->generateUrl('narratio_web_oeuvres_oeuvre',
                                        array('choixGenre'=>$choixGenre,'choixEpoque'=>$choixEpoque,'choixTrancheAge'=>$choixTrancheAge), true);
            return $this->redirect($url);
        }
        
       // -- MENU DEROULANT
       /*// recup des livres pour remplir le menu déroulant
        $repositoryLivres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
        $tabNewLivres = $repositoryLivres->getLivresNew();*/
            
        // recup des films pour remplir le menu déroulant
        $repositoryFilms = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
        $tabNewFilms = $repositoryFilms->getFilmsNew();
        
        // récup des films les plus vus
        $repositoryFilmsVus = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Film');
        $tabFilmsVus = $repositoryFilmsVus->getFilmsPlusVus();
        
        // récup des livres les plus lus
        $repositoryLivresLus = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Livre');
        $tabLivresLus = $repositoryLivresLus->getLivresPlusLus();
        
        //**********************************************************************************************************************************
        
        //Création du repository
        $repositoryOeuvre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
        
        //Récupération des oeuvres les plus récentes
        $tabNewOeuvres = $repositoryOeuvre->getOeuvreRecentes();
        
        //Récupération des oeuvres les plus vues
        $tabOeuvreVues = $repositoryOeuvre->getOeuvrePlusVues();
        
        $id = $tabNewOeuvres[10]['id'];
        
        //Récupération des derniers Livres
        $tabNewLivres = $repositoryOeuvre->getLivres($id);
        
        //var_dump($tabNewOeuvres);
    
        // *********************
        // En gros : Il faut récupérer les oeuvres récentes/plus vues, puis récupérer leurs livres et films pour les afficher.
        // Soucis : Comment récupérer les films et livres ? Et comment faire le lien vers l'oeuvre depuis le menu déroulant, vu qu'il faut l'id ??
        // *********************
        
       /* //recup des nouveaux livres
        $repositoryOeuvres = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
        $tabFilmsRec = $repositoryOeuvres->getFilms();
        
        $repositoryOeuvresLitt = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:OeuvreLitt');
        $tabNewLivres = $repositoryOeuvresLitt->getLivres($id);
        
        //recup des nouveaux films
        $tabNewFilms = $tabOeuvresRec->getFilms($id);
        
        //recup des livres les plus lus
        $tabOeuvresVues = $repositoryOeuvres->getOeuvrePlusVues();
        $id = $tabOeuvresVues->getId();
        $tabLivresLus = $tabOeuvresVues->getLivres($id);
        
        //recup des nouveaux films
        $tabFilmsVus = $tabOeuvresVues->getFilms($id);*/
        
        // ici, on affiche la page dont le formulaire permettant le choix d'une oeuvre via Random
        return $this->render('NarratioWebOeuvresBundle:Default:haize.html.twig', array('form'=>$formulaireChoix->createView(), 'tabFilms'=>$tabNewFilms, 'tabLivres'=>$tabNewLivres, 'tabFilmsVus'=>$tabFilmsVus, 'tabLivresLus'=>$tabLivresLus));

    }
    
    
            
    public function voirOeuvreAction($id)
        {
            
            // recup des livres pour remplir le menu déroulant
            $repositoryOeuvre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
            $oeuvreChoisie = $repositoryOeuvre->findOneById($id);
            
            var_dump($oeuvreChoisie);
            
            // je retourne la vue avec les oeuvres a mettre en forme
            return $this->render('NarratioWebOeuvresBundle:Default:oeuvre.html.twig', array('oeuvreChoisie'=>$oeuvreChoisie));
            
        }
        
    public function randomAction($min, $max)
    {
        $total = 6;
        
        $rand = array();
        
        while (count($rand) < $total)
        {
            $r = mt_rand($min,$max);
            if ( !in_array($r,$rand) ) 
            {
                $rand[] = $r;
            }
        }
        
        return $rand;
        
    }
    

    
    public function oeuvreAction($choixEpoque, $choixGenre, $choixTrancheAge)
    {
     ///* CECI EST FAIT APRES QUE LE FORM DE CHOIX A ETE SUBMIT
        
        // je charge mon repository de Oeuvre pour executer une requete sur la BD
        $repositoryOeuvre = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:Oeuvre');
        // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
        $tabOeuvreChoix = $repositoryOeuvre->getOeuvreChoix($choixEpoque, $choixGenre, $choixTrancheAge);
        
        // je prepare mes parametres pour les prochaines requetes
        var_dump($tabOeuvreChoix);
        
        var_dump($tabOeuvreChoix[0]["id"]);
        
        // oeuvre répondant le mieux aux critères
        $oeuvreChoisie = $tabOeuvreChoix[0][0];
        
        var_dump($oeuvreChoisie);
        
/*        
        for ($j=0; $j<count($tabOeuvreChoix)+1; $j++)
        {
            
            $oeuvreLitt = $tabOeuvreChoix[$j];
            $j++;
            $oeuvreCine = $tabOeuvreChoix[$j];
            $j++;
            $oeuvreProd = $tabOeuvreChoix[$j];
            
        }
*/
        
        
                $nbOeuvres = (count($tabOeuvreChoix))/3;
                $alea = array();
                // choix aléatoire des oeuvres SI il y en a plus de 6
                if ($nbOeuvres < 6)
                {

                    $oeuvreLitt = $tabOeuvreChoix[0];
                    $oeuvreCine = $tabOeuvreChoix[1];
                    $oeuvreProd = $tabOeuvreChoix[2];
                            
                    $idLitt = $tabOeuvreChoix[0]["id"];
                    $idCine = $tabOeuvreChoix[1]["id"];
                    $idLitt = $tabOeuvreChoix[2]["id"];
                    
                    var_dump($idCine);
                    
                            // je charge mon repository de OeuvreCine pour executer une requete sur la BD
                            $repositoryOeuvresCine = $this->getDoctrine()->getEntityManager()->getRepository('NarratioWebOeuvresBundle:OeuvreCine');
                            // j'execute la requete perso pour remplir un tableau d'oeuvre en accord avec le formulaire de page d'acceuil
                            $tabFilms = $repositoryOeuvresCine->getFilmsByOeuvreCine($idCine);
                            

                }
                else 
                {
                    $nbChoix = 6;
                    
                    //FCT DE CHOIX DES CHIFFRES ALEATOIRES
                            while (count($alea) < $nbChoix)
                            {
                                $r = mt_rand(0,$nbChoix);
                                if ( !in_array($r,$alea) ) 
                                {
                                    $alea[] = $r;
                                }
                            }
                            //var_dump($alea);
                    //
                }
        

        
        //On augmente le compteur de vues
        $compteur = $oeuvreChoisie->getCompteurVues();
        $oeuvreChoisie->setCompteurVues($compteur+1);
        $gestionnaireEntite = $this->getDoctrine()->getManager();
        $gestionnaireEntite->persist($oeuvreChoisie);
        $gestionnaireEntite->flush();
        
        // je retourne la vue avec les oeuvres a mettre en forme
        return $this->render('NarratioWebOeuvresBundle:Default:oeuvre.html.twig', array('tabOeuvreChoix'=>$tabOeuvreChoix,
                                                                                        'oeuvreChoisie'=>$oeuvreChoisie
                                                                                        ));
        
     //*/  
     
    }


}