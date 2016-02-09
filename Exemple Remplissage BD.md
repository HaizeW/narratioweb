/* structure générale remplissage BDD */
        
        $oeuvreTEST = new Oeuvre();
        $oeuvreTEST -> setNom()
                    -> setResume();
        $manager->persist($oeuvreTEST);
        
        $oeuvreLittTEST = new OeuvreLitt();
        $manager->persist($oeuvreLittTEST);
        
        $LivreTEST = new Livre();
        $LivreTEST -> setTitre();
        $manager->persist($LivreTEST);
        
        $EditeurTEST = new Editeur();
        $EditeurTEST -> setNom();
        $manager->persist($EditeurTEST);
                    
        $AuteurTEST = new Auteur();
        $AuteurTEST -> setNom()
                    -> setPrenom();
        $manager->persist($AuteurTEST);
        
        $OeuvreCinéTEST = new OeuvreCine();
        $manager->persist($OeuvreCiné);
        
        $FilmTEST = new Film();
        $FilmTEST -> setTitre()
                  -> setDuree();
        $manager->persist($FilmTEST);
        
        $ActeurTEST = new Acteur();
        $ActeurTEST -> setNom()
                    -> setPrenom();
        $manager->persist($ActeurTEST);
        
        $RéalisateurTEST = new Realisateur();
        $RéalisateurTEST -> setNom()
                         -> setPrenom();
        $manager->persist($RéalisateurTEST);
        
        $TypeTEST = new Type();
        $TypeTEST -> setIntitule();
        $manager->persist($TypeTEST);
        
        $ImageTEST = new Image();
        $ImageTEST -> setUrl();
        $manager->persist($ImageTEST);