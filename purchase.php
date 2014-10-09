<html>
	<head>
		<title>Purchase</title>
		<link rel="stylesheet" href="css/shop.css">
		<link rel="stylesheet" href="css/purchase.css">
		<script type="text/javascript" src="js/lib/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="js/lib/jquery.cookie.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="header">
				<div id="shop_logo">
					Shop & Bill
				</div>
				<div id="shop_head">
					Raja Shop Center
				</div>
			</div>
			<div class="side_menu">
				<div class="user_profile">
					<div id="user_image"></div>
					<div id="user_name">Raja</div>
				</div>
				
				<div class="navigation">
					<ul>
						<li>
							<a href="dashboard.php"> Dashboard </a>
						</li>
						<li>
							<a href="profile.php"> Profile </a>
						</li>
						<li>
							<a href="logout.php"> Logout </a>
						</li>
					</ul>
				</div>
			</div>
			<div class="content">
				<div id="all_purchase">
					<table border="1">
						<tbody id="all_purchase_table">
							<tr>
								<th rowspan="2">Purchase Date</th>
								<th rowspan="2">Purchase From</th>
								<!--<th rowspan="2">Sub-Category</th>-->
								<th rowspan="2">Item</th>
								<th colspan="2">Quantity</th>
								<th rowspan="2">Rate</th>
							</tr>
							<tr>
								<th>Value</th>
								<th>Unit</th>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="new_item">
					<form id="item_form">
						<ul>
							<li><label>Item Name</label><input type="text" name="name" id="name"></li>
							<li><label>Category</label><input type="text" name="category" id="category"></li>
							<!--<li><label>Sub-Category</label><input type="text" name="sub_category" id="sub_category"></li>-->
							<li><label>Product</label><input type="text" name="product" id="product"></li>
							<li>
								<label>Quantity</label>
								<input type="text" name="quantity" id="quantity">
								<select name="qty_unit" id="qty_unit">
									<option value="no">no</option>
									<option value="kg">kg</option>
									<option value="litre">litre</option>
									<option value="gram">gram</option>
								</select>
							</li>
							<li><label>Rate</label><input type="text" name="rate" id="rate"></li>
							<li><input type="submit" name="submit" id="item_submit" value="Submit" />
						</ul>
					</form>
					<div id="status_message"></div>
					<div id="error_message"></div>
				</div>
			</div>
			<div class="footer">
				Footer
			</div>
		</div>
		<script type="text/javascript" src="js/items.js"></script>
	</body>
</html>