<?php

if (!isset($_GET['page'])) {
	$_GET['page'] = 'home';
}
$routerEngine = $_GET['page'];
if ($routerEngine) {
	switch ($routerEngine) {
		case "home":
			include "themes/$theme/pages/home.php";
			break;
		case "order":
			include "themes/$theme/pages/order_flight.php";
			break;
		case "details":
			include "themes/$theme/pages/flight_detail.php";
			break;
		default:
			include "themes/$theme/pages/404.php";
	}
} 
