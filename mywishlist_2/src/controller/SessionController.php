<?php

namespace mywishlist\controller;
use mywishlist\model\Client;
class SessionController
{
    public static function estCon() {return isset($_SESSION['estConnecte']) && $_SESSION['estConnecte'] == true;} 
    private static function setCon($setBoolean) {$_SESSION['estConnecte'] = $setBoolean ? true : false;}
    public static function getLogin() {if (isset($_SESSION['login'])) return $_SESSION['login']; else return "";}
    static function getLoginClient(){ if (!isset($_SESSION['login'])) return "HELLO"; $client = Client::where('loginClient','=',$_SESSION['login'])->first();return $client;}
    public static function destroy(){if (isset($_SESSION['estConnecte'])) session_destroy();}
}