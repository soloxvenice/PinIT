<!DOCTYPE html>
	<html>

	<head>
		<title>Simple Form Application - PHP</title>
		<link rel="stylesheet" href="view/main.css">
	</head>

	<body>
	<p><a href="pinit.php">Back to HTML Form</a></p>
		<main>
			<h1>User Submitted Comments</h1>

			<p>First Name: <?php echo $fname; ?> </p>
			<p>Last Name: <?php echo $lname; ?> </p>
			<p>Email: <?php echo $email; ?> </p>
			<p>Comments: <?php echo $comment; ?></p>
		</main>
	</body>
	</html>