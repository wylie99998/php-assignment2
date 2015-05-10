<?php 
ini_set('display_errors', 'On');
//mysqli::__construct ([ string $host = ini_get("mysqli.default_host") [, string $username = ini_get("mysqli.default_user") [, string $passwd = ini_get("mysqli.default_pw") [, string $dbname = "" [, int $port = ini_get("mysqli.default_port") [, string $socket = ini_get("mysqli.default_socket") ]]]]]] )
//echo "huh";
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "guerraj-db", "g9SD49ZTe9juq70t", "guerraj-db");
if($mysqli->connect_errno){
	echo "ERROR";
	echo "Connection error" .$mysqli->connect_erno ."" .$mysqli->connect_error;
	}
	else {
		if(isset($_POST['Film_Name']))
		{
			$name = $_POST['Film_Name'];
			$cat = $_POST['Film_Cat'];
			$length = $_POST['Film_Length'];
			if (!($stmt = $mysqli->prepare("INSERT INTO Inventory(Name, Category, Length) VALUES ('$name', '$cat', $length)"))) {
               echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                                                                                 }
					   
            if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} 			   

		}
		
		if(isset($_POST['reset'])){
			
			if (!($stmt = $mysqli->prepare("TRUNCATE TABLE Inventory"))) {
               echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                                                                                 }
					   
            if (!$stmt->execute()) {
             echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} 			   
		}

echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<link rel="stylesheet" href="style.css">
<title> Movie Interface </title>
</head>
<body>
<section>

</section>
<div> 
<form action=sql-interface.php  method="post">
<input id="reset" type="submit" name="reset" value="Reset database">
</form>
<br>
 </div>
</section>
<section>
<div>
<form action=sql-interface.php  method="post">
Film Name: <input type="text" name="Film_Name" required>
<br>
Film Category: <input type="text" name="Film_Cat" required>
<br>
Film Length: <input type="text" name="Film_Length" required>
<br>
<input type="submit" value= "Submit">

<br>

</form>
</div>
   </section>
   </body>
   </html>';
   
	
	}
?>