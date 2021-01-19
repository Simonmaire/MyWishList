<?php

namespace mywishlist\view;

class GeneralView 
{
   

    function __construct() {
        if (!isset($_SESSION['vuegenerale']))
          $_SESSION['vuegenerale'] = '';
      }
    
    public function render() {

        $_SESSION['vuegenerale'] ;

        // affichage de la page
        include('src/view/html/index.php');
    
        // reset sur affichage prochaine page
        $_SESSION['vuegenerale'] = "";
      }



      public function addContent($content) {
        $_SESSION['vuegenerale'] .= $content . "\r\n";
      }
 

      public static function getContent() {
        if (isset($_SESSION['vuegenerale']))
          return $_SESSION['vuegenerale'];
        else
          return "(Pas de contenu généré)";
      }
}