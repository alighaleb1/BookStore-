<?php
	session_start();
	$total_cart = 0;
	$search_key =  $_GET['searchfor'];
	//Key phrase entered
	$search_type = $_GET['searchon'];
	$run_search;
	//Search by publisher, author, title etc...

	if($search_type[0] == 'anywhere')
	{
		$run_search = '*';
	}else if($search_type[0] == 't'){
		$run_search = 'title';
	}else if($search_type[0] == 'p'){
		$run_search = 'publisher';
	}else if($search_type[0] == 'a'){
		$run_search = 'author';
	}else if($search_type[0] == 'i'){
		$run_search = 'isbn';
	}else{
		$run_search = $search_type[0];
	}
	
	//if the search type is anywhere applies star for all in queries.
	
	$genre_list = $_GET['category'];

	if($genre_list == 0)
	{
		$genre = '*';
	}else if($genre_list == 1)
	{
		$genre = 'Fantasy';
	}else if($genre_list == 2)
	{
		$genre = 'Adventure';
	}else if($genre_list == 3)
	{
		$genre = 'Fiction';
	}else if($genre_list == 4)
	{
		$genre = 'Horror';
	}

	//Checks if genre_list is a string because 'category' is sent as a string after adding to cart.
	//if else goes through genre_list and assigns value to genre to get ready for sql query

	require_once('../connect_sql.php');
	$results;
	$results_check;

	if($run_search  == '*' && $genre == '*')
	{
		$sqlQuery = "SELECT * FROM BOOKS LEFT JOIN AUTHOR ON BOOKS.AuthorID = AUTHOR.AuthorID 
								WHERE (ISBN LIKE '%$search_key%'
										OR publisher LIKE '%$search_key%'
										OR title LIKE '%$search_key%'
										OR firstname LIKE '%$search_key%'
										OR lastname LIKE '%$search_key%');";
		//Query searches all applicable columns for possible matches.
		$results = mysqli_query($dbc, $sqlQuery);
		$results_check = mysqli_num_rows($results);

		
		
		//If any matching tuples discovered stored into results
	}else if($run_search != '*' && $genre == '*'){

		if($run_search == 'author')
		{
			$sqlQuery = "SELECT * FROM BOOKS LEFT JOIN AUTHOR ON BOOKS.AuthorID = AUTHOR.AuthorID 
			WHERE (firstname LIKE '%$search_key%'
				OR lastname LIKE '%$search_key%');";

		}else{
			$sqlQuery = "SELECT * FROM BOOKS LEFT JOIN AUTHOR ON BOOKS.AuthorID = AUTHOR.AuthorID 
			WHERE ($run_search LIKE '%$search_key%');";
		}
		//Query uses input data to narrow search field and create results.

		$results = mysqli_query($dbc, $sqlQuery);
		$results_check = mysqli_num_rows($results);

	}else if($run_search == '*' && $genre != '*'){
		$sqlQuery = "SELECT * FROM BOOKS LEFT JOIN AUTHOR ON BOOKS.AuthorID = AUTHOR.AuthorID 
								WHERE (ISBN LIKE '%$search_key%'
										OR publisher LIKE '%$search_key%'
										OR title LIKE '%$search_key%'
										OR firstname LIKE '%$search_key%'
										OR lastname LIKE '%$search_key%'
										) AND category = '$genre';";
		//Query searches all key sections and for the specific genre.
		$results = mysqli_query($dbc, $sqlQuery);
		$results_check = mysqli_num_rows($results);

	}else{
		if($run_search == 'author')
		{
			$sqlQuery = "SELECT * FROM BOOKS LEFT JOIN AUTHOR ON BOOKS.AuthorID = AUTHOR.AuthorID 
			WHERE (firstname LIKE '%$search_key%'
				OR lastname LIKE '%$search_key%');";

		}else{
			$sqlQuery = "SELECT * FROM BOOKS LEFT JOIN AUTHOR ON BOOKS.AuthorID = AUTHOR.AuthorID 
			WHERE ($run_search LIKE '%$search_key%' AND category = '$genre');";
		}
		//Query uses input data to narrow search field and create results.

		$results = mysqli_query($dbc, $sqlQuery);
		$results_check = mysqli_num_rows($results);
		//Query searches all applicable columns for possible matches.
	}
	foreach($results as $row){
		if($row['ISBN'] == $_GET['cartisbn']){
			if($_SESSION[$row['title']]['ISBN'] != $row['ISBN']){
				$_SESSION[$row['title']]['ISBN'] = $row['ISBN'];
				$_SESSION[$row['title']]['title'] = $row['title'];
				$_SESSION[$row['title']]['price'] = $row['price'];
				$_SESSION[$row['title']]['firstname'] = $row['firstname'];
				$_SESSION[$row['title']]['lastname'] = $row['lastname'];
				$_SESSION[$row['title']]['publisher'] = $row['publisher'];
				$_SESSION['cart_count'] += 1;
				$_SESSION[$row['title']]['in_cart'] = true;
				
			}
		}
	
	}
    //Stores all data in session so can be accessed as a shopping cart
	if(isset($_SESSION['cart_count'])){
		$total_cart = $_SESSION['cart_count'];
	}else{
		$_SESSION['cart_count'] = 0;
	}

