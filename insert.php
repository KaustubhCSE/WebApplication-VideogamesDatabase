<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Video Games Collection</title>
		<link href="style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php 
			try{
			$dbh = new PDO('mysql:host=localhost;dbname=project_videogame',"root","");
			$stmt = $dbh->prepare('SELECT * FROM game_console');
			$stmt->execute();
			$stmt1 = $dbh->prepare('SELECT game_name.VG_ID, game_name.Title FROM game_name');
			$stmt1->execute();			
			$stmt4 = $dbh->prepare('SELECT * FROM game_developer');
			$stmt4->execute();
			$stmt5 = $dbh->prepare('SELECT * FROM publisher');
			$stmt5->execute();
			
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
						
			<?php 
			if(isset($_POST["Add"])){
				$con = $_POST["condition"];
				$cont = $_POST["content"];
				$sels = $_POST["sel_status"];	
				$txnd = $_POST["txn_date"];
				$price = $_POST["price"];
				$plays = $_POST["play_status"];
				$mkt = $_POST["market_value"];
				$dbh->beginTransaction();
				$st1= $dbh->prepare('SELECT (max(release_ID)+1) as count FROM game_release');
				$st1->execute();   
				$rel = $st1->fetch();				
				$dbh->exec('INSERT INTO game_release VALUES("'.$rel["count"].'","'.$_POST['game_name'].'","'.$_POST['game_console'].'","'.$_POST['game_developer'].'","'.$_POST['publisher'].'","'.$mkt.'")') 
						or die(print_r($dbh->errorInfo(), true));
						
				$st2 = $dbh->prepare('SELECT (max(collection_ID)+1) as count FROM collection');
				$st2->execute();
				$coll=$st2->fetch();
				$dbh->exec('INSERT INTO collection VALUES("'.$coll["count"].'","'.$rel["count"].'","'.$con.'","'.$cont.'","'.$sels.'","'.$txnd.'","'.$price.'","'.$_POST['play_status'].'")') 
						or die(print_r($dbh->errorInfo(), true));
				$dbh->commit();	
				echo "*****************************************Game Data Inserted Successfully*******************************************";
			}
		?>
		

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
			
<form action="insert.php" method="POST">
			<table>
			<tr>
				<td>Console Name</td>
				<td><select name="game_console">
					<option value=''>----Select----</option>
					<?php 
						while($row = $stmt->fetch()){ ?>
							<option value='<?php echo $row["console_ID"]; ?>'><?php echo $row["console_name"]; ?></option>
					<?php }	?>
			</select></td>
			</tr>
			<tr>
				<td>Game Name</td>
				<td><select name="game_name">
					<option value=''>----Select----</option>
					<?php 
						while($row1 = $stmt1->fetch()){ ?>
							<option value='<?php echo $row1["VG_ID"]; ?>'><?php echo $row1["Title"]; ?></option>
					<?php }	?>
			</select></td>
			</tr>
			<tr>
				<td>Developer Name</td>
				<td><select name="game_developer">
					<option value=''>----Select----</option>
					<?php 
						while($row4 = $stmt4->fetch()){ ?>
							<option value='<?php echo $row4["dev_ID"]; ?>'><?php echo $row4["dev_name"]; ?></option>
					<?php }	?>
			</select></td>
			</tr>
			<tr>
				<td>Publisher Name</td>
				<td><select name="publisher">
					<option value=''>----Select----</option>
					<?php 
						while($row5 = $stmt5->fetch()){ ?>
							<option value='<?php echo $row5["pub_ID"]; ?>'><?php echo $row5["pub_name"]; ?></option>
					<?php }	?>
			</select></td>
			</tr>
			<tr>
			<td>Game Condition</td>
			<td>
			<select name="condition">
					<option value=''>----Select----</option>
					<option value='new'>New</option>
					<option value='mint'>Mint</option>
					<option value='very good'>Very Good</option>
					<option value='good'>Good</option>
					<option value='acceptable'>Acceptable</option>
					<option value='poor'>Poor</option>
			</select></td>	
			</tr>
			<tr>
			<td>Game Content</td>
			<td>
			<select name="content">
					<option value=''>----Select----</option>
					<option value='CIB'>Cartridge-Instructions-BOX</option>
					<option value='CB'>Cartridge-BOX</option>
					<option value='CI'>Cartridge-Instructions</option>
					<option value='C'>Cartridge</option>
			</select></td>
			</tr>
			<tr>
			<td>Sell Status</td>
			<td>
			<select name="sel_status">
					<option value=''>----Select----</option>
					<option value='keep'>keep</option>
			</select></td>
			</tr>
			<tr>
			<td>Transaction Date</td>
			<td>
			<input type="date" name="txn_date">
			</td>
			</tr>
			<tr>
			<td>Price</td>
			<td>
			<input type="number" name="price">
			</td>
			</tr>
			<tr>
			<td>Play Status</td>
			<td>
			<select name="play_status">
					<option value=''>----Select----</option>
					<option value='wants to play'>wants to play</option>
					<option value='played'>played</option>
					<option value='completed'>completed</option>
			</select></td>
			</tr>
			<tr>
			<td>Market Value: </td><td><input type="number" name="market_value" /></td>
			</tr>
			<tr>
			<td></td>
			<td><input type="submit" name="Add" value="Add"/></td>
			</tr>
			</table>
		</form>
	</div>								
	</body>
</html>