<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<style>
		body {
			font-family: "Open Sans", sans-serif;
			color: #444444;
		}

		a {
			color: #f56e00;
			text-decoration: none;
		}

		a:hover {
			color: #f56e00;
			text-decoration: none;
		}

		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			font-family: "Roboto", sans-serif;
		}

		form {
			margin: 20px auto;
			width: 300px;
			text-align: center;
		}

		label {
			display: block;
			margin-bottom: 5px;
			text-align: left;
		}

		input[type="text"],
		input[type="password"] {
			width: 100%;
			padding: 10px;
			margin-bottom: 15px;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
		}

		input[type="submit"] {
			background-color: #f56e00;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 4px;
			cursor: pointer;
		}

		input[type="submit"]:hover {
			background-color: #ff7f00;
		}

		.back-button {
			display: inline-block;
			margin-top: 20px;
			background-color: #f56e00;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 4px;
			cursor: pointer;
		}

		.back-button:hover {
			background-color: #ff7f00;
		}

		.center {
			text-align: center;
		}
	</style>
</head>
<body>
	<h2>Login</h2>
	<form method="post" action="logacc.php">
			<label>Email:</label><br>
			<input type="text" name="uEmail"><br>
			<label>Password:</label><br>
			<input type="password" name="uPass"><br><br>
			<input type="submit" value="Login">
	</form>
	<div class="center">
    <a class="back-button" href="index.php">Back</a>
	</div>
</body>
</html>
