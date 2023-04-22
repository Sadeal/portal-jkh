<?php
require_once '../vendor/autoload.php';
require_once '../framework/autoload.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/RegisterController.php';
require_once '../controllers/MainController.php';
require_once '../controllers/AccountController.php';
require_once '../controllers/AccountEditController.php';
require_once '../controllers/PasswordEditController.php';
require_once "../controllers/Controller404.php";
require_once "../controllers/SubmitController.php";
require_once "../controllers/HistoryController.php";
require_once "../controllers/AddNewsController.php";
require_once "../controllers/ReviewController.php";
require_once "../controllers/NewsEditController.php";
require_once "../controllers/NewsDeleteController.php";
require_once "../controllers/AskController.php";
require_once "../controllers/AskReviewController.php";
require_once "../controllers/PolicyController.php";
require_once "../controllers/AboutController.php";
require_once "../middleware/LoginRequiredMiddleware.php";
require_once "../middleware/LoginRequiredUserMiddleware.php";
require_once "../middleware/LoginRequiredAdminMiddleware.php";

error_reporting(E_ALL ^ E_WARNING);
$loader = new \Twig\Loader\FilesystemLoader('../views');
$twig = new \Twig\Environment($loader, [
    "debug" => false
]);
session_set_cookie_params(60 * 60 * 10);
session_start();
$_SESSION['is_logged'];
$_SESSION['is_logged_admin'];
$_SESSION['account'];
$_SESSION['phone'];
$_SESSION['email'];
$_SESSION['city'];
$_SESSION['address'];
$_SESSION['name'];

$twig->addExtension(new \Twig\Extension\DebugExtension());

//$pdo = new PDO("mysql:host=localhost;dbname=j71325138_counts;charset=utf8", "j71325138", "PASS");

$pdo = new PDO("mysql:host=localhost;dbname=counters;charset=utf8", "root", "");
$router = new Router($twig, $pdo);
$router->add("/login", AuthController::class);
$router->add("/register", RegisterController::class);
$router->add("/", MainController::class);
$router->add("/policy", PolicyController::class);
$router->add("/about", AboutController::class);
$router->add("/account", AccountController::class)
    ->middleware((new LoginRequiredUserMiddleware));
$router->add("/account/edit", AccountEditController::class)
    ->middleware((new LoginRequiredUserMiddleware));
$router->add("/account/password", PasswordEditController::class)
    ->middleware((new LoginRequiredUserMiddleware));
$router->add("/submit", SubmitController::class)
    ->middleware(new LoginRequiredUserMiddleware());
$router->add("/history", HistoryController::class)
    ->middleware(new LoginRequiredUserMiddleware());
$router->add("/ask", AskController::class)
    ->middleware(new LoginRequiredUserMiddleware());
$router->add("/addnews", AddNewsController::class)
    ->middleware(new LoginRequiredAdminMiddleware());
$router->add("/review", ReviewController::class)
    ->middleware(new LoginRequiredAdminMiddleware());
$router->add("/askreview", AskReviewController::class)
    ->middleware(new LoginRequiredAdminMiddleware());
$router->add("/news/(?P<id>\d+)/edit", NewsEditController::class)
    ->middleware(new LoginRequiredAdminMiddleware());
$router->add("/news/(?P<id>\d+)/delete", NewsDeleteController::class)
    ->middleware(new LoginRequiredAdminMiddleware());

$router->get_or_default(Controller404::class);
