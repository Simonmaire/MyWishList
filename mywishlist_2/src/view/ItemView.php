<?php

namespace mywishlist\view;
require_once 'src/vendor/autoload.php';
use mywishlist\model\Listes;
use mywishlist\model\Items;
use mywishlist\controller\SessionController;
use mywishlist\controller\CreationController;

class ItemView extends GeneralView {

        function __construct() { parent::__construct();}

        function renderItemID($setItem){//vue d'un item particulier dans une liste
            if($setItem){
                $content = "<main><section><div class='un'><h2> $setItem->nom </h2>";
                $content .= "<img src='/mywishlist_2/img/$setItem->img' style='width:200px;'>"; 
                $content .= "<p> $setItem->descr </p>";
                $content .= "<p> $rev </p>";
                $content .= "<p> $setItem->tarif euros</p>";
                

                if(SessionController::estCon()){
                    
                $content .=" <button style='height:35px;width:255px;'><a href='/mywishlist_2/items/$setItem->id/supprimer'>Supprimer cet item</a></button>";
                       
                    
                }
               $content.=" </div></section></main>";
            }
            $content = str_replace ("\n", "\n  ", $content);
            $this->addContent($content);
            parent::render();
        }
        
        function renderAllItems($item){
            $content = "<main><section>";
            if($item){ 
                $content.= "<div class='un'>";
                $content.="<h1>Liste des items dans la base</h1>";

                    foreach($item as $itm){
                        $content .= "<h2>$itm->nom</h2>";
                        $content .= "<img src='/mywishlist_2/img/$itm->img' style='width:200px'>";
                        $content .= "<h3>$itm->descr</h3>";
                        $content .= "<h3>$itm->tarif</h3>";
                    }
               
                $content.= "</div>";

            }else{
                $content = "<h2>Pas d'items</h2>";
            }

                $content .= "</section></main>";
                $content = str_replace("\n", "\n  ", $content);
                $this->addContent($content);
                parent::render();
        }

        function renderItemForm($liste){
            $tableau="<main>
 
        <form  method='POST' enctype='multipart/form-data'>

            <div>
                Nom : <input type='text' name='nomItem' placeholder='Entrez le nom' />
            </div>

            <div>
                Description : <input type='text' name='description' placeholder='Entrez la description' />
            </div>

            <div>
                 Tarif : <input type='text' name='tarifItem' placeholder='Entrez un tarif' />
            </div>

            <div>
                Image : <input type='file' name='itemImg'>
            </div>

            <div>
                <input type='submit' value='Ajouter l item' />
            </div>
        </form>
        </main>";

            $tableau = str_replace("\n", "\n  ", $tableau)."\n";
            $this->addContent($tableau);
            parent::render();
        }
}