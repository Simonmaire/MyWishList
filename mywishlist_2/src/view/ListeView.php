<?php

namespace mywishlist\view;
require_once 'src/vendor/autoload.php';
use mywishlist\model\Listes;
use mywishlist\model\Items;
use mywishlist\controller\AffichageController;
use mywishlist\controller\CreationController;
use mywishlist\controller\SessionController;
use Slim\App;

class ListeView extends GeneralView {

    function __construct() {
        parent::__construct();
    }

    function renderLpub($liste, $proprio) {
		
        $content = "<main><section>";

        if(count($liste)==0){ $content.="<h2>Aucune liste publique trouvée</h2>";
            }else{
                $content.= "<div class='un'>";
                $content.="<h2 class='h2_1'>Liste des wishlist publique</h2><ul>";

                    foreach($liste as $l) {
                        $content.= "<div class='BannerMC'>";
                            if(strtotime($l->expiration)-time()>0) {
                                $date = ucwords(strftime('%d %B %Y', strtotime($l->expiration)));
                                $url = $content .= 
                                "<li class='li1'> 
                                <a href='/mywishlist_2/listes/$l->token' style='color:red'> $l->titre </a>
                                <a><br></a>
                                 <span class=\"listeDateExpiration\"> Expire le : $date  </span> </li>\n";
                            }
                         $content.= "</div>";
                    }
                $content.= "</div>";
            }
		
        $content .= "<button><a href='/mywishlist_2/listes/creation'>Créer ma liste</a></button></section></main>";
        $content = str_replace("\n", "\n  ", $content);
        $this->addContent($content);
        parent::render();
    }



    function renderListeForm()
    {
        $tableau="<main>
 
        <form  method='POST'>
            <div>
                Titre : <input type='text' name='titre' placeholder='Entrez le titre' />
            </div>

            <div>
                Description : <input type='text' name='description' placeholder='Entrez la description' />
            </div>

            <div>
                Date d'expiration de la liste : <input type='date' name='dateExpiration' placeholder='Entrez une date d expiration' />
            </div>

            <div>
            <input type='submit' value='Créer la liste' />
            </div>
        </form>
        </main>";

    $tableau = str_replace("\n", "\n  ", $tableau)."\n";
    $this->addContent($tableau);
    parent::render();
    }


    function renderListeToken($listeToken){// render d'une liste en particulier
        if($listeToken){
            $isPP = "privée";
            $content='';
            $itm='';
            if($listeToken->public == 1){
                $isPP = "publique";
            }
            $content .= "<main><section><div><h2> $listeToken->titre </h2>";
            $content .= "<p> $listeToken->description </p>";
            $content .= "<h3>La liste est $isPP</h3>";
            $content .= "</br><p>Cette liste est composée des items suivants:</p></br><ul>";
            if($listeToken){
            $content.= "<div class='un'>";
      
            foreach($listeToken->items as $itm){
            $content .= "<h2><a href='/mywishlist_2/items/$itm->id'>$itm->nom</a></h2>";
            $content .= "<img src='/mywishlist_2/img/$itm->img' style='width:100px'>";
            $content .= "<h3>$itm->descr</h3>";
            $content .= "<h3>$itm->tarif</h3>";
           
            }
            $content.= "</div>";
        }

            $idlis = $listeToken->no;
            $content.= "</ul></div></section></main>";
            if(SessionController::estCon()){
                if(strtotime($listeToken->expiration)-time()>0)
                {
                $content .=" <form class='f2'><button style='height:35px;width:255px; '><a href='/mywishlist_2/listes/$listeToken->no/publicprive'>Private/Public</a></button>";
                $content.="<button style='height:35px;width:255px;'><a href='/mywishlist_2/listes/$listeToken->token/creationItem'>Ajouter un item</a></button>";
                $content.="<button style='height:35px;width:255px;'><a href='/mywishlist_2/listes/$listeToken->token/modification'>Modifier la liste</a></button>";
                $content .="<button style='height:35px;width:255px;'><a href='/mywishlist_2/listes/$listeToken->no/supprimer'>Supprimer la liste</a></button>";

                $content.="</form><br/><br/></div></li>";
                }
            }
        }
        else{
            $content = "<h2>Aucune liste trouvée pour toi</h2>";
        }
       
        $content = str_replace ("\n", "\n  ", $content);
        $this->addContent($content);
        parent::render();
    }





    public function renderMesListes($MesListes){
        $content = "<main><section>";
        if(isset($_SESSION['login']) && $_SESSION['estConnecte'] == true)
        
        {
            
            if($MesListes){
               
                    $content.= "<div class='un'>";
                    $content.="<h2>Mes listes crées</h2><ul>";
                    foreach($MesListes as $l)
                    {
                        $i=0;
                        $content.= "<div class='BannerMC'>";
                        if(strtotime($l->expiration)-time()>0)
                        {
                         
                          $date = ucwords(strftime('%d %B %Y', strtotime($l->expiration)));
                            $param =$l->no;
                            
                            if($l->public == 0){
                                $p = "privée";
                            }
                            else
                            {
                                $p = "publique";
                            }

                            $content .= "<li>
                            <a href='/mywishlist_2/listes/$l->token' style='color:red'> $l->titre</a>
                            <a><br></a> 
                            <span class=\"listeDateExpiration\"> Expire le : $date  </span>
                            <a> | </a>
                            <a>$p</a>
                            </li>";
                        }
            
                        $content.= "</div>";
                        $i++;
                    }
                    $content.= "</div></section>";
                

                    $content.= "<div class='un'>";
                    $content.="<h2>Mes listes avec une date passée</h2><ul>";
                    foreach($MesListes as $l)
                    {
                        $i=0;
                        $content.= "<div class='BannerMC'>";
                        if(strtotime($l->expiration)-time()<0)
                        {
                         
                          $date = ucwords(strftime('%d %B %Y', strtotime($l->expiration)));
                            $param =$l->no;
                            
                            if($l->public == 0){
                                $p = "privée";
                            }
                            else
                            {
                                $p = "publique";
                            }

                            $content .= "<li>
                            <a href='/mywishlist_2/listes/$l->token' style='color:red'> $l->titre </a>
                            <a><br></a>
                          <span class=\"listeDateExpiration\"> A Expire le : $date  </span><a> | </a><a>$p</a></li>";
                        }
            
                        $content.= "</div>";
                        $i++;
                    }
                    $content.= "</div>";

                $content .= "</section></main>";
             
            }
            else
            {
                $content.="<h2>Aucune liste publique trouvée</h2>";
            }
        }
        else
        {
            $content.="<h2>Veuillez vous connecter pour accèder à cette page</h2>";
        }
        $content = str_replace("\n", "\n  ", $content);
        $this->addContent($content);
        parent::render();
    }

    public function renderModifListe($idtoken){//ok
        $tableau="<main>
 
        <form  method='POST'>
            <div>
                Titre : <input type='text' name='newtitre' placeholder='Entrez le nouveau Titre' />
            </div>

            <div>
                description : <input type='text' name='newdescription' placeholder='Entrez la nouvelle description' />
            </div>

            <div>
                date d'expiration : <input type='date' name='newdateExpiration' placeholder='Entrez une nouvelle date d éxpiration' />
            </div>

            <div>
                <input type='submit' value='Modifier la liste' />
            </div>
        </form>
        </main>";

    $tableau = str_replace("\n", "\n  ", $tableau)."\n";
    $this->addContent($tableau);
    parent::render();
    }

}


