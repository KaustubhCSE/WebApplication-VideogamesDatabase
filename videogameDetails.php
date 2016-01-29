<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>VIDEOGAME COLLECTION</title>
		<link href="temp_style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
	
	
		<?php 
			try{
			$dbh = new PDO('mysql:host=localhost;dbname=videogame',"root","");
			}catch(PDOException $e){
				echo "Error: " . $e->getMessage();
				die();
			}
		?>
		<?php 
			$stmt = $dbh->prepare('select * from console');
			$stmt->execute();
		?>
		<div id="templatemo_container">
			<div id="templatemo_site_title_bar">
				<div id="site_title">
					<h1>VIDEOGAMES COLLECTION
					</h1>
				</div>
			</div>
			<!-- end of templatemo_site_title_bar -->

			<div id="templatemo_menu">
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
				<li>
					<a href="/Videogame/videogameDetails.php">Find Games</a>
				</li>
			</ul>
			</div>
		<div><label>Select Console:
			<form action="videogameDetails.php" method="GET">
				<select name="console">
					<option value=''>----Select----</option>
					<?php 
						while($row = $stmt->fetch()){ ?>
							<option value='<?php echo $row["c_id"]; ?>'><?php echo $row["c_name"]; ?></option>
					<?php }	?>
				</select>
				<input type="submit" name="check" value="Check"/>
			</form>
		</label>
		</div>
		<?php 
			if(isset($_GET["check"])){
				$cid = $_GET["console"];
				$query = 'SELECT c.c_name, v.v_name, t.amt_paid, t.market_value, t.cond, t.completeness FROM console c JOIN releases r ON c.c_id=r.c_id JOIN videogame v ON v.v_id=r.v_id JOIN transaction t ON t.t_id = r.t_id WHERE c.c_id='.$cid.';';
				$stmt1 = $dbh->prepare($query);
				$stmt1->execute();
			 ?>
			
			
		<?php echo $stmt1->fetch()["c_name"]; ?>
		<table>
		<tr>
					<td>Game</td>
					<td>Amount Paid</td>
					<td>Market Value</td>
					<td>Condition</td>
					<td>Completeness</td>
				</tr>
		<?php while($row1 = $stmt1->fetch()){?>
				
				<tr>
					<td><?php echo $row1["v_name"]; ?></td>
					<td><?php echo $row1["amt_paid"]; ?></td>
					<td><?php echo $row1["market_value"]; ?></td>
					<td><?php echo $row1["cond"]; ?></td>
					<td><?php echo $row1["completeness"]; ?></td>
				</tr>
				
			<?php 
				} ?>
			</table>
			<?php } ?>
		</div>
	</body>
</html>