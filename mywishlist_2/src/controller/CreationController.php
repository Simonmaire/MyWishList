<?php

namespace mywishlist\controller;
use mywishlist\model\Listes;
use mywishlist\model\Items;
use mywishlist\model\Client;
use mywishlist\model\MessageListe;
use mywishlist\model\Reservation;
use mywishlist\view\ListeView;
use mywishlist\controller\randomID;
use mywishlist\controller\randomIDClient;
use mywishlist\view\HomeView;
use mywishlist\view\ItemView;
use mywishlist\view\CompteView;
use mywishlist\controller\SessionController;
class CreationController
{
    private static $instance;
    private function __construct(){}


    public static function getInstance()
    {
        if (!isset(self::$instance)) 
            self::$instance = new CreationController();
        return self::$instance;
    }


    public function creationListe(){
        $listeView = new ListeView();
        $isPublic = true;
       
        $val = '';
            if(SessionController::estCon()){
                $isPublic = false;
                $c=SessionController::getLoginClient();
                $val = $c->idClient;
            }


            $dateEnvoye =  filter_var($_POST['dateExpiration'], FILTER_SANITIZE_STRING);
            $dateEnr=$timeDate = strtotime($dateEnvoye);
            $dateMini = strtotime('now');

            $token = random_bytes(55);
            $token = bin2hex($token);
          
            if($dateEnr && $dateEnr > $dateMini)
            {
               
                    $nouvelleListe = new Listes();
                    $nouvelleListe->titre = filter_var($_POST['titre'],FILTER_SANITIZE_STRING);
                    $nouvelleListe->description = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
                    $nouvelleListe->expiration= $dateEnvoye;
                    $nouvelleListe->token= $token;
                    $nouvelleListe->user_id = $val;
                    $nouvelleListe->public=$isPublic;
         
            }
          
        
            if($nouvelleListe->save()){
                
            }
    
    }