?>
<!-- Figure 3: Search Result Screen by Prithviraj Narahari, php coding: Alexander Martens -->
<html>
<head>
	<title> Search Result - 3-B.com </title>
	<script>
	//redirect to reviews page
	function review(isbn, title){
		window.location.href="screen4.php?isbn="+ isbn + "&title=" + title;
	}
	//add to cart
	function cart(isbn, searchfor, searchon, category){
		window.location.href="screen3.php?cartisbn="+ isbn + "&searchfor=" + searchfor + "&searchon=" + searchon + "&category=" + category;
	}
	</script>
</head>
<body>
	<table align="center" style="border:1px solid blue;">
		<tr>
			<td align="left">
				
					<h6> <fieldset>Your Shopping Cart has <?php echo $total_cart; ?> items</fieldset> </h6>
				
			</td>
			<td>
				&nbsp
			</td>
			<td align="right">
				<form action="shopping_cart.php" method="post">
					<input type="submit" value="Manage Shopping Cart">
				</form>
			</td>
		</tr>	
		<tr>
		<td style="width: 350px" colspan="3" align="center">
			<div id="bookdetails" style="overflow:scroll;height:180px;width:400px;border:1px solid black;background-color:LightBlue">
			<table>
			<?php		

				foreach($results as $row)
				{
					echo "<tr><td align='left'>";
					
					if($_SESSION[$row['title']]['in_cart'] == true){
						echo "</td>";
					}else{
						
						echo "<button name='btnCart' id='btnCart' onClick='cart(" . $row['ISBN'] . ", \"" . $search_key . "\", \"" . $run_search . "\", \"" . $genre_list . "\")'>Add to Cart</button></td>";

					}
					echo "<td rowspan='2' align='left'>$row[title]</br>By $row[firstname] $row[lastname] </br><b>Publisher:</b> $row[publisher],</br><b>ISBN:</b>  $row[ISBN]</t> <b>Price:</b> $row[price]</td></tr>";
					echo "<tr><td align='left'><button name='review' id='review' onClick='review(" . $row['ISBN'] . ", \"" . $row['title'] ."\")'>Reviews</button></td></tr><tr><td colspan='2'><p>_______________________________________________</p></td></tr>";
				}

				//Displays results.

				
			?>
			</table>
			</div>
			
			</td>
		</tr>
		<tr>
			<td align= "center">
				<form action="confirm_order.php" method="get">
					<input type="submit" value="Proceed To Checkout" id="checkout" name="checkout">
				</form>
			</td>
			<td align="center">
				<form action="screen2.php" method="post">
					<input type="submit" value="New Search">
				</form>
			</td>
			<td align="center">
				<form action="index.php" method="post">
					<input type="submit" name="exit" value="EXIT 3-B.com">
				</form>
			</td>
		</tr>
	</table>
</body>
</html>
