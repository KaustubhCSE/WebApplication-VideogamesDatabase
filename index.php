<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Video Games Collection</title>
		<link href="style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	<?php 
			try{
			$dbh = new PDO('mysql:host=localhost;dbname=project_videogame',"root","");
			$stmt = $dbh->prepare('select game_name.Genre, game_name.Title, game_console.console_name, collection.condition, collection.play_status, collection.sel_status, collection.price, collection.txn_date from collection, game_release, game_name, game_console where collection.release_ID = game_release.release_ID and game_release.VG_ID = game_name.VG_ID and game_release.console_ID = game_console.console_ID;');
			$stmt->execute();
			}catch(PDOException $e){
				echo "Error: " . $e->getMessage();
				die();
			}
		?>
	<div id="template1">
	<div id="site_titlebar">
		<div id="site_title">
			<h1>Video Games Collection
			</h1>
		</div>
	</div>

	<div id="template_menu">
		
			<ul>
				<li>
					<a href="/Videogame/index.php">Home</a>
				</li>
				<li>
					<a href="/Videogame/insert.php">Add Videogames</a>
				</li>
				<li>	
					<a href="/Videogame/query.php">Result Page</a>
				</li>
			</ul>
		
	</div>
	<h4>Video games in Collection with Details</h4>
	<table border="1px">
		<tr>
			<td><b>Genre</b></td>
			<td><b>Title</b></td>
			<td><b>Console Name</b></td>
			<td><b>Condition</b></td>
			<td><b>Play Status</b></td>
			<td><b>Sell Status</b></td>
			<td><b>Price in $</b></td>
			<td><b>Transaction Date</b></td>
		</tr>
		<?php 
			while($row = $stmt->fetch()){ ?>
			<tr>
			<td><?php echo $row["Genre"]; ?></td>
			<td><?php echo $row["Title"]; ?></td>
			<td><?php echo $row["console_name"]; ?></td>
			<td><?php echo $row["condition"]; ?></td>
			<td><?php echo $row["play_status"]; ?></td>
			<td><?php echo $row["sel_status"]; ?></td>
			<td><?php echo $row["price"]; ?></td>
			<td><?php echo $row["txn_date"]; ?></td>
			</tr>	
			<?php }
		?>
	</table>
	
</div>
</body>
</html>