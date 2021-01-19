<?php

namespace mywishlist\view;
require_once 'src/vendor/autoload.php';
use mywishlist\controller\SessionController;


class CompteView extends GeneralView {
        function __construct() { parent::__construct();
        }

        public function renderCompteForm() {

            $contenu =  "<main> <form method='post'>   
                <div>
                    Nom : <input type='text' name='nom' placeholder='Nom' />
                </div>
                <div>
                    Prenom : <input type='text' name='prenom' placeholder='Prenom' />
                </div>
                <div>
                    Pseudo : <input type='text' name='pseudo' placeholder='Pseudo' />
                </div>
                <div>
                    Mot de passe : <input type='password' name='mdp' placeholder='Mot de passe' />
                </div>
                <div>
                    Mot de passe : <input type='password' name='mdpverif' placeholder='Mot de passe' />
                </div>
                <div>
                    <input type='submit' value='Créer son compte' />
                </div>
            </form></main>";
      
         
            $contenu = str_replace("\n", "\n  ", $contenu);
            $this->addcontent($contenu);
            parent::render();
          }


          public function renderCompteConnexion() {
              $contenu = "<main>
 
              <form  method='post'>    
                  <div>
                      Login : <input type='text' name='login' placeholder='Pseudo' />
                  </div>
                  <div>
                      Mot de Passe : <input type='password' name='mdp' placeholder='Mot de passe' />
                  </div>
                  <div>
                  <input type='submit' value='Connexion' />
                  </div>
              </form></main>";

            $contenu = str_replace("\n", "\n  ", $contenu);
            $this->addcontent($contenu);
            parent::render();
          }

        public function renderCompteOptions(){
            $contenu = "<main><form>";
            if(!SessionController::estCon()){

           $contenu.=" <button style='height:35px;width:255px;'><a href='/mywishlist_2/compte/connexion'>Se connecter</a></button> ";
           $contenu.=" <button style='height:35px;width:255px;'><a href='/mywishlist_2/compte/creerCompte'>Créer son Compte</a></button>";
            }
            else
            {
           
             $contenu.="  <button style='height:35px;width:255px;'><a href='/mywishlist_2/list/meslistes'>Mes listes personnelles</a></button>";
             $contenu.="  <button style='height:35px;width:255px;'><a href='/mywishlist_2/compte/modifier'>Modifier mon compte</a></button>";
             $contenu.="  <button style='height:35px;width:255px;'><a href='/mywishlist_2/compte/deconnexion'>Se déconnecter</a></button>";
             $contenu.="  <button style='height:35px;width:255px;'><a href='/mywishlist_2/compte/supprimer'>Supprimer mon compte</a></button>";
            }            
            
           $contenu.="</form>
          </main>";

          $contenu = str_replace("\n", "\n  ", $contenu);
          $this->addcontent($contenu);
          parent::render();
        }


        public function renderModifCompte(){
            $contenu =  "<main>
 
            <form method='post' >    
                <div>
                    Nom (optionnel): <input type='text' name='nom' placeholder='Nouveau nom' />
                </div>
                <div>
                    Prénom (optionnel): <input type='text' name='prenom' placeholder='Nouveau prénom' />
                </div>
                <div>
                    Mot de passe (optionnel) : <input type='password' name='mdp' placeholder='Nouveau mot de passe' />
                </div>
                <div>
                        Mot de passe (optionnel): <input type='password' name='mdpverif' placeholder='Nouveau mot de passe' />
                </div>
                <div>
                <input type='submit' value='Modifier mon compte' />
                </div>
            </form></main>";
      

          $contenu = str_replace("\n", "\n  ", $contenu);
          $this->addcontent($contenu);
          parent::render();
        }
    }