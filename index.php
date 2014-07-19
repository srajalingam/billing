<html>
	<head>
		<title>Shop & Bill</title>
		<script type="text/javascript" src="js/lib/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="js/lib/jquery-validate.js"></script>
		<link type="text/css" rel="stylesheet" href="css/custom.css" />
		<style>
			.error {
				float:left;
				color:red;
				font-size: 116px;
			}
			
		</style>
	</head>
	<body>
		<div class="container">
			<div class="header">
			</div>
			<div class="content">
				<div id="shop_details">
					<a id=""><h3></h3></a>
					<label>Owner : </label>
					<p></p>
				</div>
				<form id="shop_registration">
					<ul>
						<li><label>Shop Name : </label><input type="text" name="shop" id="shop" /><label for="shop" class="error"></li>
						<li><label>Owner Name : </label><input type="text" name="owner" id="owner" /></li>
						<li><label>Shop Address : </label><input type="text" name="address" id="address" /></li>
						<li><label>Email ID : </label><input type="text" name="email" id="email" /></li>
						<li><label>Phone No : </label><input type="text" name="phone" id="phone" /></li>
						<li><label>Mobile No : </label><input type="text" name="mobile" id="mobile" /></li>
						<li><input type="submit" name="submit" id="shop_submit" value="Save"/>
					</ul>
				</form>
				<div id="status_message"></div>
				<div id="error_message"></div>
			</div>
			<div class="footer">
			</div>
			
		</div>
		<script src="js/index.js"></script>
		
	</body>
</html>