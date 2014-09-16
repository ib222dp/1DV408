<?php
namespace LoginApp;
?>

<!DOCTYPE html>

<?php
use LoginApp\Controller as Ctrl;

session_start();

require_once("controllers/login-controller.php");

setlocale(LC_TIME, 'sv_SE.UTF-8'); //problems on localhost but works on the server.

$loginCtrl = new Ctrl\LoginController();
$loginCtrl->start();
