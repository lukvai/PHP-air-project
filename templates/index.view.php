<?php require "config/config.php";
require 'inc/functions.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php require "themes/$theme/_partials/head.php"; ?>
</head>
	<body>

		<?php require "themes/$theme/_partials/header.php";
		require "config/router.php";
		require "themes/$theme/pages/add_testimonial.php";
		require "themes/$theme/_partials/footer.php"; ?>

	</body>
</html>




