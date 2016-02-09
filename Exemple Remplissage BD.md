/* structure générale remplissage BDD */
        
        $oeuvreTEST = new Oeuvre();
        $oeuvreTEST -> setNom()
                    -> setResume()
                    -> setEpoque()
                    -> setGenre()
                    -> setThematique()
                    -> setTrancheAge();
        $manager->persist($oeuvreTEST);
        
        $oeuvreLittTEST = new OeuvreLitt();
        $manager->persist($oeuvreLittTEST);
        
        $EditeurTEST = new Editeur();
        $EditeurTEST -> setNom();
        $manager->persist($EditeurTEST);
                    
        $AuteurTEST = new Auteur();
        $AuteurTEST -> setNom()
                    -> setPrenom();
        $manager->persist($AuteurTEST);
        
        $LivreTEST = new Livre();
        $LivreTEST -> setTitre()
                   -> addAuteur($AuteurTEST)
                   -> setEditeur($EditeurTEST)
                   -> setOeuvreLitt($oeuvreLittTEST);
        $manager->persist($LivreTEST);
        
        $OeuvreCinéTEST = new OeuvreCine();
        $manager->persist($OeuvreCiné);
        
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
        
        $FilmTEST = new Film();
        $FilmTEST -> setTitre()
                  -> setDuree()
                  -> setType($TypeTEST)
                  -> setRealisateur($RéalisateurTEST)
                  -> addActeur($ActeurTEST)
                  -> setOeuvreCine($OeuvreCinéTEST);
        $manager->persist($FilmTEST);
        
        $ProduitDerTEST = new ProduitDer();
        $ProduitDerTEST -> setDescription()
                        -> setOeuvre($oeuvreTEST);
        $manager->persist($ProduitDerTEST);
        
        $ImageTEST = new Image();
        $ImageTEST -> setUrl()
                -> setOeuvre($oeuvreTEST)
                -> setProduit($ProduitDerTEST);
        $manager->persist($ImageTEST);