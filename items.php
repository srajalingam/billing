<html>
	<head>
		<title>Shop & Bill</title>
		<script type="text/javascript" src="js/lib/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="js/lib/jquery-validate.js"></script>
	</head>
	<body>
		<div id="all_items">
			<table border="1">
				<tbody id="all_items_table">
					<tr>
						<th rowspan="2">Item Name</th>
						<th rowspan="2">Category</th>
						<th rowspan="2">Sub-Category</th>
						<th rowspan="2">Product</th>
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
					<li><label>Sub-Category</label><input type="text" name="sub_category" id="sub_category"></li>
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
		<script type="text/javascript" src="js/items.js"></script>
	</body>
</html>