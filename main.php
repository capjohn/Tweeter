<?php
session_start();
require_once 'vendor/autoload.php';
require_once 'src/mf/utils/AbstractClassLoader.php';
require_once 'src/mf/utils/ClassLoader.php';

//Fichier de configuration pour se connecter à la BDD
$config = parse_ini_file('conf/config.ini');

$load = new \mf\utils\ClassLoader('src');
$load->register();

use tweeterapp\model\Tweet;
use tweeterapp\model\User;
use tweeterapp\model\Like;
use tweeterapp\model\Follow;
use \mf\router\Router;
$db = new Illuminate\Database\Capsule\Manager();
$db->addConnection( $config ); /* configuration avec nos paramètres */
$db->setAsGlobal();            /* rendre la connexion visible dans tout le projet */
$db->bootEloquent();           /* établir la connexion */

use \tweeterapp\view\TweeterView as Vue;
Vue::addStyleSheet('html/style.css'); // Donne le lien du fichier css à la méthode présente dans AbstractView

$ctrl = new tweeterapp\control\TweeterController();

/* Création des différents router entre url,controleur, vue et niveau de droit d'accès */
$router = new \mf\router\Router();
$router->addRoute('home',
                  '/home/',
                  '\tweeterapp\control\TweeterController',
                  'viewHome',
                    \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);
$router->addRoute('view',
                  '/view/',
                  '\tweeterapp\control\TweeterController',
                  'viewTweet',
                  \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('user',
                  '/user/',
                  '\tweeterapp\control\TweeterController',
                  'viewUserTweets',
                  \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);
                  
$router->addRoute('post',
                  '/post/',
                  '\tweeterapp\control\TweeterController',
                  'viewPost',
                  \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_USER);
                  
$router->addRoute('send',
                  '/send/',
                  '\tweeterapp\control\TweeterController',
                  'viewSend',
                  \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_USER);

$router->addRoute('login',
                  '/login/',
                  '\tweeterapp\control\TweeterAdminController',
                  'login',
                  \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('checklogin',
                  '/check_login/',
                  '\tweeterapp\control\TweeterAdminController',
                  'checkLogin',
                  \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('logout',
                  '/logout/',
                  '\tweeterapp\control\TweeterAdminController',
                  'logout',
                  \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_USER);

$router->addRoute('checksignup',
                  '/checksignup/',
                  '\tweeterapp\control\TweeterAdminController',
                  'checksignup',
                  \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);

$router->addRoute('signup',
                  '/signup/',
                  '\tweeterapp\control\TweeterAdminController',
                  'signup',
                  \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_NONE);
         
$router->addRoute('perso',
                  '/PagePersonnelle/',
                  '\tweeterapp\control\TweeterController',
                  'viewPerso',
                  \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_USER);

$router->addRoute('like',
                  '/like/',
                  '\tweeterapp\control\TweeterController',
                  'viewLike',
                  \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_USER);               
                  
$router->addRoute('follow',
                  '/follow/',
                  '\tweeterapp\control\TweeterController',
                  'viewFollow',
                  \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_USER);             
                  
$router->addRoute('tableau',
                  '/tableau/',
                  '\tweeterapp\control\TweeterAdminController',
                  'tableau',
                  \tweeterapp\auth\TweeterAuthentification::ACCESS_LEVEL_ADMIN);
                                
$router->setDefaultRoute('/home/');
$router->run();
