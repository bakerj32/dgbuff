<h1> FRANKY MUINEZ</h1>

<?php
	include('includes/preferences.php');
	$mysqli = new MySQLi($server, $dbUsername, $dbPassword, $db);
	/* Connect to database and set charset to UTF-8 */
	if($mysqli->connect_error) {
	  echo 'Database connection failed...' . 'Error: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
	  exit;
	} else {
	  $mysqli->set_charset('utf8');
	}
		
	include('Includes/preferences.php');
	$conn = mysqli_connect($server, $dbUsername, $dbPassword, $db);
	
	$term = trim(strip_tags($_GET['term'])); 
	$results = array();
	if ($data = $mysqli->query("SELECT name FROM courses WHERE name LIKE '%$term%' ORDER BY name")) {
		while($row = mysqli_fetch_array($data)) {
			array_push($results, $row['name']);
		}
	}
	else{ print "problem"; } 

	array_push($results, 'Cornwall');
	array_push($results, 'Cornwallace');
	array_push($results, 'Cornhole');
	array_push($results, 'Cornfap');
	
	
	echo json_encode($results);
	
	
?>