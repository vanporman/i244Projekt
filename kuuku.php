<?php
require_once('functions.php');
session_start();
connect_db();

$page="mainPage";
if (isset($_GET['page']) && $_GET['page']!=""){
    $page=htmlspecialchars($_GET['page']);
}

include_once('views/header.html');

switch($page){
    case "login":
        login();
        break;
    case "dashboard":
        showOrders();
        break;
    case "orders":
        insertOrders();
        break;
    case "sales":
        sale();
        break;
    case "makeSales":
        makeSale();
        break;
    case "demos":
        demos();
        break;
    case "admin":
        include_once ('views/adminnile.html');
        break;
    case "logout":
        logout();
        break;
    default:
        include_once('views/login.html');
        break;
}

include_once('views/footer.html');

?>