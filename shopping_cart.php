<?php
	session_start();
	$subtotal;
	foreach($_SESSION as $row)
	{
		$add_price = $row['price'];
		if(isset($_POST[$row['ISBN']])){
			$add_price = $add_price * $_POST[$row['ISBN']];
		}
		$subtotal += $add_price;
	}

	if(isset($_GET['delIsbn']))
	{
		foreach($_SESSION as $row)
		{
			if($_GET['delIsbn'] == $row['ISBN'])
			{
				$add_price = $row['price'];
				if(isset($_POST[$row['ISBN']])){
					$add_price = $add_price * $_POST[$row['ISBN']];
				}
				$subtotal -= $add_price;
				
				unset($_SESSION[$row['title']]);
				$_SESSION['cart_count'] -= 1;

			}
		}
	}
?>
<!DOCTYPE HTML>
<head>
	<title>Shopping Cart</title>
	<script>
	//remove from cart
	function del(isbn){
		window.location.href="shopping_cart.php?delIsbn="+ isbn;
	}
	</script>
</head>
<body>
	<table align="center" style="border:2px solid blue;">
		<tr>
			<td align="center">
				<form id="checkout" action="confirm_order.php" method="get">
					<input type="submit" name="checkout_submit" id="checkout_submit" value="Proceed to Checkout">
				</form>
			</td>
			<td align="center">
				<form id="new_search" action="screen2.php" method="post">
					<input type="submit" name="search" id="search" value="New Search">
				</form>								
			</td>
			<td align="center">
				<form id="exit" action="index.php" method="post">
					<input type="submit" name="exit" id="exit" value="EXIT 3-B.com">
				</form>					
			</td>
		</tr>
		<tr>
				<form id="recalculate" name="recalculate" action="" method="post">
			<td  colspan="3">
				<div id="bookdetails" style="overflow:scroll;height:180px;width:400px;border:1px solid black;">
					<table align="center" BORDER="2" CELLPADDING="2" CELLSPACING="2" WIDTH="100%">
						<?php
							foreach($_SESSION as $row){
								if($row['title'] != ""){
									echo "<th width='10%'>Remove</th><th width='60%'>Book Description</th><th width='10%'>Qty</th><th width='10%'>Price</th>";
									echo "<tr><td><button name='delete' id='delete' onClick='del(\"" . $row['ISBN'] . "\");return false;'>Delete Item</button></td><td> " . $row['title'] . "</br><b>By</b> " . $row['firstname'] . " " . $row['lastname'] . "</br><b>Publisher: </b>" . $row['publisher'] . "</td><td><input id='" . $row['ISBN'] ."' name='" . $row['ISBN'] . "' ";
									if(isset($_POST[$row['ISBN']])){
										echo "value='" . $_POST[$row['ISBN']] ."' size='1' /></td><td>" . $row['price'] ."</td></tr>";	
									}else{
										echo "value='1' size='1' /></td><td>" . $row['price'] ."</td></tr>";	
									}
								}
							}	
						?>	
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td align="center">				
					<input type="submit" name="recalculate_payment" id="recalculate_payment" value="Recalculate Payment">
				</form>
			</td>
			<td align="center">
				&nbsp;
			</td>
			<td align="center">			
				Subtotal:  $<?php echo $subtotal; ?>			</td>
		</tr>
	</table>
</body>
