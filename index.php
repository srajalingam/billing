<html>
	<head>
		<title>Shop & Bill</title>
		<link rel="stylesheet" href="css/index.css" />
		<script type="text/javascript" src="js/lib/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="js/lib/jquery.cookie.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="shop_logo">
					Shop & Bill
				</div>
				<div class="shop_login">
					<form action="php/request.php?c=shop" method="POST">
						<ul>
							<input type="hidden" name="mtd" value="login">
							<li><input type="text" name="shop_username" id="shop_username" placeholder="Username" autofocus /></li>
							<li><input type="password" name="shop_password" id="shop_password" placeholder="Password" /></li>
							<li><input type="submit" name="login" id="login" value="Login" /></li>
						</ul>
					</form>
					<p id="alert_msg"></p>
				</div>
			</div>
		</div>
			<script src="js/index.js"></script>
	</body>
</html>