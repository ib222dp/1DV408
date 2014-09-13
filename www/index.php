<?php
use LoginController as Ctrl;

session_start();

require_once("controllers/LoginController.php");

//sv_SE.UTF-8 funkar inte lokalt. sv och Swedish funkar, men kodningen blir fel.
//Överallt verkar standarden språkkod_LANDSKOD.kodning gälla så jag kör på den. Har testat online på servern och det funkar där.
setlocale(LC_TIME, 'sv_SE.UTF-8');

$loginCtrl = new Ctrl\LoginController();
