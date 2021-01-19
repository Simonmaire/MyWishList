<?php

include_once "src/vendor/autoload.php";
error_reporting(0);

use Illuminate\Database\Capsule\Manager;
use Slim\App;
use mywishlist\controller\AffichageController;
use mywishlist\view\HomeView;
use mywishlist\view\CompteView;
use mywishlist\view\PrincipalView;
use mywishlist\controller\CreationController;
use mywishlist\controller\SessionController;

session_start();

$DB = new Manager();
$DB->addConnection(parse_ini_file("src/conf/conf.ini"));
$DB->setAsGlobal();
$DB->bootEloquent();


$app = new App(['settings' => ['displayErrorDetails' => true]]);


$app->get('/', function() {
        PrincipalView::render();
})->setName('home');


$app->get('/listes', function($request, $response, $args) {
        AffichageController::displayLiPub();
})->setName('listesPubliques');

$app->get('/listes/creation', function($request, $response, $args){
        AffichageController::displayFormCreaListe($this);
})->setName('creationListeForm');

$app->post('/listes/creation', function($request, $response, $args){
        CreationController::creationListe();
        return $response->withRedirect($this->router->pathFor('listesPubliques'),303);
})->setName('CreationListe');

$app->get('/listes/{token}', function($request, $response, $args){
        AffichageController::displayListeToken($args['token']);
})->setName('listeToken'); 

$app->get('/items', function($request, $response, $args) {
        AffichageController::displayAllItem($this);
})->setName('ItemAll');

$app->get('/listes/{token}/creationItem', function($request, $response, $args){
        AffichageController::displayFormCreaItem($args['token']);
})->setName('ajoutItemListget');

$app->post('/listes/{token}/creationItem', function($request, $response, $args){
        CreationController::creationItem($args['token']);
        return $response->withRedirect($this->router->pathFor('mesListes'),303);
})->setName('ajoutItemListpost');

$app->get('/compte/creerCompte',function($request, $response, $args){
        AffichageController::displayFormCreaCompte($this);
})->setname('creerCompteget');


$app->post('/compte/creerCompte',function($request, $response, $args){
        CreationController::creationCompte();
        return $response->withRedirect($this->router->pathFor('compteConnexionget'),303);
})->setname('creerComptepost');

$app->get('/compte',function($request, $response, $args){
        AffichageController::displayCompte($this);
})->setname('affCompte');

$app->get('/items/{id}/supprimer', function($request, $response, $args){
        CreationController::supprimerItem($args['id']);
        return $response->withRedirect($this->router->pathFor('mesListes'),303);
})->setName('supprimerItem');

$app->get('/listes/{id}/publicprive', function($request, $response, $args){
        CreationController::switchPublicPrivate($args['id']);
        return $response->withRedirect($this->router->pathFor('mesListes'),303);
})->setName('publicpriveItem');


$app->get('/listes/{id}/supprimer', function($request, $response, $args){
        CreationController::killListe($args['id']);
        return $response->withRedirect($this->router->pathFor('mesListes'),303);
})->setName('supprimerListe');

$app->get('/compte/supprimer', function($request, $response, $args){
        CreationController::killCompte();
        return $response->withRedirect($this->router->pathFor('home'),303);
})->setName('supprimerCompte');

$app->get('/compte/connexion',function($request, $response, $args){
        AffichageController::displayFormConnexion($request);
})->setname('compteConnexionget');

$app->post('/compte/connexion',function($request, $response, $args){
        CreationController::connexionCompte();
        return $response->withRedirect($this->router->pathFor('affCompte'),303);
})->setname('compteConnexionPost');

$app->get('/compte/modifier',function($request, $response, $args){
        AffichageController::displayModifCompte($this);
})->setname('compteModifierget');

$app->post('/compte/modifier',function($request, $response, $args){
        CreationController::modifierCompte();
        return $response->withRedirect($this->router->pathFor('affCompte'),303);
})->setname('compteModifierget');

$app->get('/list/meslistes', function($request, $response, $args){
        AffichageController::displayMesListess($this);
})->setName('mesListes');

$app->get('/compte/deconnexion', function($request, $response, $args){
        CreationController::deconnectionCompte();
        return $response->withRedirect($this->router->pathFor('affCompte'),303);
})->setName('deconnexion');

$app->get('/items/{id}', function($request, $response, $args){
        AffichageCOntroller::displayItem($args['id']);
})->setName('displayItem');

$app->get('/listes/{token}/modification', function($request, $response, $args){
        AffichageController::displayModifListe($args['token']);
})->setName('listeModifget');

$app->post('/listes/{token}/modification', function($request, $response, $args){
        CreationController::modificationListe($args['token']);
        return $response->withRedirect($this->router->pathFor('mesListes'),303);
})->setName('listeModifPost');

$app->run();