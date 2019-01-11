<?php

if (!isset($_GET['page'])) {
	$_GET['page'] = 'home';
}
$routerEngine = $_GET['page'];
if ($routerEngine) {
	switch ($routerEngine) {
        case "home":
            include "themes/$theme/pages/home.php";
            include "themes/$theme/pages/add_testimonial.php";
            include "themes/$theme/_partials/footer.php";
            break;
        case "order":
            include "themes/$theme/pages/order_flight.php";
            include "themes/$theme/_partials/footer.php";
            break;
        case "details":
            include "themes/$theme/pages/flight_detail.php";
            include "themes/$theme/_partials/footer.php";
            break;
        case "login":
            if(isset($_SESSION['login'])) {
                include "avip/index.php";
            }else{
                include "avip/login.php";
            }
            break;
        case "logout":
            session_destroy();
            header("Location: index.php");
            break;
        case "tables":
            include "avip/tables.php";
            break;
        case "form":
            include "avip/form.php";
            break;
		default:
			include "themes/$theme/pages/404.php";
	}
} 
