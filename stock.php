<html>
	<head>
		<title>Shop & Bill</title>
		<link rel="stylesheet" href="css/shop.css">
		<link rel="stylesheet" href="css/stock.css">
		<script type="text/javascript" src="js/lib/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="js/lib/jquery.cookie.js"></script>
	</head>
	<body>
		
		<div class="header">
			<div id="shop_logo">
				Shop & Bill
			</div>
			<div id="shop_head">
				Raja Shop Center
			</div>
			<div id="menu">
				Menu
			</div>
			<div id="menu_list">
				<ul>
					<li><a href="billing.php">Billing</a></li>
					<li><a href="purchase.php">Purchase</a></li>
					<li><a href="stock.php">Stock</a></li>
					<li><a href="items.php">Items</a></li>
					<li><a href="analysis.php">Analysis</a></li>
					<li><a href="others.php">Others</a></li>
				</ul>
			</div>
		</div>
		<div class="container">
			<div class="side_menu">
				<div class="user_profile">
					<div id="user_image"><img src="images/profile.png" alt="profile"></div>
					<div id="user_name">Raja</div>
				</div>
				
				<div class="navigation">
					<ul>
						<li id="dashboard" class="active"> Dashboard </li>
						<li id="profile" > Profile </li>
						<li id="logout"> Logout </li>
					</ul>
				</div>
			</div>
			<div class="content">
				<div id="all_stocks">
					<table border="1">
						<tbody id="all_stocks_table">
							<tr>
								<th rowspan="2">Item Name</th>
								<th rowspan="2">Category</th>
								<!--<th rowspan="2">Sub-Category</th>-->
								<th rowspan="2">Product</th>
								<th colspan="2">Quantity</th>
								<th rowspan="2">Rate</th>
								<th rowspan="2">Balance</th>
							</tr>
							<tr>
								<th>Value</th>
								<th>Unit</th>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="footer">
			Footer
		</div>
		
		<script src="js/shop.js"></script>
		<script src="js/stock.js"></script>
	</body>
</html>