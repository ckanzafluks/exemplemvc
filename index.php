<?php 
error_reporting( E_ALL );
ini_set('display_errors', 1);

// Definition du chemin absolu
define("ABSOLUTE_PATH", dirname(__FILE__));

// Chargement des librairies via composer
require ABSOLUTE_PATH. '/vendor/autoload.php';

require ABSOLUTE_PATH. '/autoloader.php';

// Inclusion de notre controleur
require ABSOLUTE_PATH. '/controleur/controleur.php';

// Instanciation de twig et chargement des templates
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, ['cache' => false,'debug'=>true]); // Desactivation du cache, inutile pour le moment
$twig->addExtension(new Twig_Extension_Debug);


if (isset($_GET['action'])) {
   
    if ( $_GET['action'] == 'contactForm' ) {
        displayContactForm($twig);
    }
    else if ( $_GET['action'] == 'home' ) {
        displayHomePage($twig); // WPCS: XSS OK
    }

}
// Page d'accueil
else {
    displayHomePage($twig); // WPCS: XSS OK
}