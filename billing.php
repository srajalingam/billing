<html>
	<head>
		<title>Shop & Bill</title>
		<link rel="stylesheet" href="css/lib/jquery-ui.css">
		<link rel="stylesheet" href="css/shop.css">
		<link rel="stylesheet" href="css/billing.css">
		
		<script type="text/javascript" src="js/lib/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="js/lib/jquery-ui.js"></script>
		<script type="text/javascript" src="js/lib/jquery.cookie.js"></script>
		<script type="text/javascript" src="js/lib/jquery-validate.js"></script>
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
				<div id="new_bill">
					<form id="bill_form" validate>
						<ul>
							<li><label>Bill ID</label><input type="text" name="bill_id" id="bill_id"></li>
							<li><label>Bill Date</label><input type="text" name="bill_date" id="bill_date"></li>
							<li><label>Name</label><input type="text" name="bill_name" id="bill_name"></li>
							
							<li><h3>Items List</li>
							<li>
								<table border="1" id="items_added">
									<tbody id="all_item_bill_table">
										<tr>
											<th rowspan="2">Item</th>
											<th colspan="2">Quantity</th>
											<th rowspan="2">Rate</th>
											<th rowspan="2">Action</th>
										</tr>
										<tr>
											<th>Value</th>
											<th>Unit</th>
										</tr>
										
										<tr>
											<input type="hidden" class="items" name="item_id" id="item_id">
											<td><input type="text" class="items" name="item" id="item"></td>
											<td><input type="text" class="items" name="qty_value" id="qty_value"></td>
											<td>
												<select class="items" name="qty_unit" id="qty_unit">
													<option value="no">no</option>
													<option value="kg">kg</option>
													<option value="litre">litre</option>
													<option value="gram">gram</option>
												</select>
											</td>
											<td><input type="text" class="items" name="rate" id="rate"></td>
											<td>
												<input type="button" name="add_item" id="add_item" value="ADD">
											</td>
										</tr>
									</tbody>
								</table>
							</li>
							
							<li><label>Remarks</label><textarea name="remarks" id="remarks"></textarea></li>
							<li><label>Bill By</label><input type="text" name="bill_by" id="bill_by"></li>
							<li><input type="submit" name="bill_submit" id="bill_submit" value="Submit" />
						</ul>
					</form>
					<div id="status_message"></div>
					<div id="error_message"></div>
				</div>
			</div>
		</div>
		<div class="footer">
			Footer
		</div>
	
		<script src="js/shop.js"></script>
		<script src="js/billing.js"></script>
	</body>
</html>