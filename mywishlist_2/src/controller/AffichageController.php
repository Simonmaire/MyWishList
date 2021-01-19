<?php


namespace mywishlist\controller;
use mywishlist\model\Listes;
use mywishlist\model\Items;
use mywishlist\view\ListeView;
use mywishlist\view\ItemView;
use mywishlist\model\Client;
use mywishlist\view\CompteView;
use mywishlist\view\HomeView;
class AffichageController 
{

    private static $instance;
    private function __construct(){}


    public static function getInstance()
    {
        if (!isset(self::$instance)) 
            self::$instance = new AffichageController();
        return self::$instance;
    }

    public function displayHome(){
        $affichage = new HomeView();
        return $affichage->render();
    }

    public function displayLiPub()
    {
        $datedujour = new \DateTime('now');
        $datedujour = $datedujour->format('YYYY-mm-dd');
        $listespub = Listes::where('public', '=', true)->where('expiration', '>', $datedujour)->orderBy('expiration', 'ASC')->get();
        $affichage = new ListeView();
        return $affichage->renderLpub($listespub, false);
    }

    public function displayItem($id){ 
        $itm = Items::where('id','=',$id)->first();
        $affichage = new ItemView();
        return $affichage->renderItemID($itm);
    }


    public function displayAllItem(){ 
        $itm = Items::orderBy('tarif', 'ASC')->get();
        $affichage = new ItemView();
        return $affichage->renderAllItems($itm);
    }

    public function displayFormCreaListe(){
        $affichage = new ListeView();
        return $affichage->renderListeForm();
    }
    public function displayFormCreaItem($token){ 
        $listeToken = Listes::where('token','=',$token)->first();
        if(isset($listeToken)){
            $affichage = new ItemView();
            return $affichage->renderItemForm($listeToken);
        }
    }

    public function displayFormCreaCompte(){
        $affichage = new CompteView();
        return $affichage->renderCompteForm();
    }
    public function displayFormConnexion(){ 
        $affichage = new CompteView();
        return $affichage->renderCompteConnexion();
    }

    public function displayListeToken($setToken){
        $listeToken = Listes::where('token','=', $setToken)->first();
        $affichage = new ListeView();
        return $affichage->renderListeToken($listeToken);
    }
   
    public function displayMesListess(){ 
        if(SessionController::estCon()){
        $id = SessionController::getLoginClient();
        $idc = $id->idClient;
        $listesPerso = Listes::where('user_id','=',$idc)->get();
        $affichage = new ListeView();
        return $affichage->renderMesListes($listesPerso);
        }
        else
        {
            AffichageController::displayHome();
        }
    }


    public function displayModifListe($idToken){ 
        if(SessionController::estCon()){
            $listeToken = Listes::where('token','=', $idToken)->first();
           $affichage = new ListeView();
           return $affichage->renderModifListe($listeToken);
        }
    }

    public function displayModifItem($idItm){ 
        $itm = Items::where('id','=',$idItm)->first();
        $affichage = new ItemView();
        return $affichage->renderModifItm($itm);
    }

    public function displayModifCompte(){ 
        $affichage = new CompteView();
        return $affichage->renderModifCompte();
    }

    public function displayCompte(){ 
        $affichage = new CompteView();
        return $affichage->renderCompteOptions();
    }

    

}