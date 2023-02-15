<?php
session_start();

define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('VIEW_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);

require_once ROOT_PATH . 'src/controller.php';
require_once ROOT_PATH . 'src/template.php';
require_once ROOT_PATH . 'src/DatabaseConnection.php';
require_once ROOT_PATH . 'src/Router.php';
require_once ROOT_PATH . 'src/Entity.php';
require_once ROOT_PATH . 'model/Page.php';

//removes warnings from the output
error_reporting(E_ALL ^ E_WARNING); 

//DataBase Connection
DatabaseConnection::connect('localhost', 'darwin_cms', 'root', '');


//$section = $_GET['section'] ?? $_POST['action'] ?? 'home';
//$action = $_GET['action'] ?? $_POST['action'] ?? 'default';


$action = $_GET['page'] ?? 'home';



$dbh = DatabaseConnection::getInstance();
$dbc = $dbh->getConnection();

$router = new Router($dbc);
$router->findBy('pretty_url', $action);

$action = $router->action != '' ? $router->action : 'default';


if ($router->module == 'page') {
  include ROOT_PATH . 'controller/aboutUsPage.php';
  $aboutController = new AboutUsController();
  $aboutController ->runAction($action);
} elseif ($section == 'contact-us') {

  include ROOT_PATH . 'controller/contactPage.php';
  $contactController = new ContactController();
  $contactController->runAction($action);
  
}

else {
  include 'controller/homePage.php';
  $homePageController = new HomePageController();
  $homePageController->runAction($action);
}