    public function creationItem($token){
        $ItemView = new ItemView();
        $listeID = Listes::select('no')->where('token','=',$token)->first();
            if($token)
            {
         
                if (($_FILES['itemImg']['name']!="")){
                    // Where the file is going to be stored
                    $target_dir = "./img/";
                    $file = $_FILES['itemImg']['name'];
                    $path = pathinfo($file);
                    $filename = $path['filename'];
                    $ext = $path['extension'];
                    $temp_name = $_FILES['itemImg']['tmp_name'];
                    $path_filename_ext = $target_dir.$filename.".".$ext;
            
                    // Check if file already exists
                    if (file_exists($path_filename_ext)) {
                        echo "Sorry, file already exists.";
                    }else{
                       move_uploaded_file($temp_name,$path_filename_ext);
                       echo "Congratulations! File Uploaded Successfully.";
                   }
                }
            
                    $nouvelItem = new Items();
                    $nouvelItem->nom = filter_var($_POST['nomItem'], FILTER_SANITIZE_STRING);
                    $nouvelItem->liste_id = $listeID->no;
                    $nouvelItem->descr = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
                    $nouvelItem->tarif = filter_var($_POST['tarifItem'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $nouvelItem->img = $_FILES["itemImg"]["name"];

            }
           
        
            /* Si ca fonctionne on redirige vers la liste grace au token*/
            if($nouvelItem->save()){
             
            }
    
    }


    public function creationCompte(){
        $listeView = new CompteView();
        $token = random_bytes(10);
        $token = bin2hex($token);
        
        $mdp = filter_var($_POST['mdp'], FILTER_SANITIZE_STRING);
        $mdpverif = filter_var($_POST['mdpverif'], FILTER_SANITIZE_STRING);

            if($mdp && $mdp == $mdpverif)
            {
                $nouveauCompte = new Client();
                $nouveauCompte->idClient = $token;
                $nouveauCompte->nomClient = filter_var($_POST['nom'], FILTER_SANITIZE_STRING); 
                $nouveauCompte->prenomClient = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING); 
                $nouveauCompte->loginClient = filter_var($_POST['pseudo'], FILTER_SANITIZE_STRING); 
                $nouveauCompte->mdpClient = password_hash($mdp, PASSWORD_DEFAULT); 
                $nouveauCompte->admin = false; 
            }
          
        
            /* Si ca fonctionne on redirige vers la liste grace au token*/
            if($nouveauCompte->save()){
                echo "<h2>Compte crée</h2>";
            }
    
    }


    public function connexionCompte(){
        
        if(isset($_SESSION['estConnecte'])&&$_SESSION['estConnecte']==true){
            echo "<h2>Vous etes deja connecte</h2>";
           
            exit();
        }

        $listeView = new CompteView();
        $log = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
        $client = Client::where('loginClient','=',$log)->first();
        $idclient=Client::select('idClient')->where('loginClient','=',$log)->first();
        $con = true;
        if($client){
            $mdp = filter_var($_POST['mdp'], FILTER_SANITIZE_STRING);
            $hashed_password=$client->mdpClient;
            $hashed_password = substr( $hashed_password, 0, 60 );
            if($mdp && password_verify($mdp, $hashed_password)){
                $_SESSION['login'] = $log;
                $_SESSION['pwd'] = $mdp;
                $_SESSION['idc'] = $idclient;
                $_SESSION['estConnecte'] = $con;
                
                echo "<h2>Bienvenue $client->loginClient</h2>";
              
            }
            else
            {
                echo "<h2>MAUVAIS LOGIN OU PASSWORD</h2>";
            }
        }
        else
        {
            echo "<h2>MAUVAIS LOGIN OU PASSWORD</h2>";
        }
    }


    public function deconnectionCompte(){
        session_destroy();
        echo "<h2>A bientot</h2>";
      
    }

    public function switchPublicPrivate($idliste){
        $liste = Listes::where('no','=',$idliste)->first();
        $usr = SessionController::getLoginClient();
        $idusrListe= $liste->user_id;
        $idUsrSess = $usr->idClient;

        if($idusrListe == $idUsrSess){
            if($liste->public == false){
                $liste->public = true;
            }
            else
            {
                $liste->public = false;
            }
          
            $liste->update();
            echo "<h2>Mise a jour de l'état de privatisation de la liste</h2>";
         
        }

        
    }


    public function killListe($idlis){
        $liste = Listes::where('no','=',$idlis)->first();
        $usr = SessionController::getLoginClient();
        $idusrListe= $liste->user_id;
        $idUsrSess = $usr->idClient;

        if($idusrListe == $idUsrSess){
            $liste->delete();
            echo "<h2>Liste Supprimee</h2>";
           
        }
        else{
            echo "<h2>Vous n etes pas le createur</h2>";
        }
    }

    public function killCompte(){
        if(SessionController::estCon()){
        $idClt = SessionController::getLoginClient();
        $idC = $idClt->idClient;
        $c = Client::where('idClient','=',$idC)->first();

             $c->delete();
             SessionController::destroy();
             
            echo "<h2>Compte Supprimé</h2>";
           
        }
        else
        {
            echo "<h2>Veuillez vous connecter</h2>";
        }
    }

    public function supprimerImageItem($idItm){
        $Item = Items::where('id','=',$idItm)->first();
        $liste = Listes::where('no','=',$Item->liste_id)->first();
        $c = Client::where('idClient','=',$liste->user_id)->first();
        $usr = SessionController::getLoginClient();
        
        if( $c->idClient){
            $idusrItm=$c->idClient;
        $idUsrSess = $usr->idClient;
        
        if($idusrItm == $idUsrSess){
         
            $Item->img = '';
            $Item->update();
         
           
            echo "<h2>Image supprimée</h2>";
        }
    }else
    {
        echo "<h2>Pas possible de supprimer l image</h2>";
    }
    
    }


    public function modificationListe($lisID){
        $liste = Listes::where('token','=',$lisID)->first();
        $c = Client::where('idClient','=',$liste->user_id)->first();
        $usr = SessionController::getLoginClient();
        
        if( $c->idClient){
            $idusrItm=$c->idClient;
        $idUsrSess = $usr->idClient;

        if($idusrItm == $idUsrSess){
            $newN = filter_var($_POST['newtitre'],FILTER_SANITIZE_STRING);
            $newD = filter_var($_POST['newdescription'],FILTER_SANITIZE_STRING);
            $newE = filter_var($_POST['newdateExpiration'],FILTER_SANITIZE_STRING);
           
            if($newN != '' ){
                $liste->titre = $newN;
            }
            if($newD != '' ){
                $liste->description = $newD;
            }
            if($newE != '' ){
                $liste->expiration = $newE;
            }
            if($liste->update()){
                echo "<h2>Item Mis a jour</h2>";
            }

        }
        else
        {
            echo "<h2>Vous n etes pas le proprietaire</h2>";
        }
        }
        else
        {
            echo "<h2>Pas possible de le modifier</h2>";
        }
    }

    public function supprimerItem($idItm){
        $Item = Items::where('id','=',$idItm)->first();
        $liste = Listes::where('no','=',$Item->liste_id)->first();
        $c = Client::where('idClient','=',$liste->user_id)->first();
        $usr = SessionController::getLoginClient();
        
        if( $c->idClient){
            $idusrItm=$c->idClient;
        $idUsrSess = $usr->idClient;

        if($idusrItm == $idUsrSess){
            $Item->delete();
         
            echo "<h2>Item supprimé</h2>";
        }
    }else
    {
        echo "<h2>Pas possible de le supprimer</h2>";
    }
    }


    public function ajoutImages($idItm){
        
        $itm = Items::where('id','=', $idItm)->first();
            if(SessionController::estCon()){
                if (($_FILES['itemImg']['name']!="")){
                    $target_dir = "./img/";
                    $file = $_FILES['itemImg']['name'];
                    $path = pathinfo($file);
                    $filename = $path['filename'];
                    $ext = $path['extension'];
                    $temp_name = $_FILES['itemImg']['tmp_name'];
                    $path_filename_ext = $target_dir.$filename.".".$ext;
            
                    if (file_exists($path_filename_ext)) {
                        echo "Le fichier n a pas ete envoyer car deja dans la BDD";
                    }else{
                       move_uploaded_file($temp_name,$path_filename_ext);
                       echo "Congratulations! File Uploaded Successfully.";
                   }
                }
                    $itm->img= $_FILES['itemImg']['name'];
            
         
            }
          
           
            /* Si ca fonctionne on redirige vers la liste grace au token*/
            if($itm->update()){
                echo "<h2>Image Mise a jour</h2>";
                
            }
       
    }

    public function modifierCompte(){
       
  
            if(SessionController::estCon())
            {
                $idsess = SessionController::getLoginClient();
                $idC = $idsess->idClient;
                
                $Compte = Client::where('idClient','=',$idC)->first();
        
                $mdp = filter_var($_POST['mdp'], FILTER_SANITIZE_STRING);
                $mdpverif = filter_var($_POST['mdpverif'], FILTER_SANITIZE_STRING);
                $newNom =filter_var($_POST['nom'], FILTER_SANITIZE_STRING); 
                $newPrenom = filter_var($_POST['prenom'], FILTER_SANITIZE_STRING); 


                if($newNom != '' ){
                    $Compte->nomClient = $newNom;
                }
                if($newPrenom != '' ){
                    $Compte->prenomCLient = $newPrenom;
                }
                if($mdp != '' && $mdpverif != ''){
                    if($mdp == $mdpverif){
                        $Compte->mdpClient = password_hash($mdp, PASSWORD_DEFAULT); 
                        SessionController::destroy();
                    }
                }
                   
            if($Compte->update()){
                echo "<h2>Compte Modifié</h2>";
   
            }
            }  
    }
}