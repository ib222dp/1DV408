<?php
require_once("views/HomeView.php");

session_start();

//sv_SE.UTF-8 funkar inte lokalt. sv och Swedish funkar, men kodningen blir fel.
//Överallt verkar standarden språkkod_LANDSKOD.kodning gälla så jag kör på den. Har testat online på servern och det funkar där.
setlocale(LC_TIME, 'sv_SE.UTF-8');

//if ($_POST) echo "this was a post";

$homeView = new HomeView();

$homeView->renderPage();

//echo var_dump($_POST);
//phpinfo();