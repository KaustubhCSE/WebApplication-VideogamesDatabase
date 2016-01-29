<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Video Games Collection</title>
		<link href="style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	
	
		<?php 
			try{
			$dbh = new PDO('mysql:host=localhost;dbname=project_videogame',"root","");
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
			<!-- end of site_titlebar -->

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
		
		<div id="output">
			<div>
			<?php 
				$stmt1 = $dbh->prepare('select game_name.Title, game_console.console_name from game_name, game_console,game_release where game_release.VG_ID = game_name.VG_ID and game_release.console_id = game_console.console_id;');
				$stmt1->execute();
			?>
			<label>Unique Games:</label>
				<table border="1px">
					<tr>
						<td><h3>Title</h3></td>
						<td><h3>Console Name</h3></td>
					</tr>
					<?php while($row1 = $stmt1->fetch()){ ?>
					
					<tr>
						<td><?php echo $row1["Title"]; ?></td>
						<td><?php echo $row1["console_name"]; ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<hr/>
			<div>
			<?php 
				$stmt2 = $dbh->prepare('select game_name.Title, count(collection.release_ID) from collection, game_name, game_release where collection.release_ID = game_release.release_ID and game_release.VG_ID = game_name.VG_ID group by collection.release_ID having count(collection.release_ID) > 1;');
				$stmt2->execute();
			?>
			<label>Duplicate Games:</label>
				<table border="1px">
					<tr>
						<td><h5>Title</h5></td>
						<td><h5>Count</h5></td>
					</tr>
					<?php while($row2 = $stmt2->fetch()){ ?>
					
					<tr>
						<td><?php echo $row2["Title"]; ?></td>
						<td><?php echo $row2["count(collection.release_ID)"]; ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<hr/>
			<div>
			<?php 
				$stmt3 = $dbh->prepare('select sum(price) , console_name from collection, game_release, game_console where collection.release_ID = game_release.release_ID and game_release.console_ID = game_console.console_ID group by game_release.console_ID;');
				$stmt3->execute();
			?>
			<label>Total Amount spent per Console:</label>
				<table border="1px">
					<tr>
						<td><h5>Console Name</h5></td>
						<td><h5>Total Cost in $</h5></td>
					</tr>
					<?php while($row3 = $stmt3->fetch()){ ?>
					<tr>
						<td><?php echo $row3["console_name"]; ?></td>
						<td><?php echo $row3["sum(price)"]; ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<hr/>
			<div>
			<?php 
				$stmt4 = $dbh->prepare('select Distinct game_name.title, collection.content from collection, game_release, game_name where collection.release_ID = game_release.release_ID and game_release.VG_ID = game_name.VG_ID and collection.content = "CIB";');
				$stmt4->execute();
			?>
				<label>Complete games</label>
				<table border="1px">
					<tr>
						<td><h5>Title</h5></td>
						<td><h5>Content</h5></td>
					</tr>
					<?php while($row4 = $stmt4->fetch()){ ?>
					
					<tr>
						<td><?php echo $row4["title"]; ?></td>
						<td><?php echo $row4["content"]; ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<hr/>
			<div>
			<?php 
				$stmt5 = $dbh->prepare('select Distinct game_name.title, collection.content from collection, game_release, game_name where collection.release_ID = game_release.release_ID and game_release.VG_ID = game_name.VG_ID and collection.content != "CIB";');
				$stmt5->execute();
			?>
				<label>Incomplete games</label>
				<table border="1px">
					<tr>
						<td><h5>Title</h5></td>
						<td><h5>Content</h5></td>
					</tr>
					<?php while($row5 = $stmt5->fetch()){ ?>
					
					<tr>
						<td><?php echo $row5["title"]; ?></td>
						<td><?php echo $row5["content"]; ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<hr/>			
			<div>
			<?php 
				$stmt6 = $dbh->prepare('select game_name.Title, collection.price from collection, game_release, game_name where collection.release_ID = game_release.release_ID and game_release.VG_ID = game_name.VG_ID order by collection.price desc;');
				$stmt6->execute();
			?>
				<label>Top Expensive Games</label>
				<table border="1px">
					<tr>
						<td><h5>Title</h5></td>
						<td><h5>Price in $</h5></td>
					</tr>
					<?php while($row6 = $stmt6->fetch()){ ?>
					
					<tr>
						<td><?php echo $row6["Title"]; ?></td>
						<td><?php echo $row6["price"]; ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<hr/>
			<div>
			<?php 
				$stmt7 = $dbh->prepare('select distinct game_name.Title from collection, game_release, game_name where collection.release_ID = game_release.release_ID and game_release.VG_ID = game_name.VG_ID and collection.price > game_release.market_value;');
				$stmt7->execute();
			?>
			<label>Games purchased lower than Market Price</label>
				<table border="1px">
					<tr>
						<td><h5>Game Title</h5></td>
					</tr>
					<?php while($row7 = $stmt7->fetch()){ ?>
					
					<tr>
						<td><?php echo $row7["Title"] ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<hr/>
			<div>
			<?php 
				$stmt8 = $dbh->prepare('select distinct game_name.Title,game_console.console_name , collection.sel_status from collection, game_release, game_name, game_console where collection.release_ID = game_release.release_ID and game_release.VG_ID = game_name.VG_ID and game_release.release_ID = game_console.console_ID and collection.sel_status = "keep";');
				$stmt8->execute();
			?>
			<label>Games which Collector wants to keep</label>
				<table border="1px">
					<tr>
						<td><h5>Title</h5></td>
						<td><h5>Console_name</h5></td>
						<td><h5>Sell status</h5></td>
					</tr>
					<?php while($row8 = $stmt8->fetch()){ ?>
					<tr>
						<td><?php echo $row8["Title"] ?></td>
						<td><?php echo $row8["console_name"] ?></td>
						<td><?php echo $row8["sel_status"] ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<hr/>
			<div>
			<?php 
				$stmt9 = $dbh->prepare('select distinct game_name.Title,game_console.console_name , collection.play_status from collection, game_release, game_name, game_console where collection.release_ID = game_release.release_ID and game_release.VG_ID = game_name.VG_ID and game_release.release_ID = game_console.console_ID and collection.play_status = "wants to play";');
				$stmt9->execute();
			?>
			<label>Games which collector wants to play</label>
				<table border="1px">
					<tr>
						<td><h5>Title</h5></td>
						<td><h5>Console</h5></td>
						<td><h5>Play status</h5></td>
					</tr>
					<?php while($row9 = $stmt9->fetch()){ ?>
					<tr>
						<td><?php echo $row9["Title"] ?></td>
						<td><?php echo $row9["console_name"] ?></td>
						<td><?php echo $row9["play_status"] ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<hr/>
			<div>
			<?php 
				$stmt10 = $dbh->prepare('select extract(MONTH from collection.txn_date) , sum(collection.price) from collection group by extract(month from collection.txn_date);');
				$stmt10->execute();
			?>
			<label>Total Money Collector has spent every month</label>
				<table border="1px">
					<tr>
						<td><h5>Month number</h5></td>
						<td><h5>Total spending in that month</h5></td>
					</tr>
					<?php while($row10 = $stmt10->fetch()){ ?>
					<tr>
						<td><?php echo $row10["extract(MONTH from collection.txn_date)"] ?></td>
						<td><?php echo $row10["sum(collection.price)"] ?></td>
					</tr>
					<?php } ?>
				</table>
			</center></div>
			<hr/>
			<div>
			<?php 
				$stmt11 = $dbh->prepare('SELECT game_name.Title , max(game_release.market_value - collection.price) FROM game_release, collection, game_name where collection.release_ID = game_release.release_ID AND game_release.VG_ID = game_name.VG_ID;');
				$stmt11->execute();
			?>
			<label>Game with highest increase in value</label>
				<table border="1px">
					<tr>
						<td><h5>Title</h5></td>
						<td><h5>Difference in $</h5></td>
					</tr>
					<?php while($row11 = $stmt11->fetch()){ ?>
					<tr>
						<td><?php echo $row11["Title"] ?></td>
						<td><?php echo $row11["max(game_release.market_value - collection.price)"] ?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
			<hr/>
	</body>
</html>	