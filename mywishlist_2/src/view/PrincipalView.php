<?php
namespace mywishlist\view;

  class PrincipalView extends GeneralView {

    function __construct() {
      parent::__construct();
    }

    /**
     *Génère le contenu HTML pour afficher la page d'accueil
     */
    function render() {
        $content = " <div id='TestBanner'></div>";

        parent::addContent($content);
        parent::render();
    }
 }
