<?php 
ini_set('display_errors', 'On');
//mysqli::__construct ([ string $host = ini_get("mysqli.default_host") [, string $username = ini_get("mysqli.default_user") [, string $passwd = ini_get("mysqli.default_pw") [, string $dbname = "" [, int $port = ini_get("mysqli.default_port") [, string $socket = ini_get("mysqli.default_socket") ]]]]]] )
//echo "huh";
include 'myInfo.php';
class t
{
	public $s_id;
	public $s_name;
	public $s_cat;
	public $s_length;
	public $s_rented;
	function oprint(){
		echo $this->s_id . $this->s_name . $this->s_cat . $this->s_length . $this->s_rented;
	}
}
//g9SD49ZTe9juq70t
$mysqli = new mysqli("oniddb.cws.oregonstate.edu", "guerraj-db", $pswd, "guerraj-db");
if($mysqli->connect_errno){
	echo "ERROR";
	echo "Connection error" .$mysqli->connect_erno ."" .$mysqli->connect_error;
	}
	else {
		//insert
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
		//reset
		if(isset($_POST['reset'])){
			
			if (!($stmt = $mysqli->prepare("TRUNCATE TABLE Inventory"))) {
               echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                                                                                 }
					   
            if (!$stmt->execute()) {
             echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} 			   
		}
		
		//fetch
        
			$results = array();
			$i = 1;
			if (!($stmt = $mysqli->prepare("SELECT ID,Name, Category, Length, Rented FROM Inventory"))) {
               echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                                                                                 }
					   
            if (!$stmt->execute()) {
             echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} 			   
$out_id;
$out_name;
$out_cat;
$out_length;
$out_rented;

if (!$stmt->bind_result($out_id, $out_name, $out_cat, $out_length, $out_rented)) {
    echo "Binding output parameters failed: (" . $stmt->errno . ") " . $stmt->error;
}
while ($stmt->fetch()) {
   // $results[i]= sprintf("id = %s , name = %s \n, category = %s \n, length = %s \n, rented = %s \n ", $out_id, $out_name, $out_cat, $out_length, $out_rented);
	$results[$i] = new t;
	$results[$i]->s_id = $out_id;
	$results[$i]->s_name = $out_name;
	$results[$i]->s_cat = $out_cat;
	$results[$i]->s_length = $out_length;
	$results[$i]->s_rented = $out_rented;
   // $results[$i]->oprint();
	$i= $i +1;;
	
}
//select


if(isset($_POST['delete_row'])){
	$del = $_POST['delete_row'];
	//DELETE FROM Inventory WHERE Inventory.ID = 1 LIMIT 1
	if (!($stmt = $mysqli->prepare("DELETE FROM Inventory WHERE Inventory.ID = $del LIMIT 1"))) {
               echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                                                                                 }
					   
            if (!$stmt->execute()) {
             echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
} 			   
}
//rent
if(isset($_POST['rent_row'])){
	$upd = $_POST['rent_row'];
	for($z=1; $z<=count($results); $z++){
		if($results[$z]->s_id == $upd)
			break;
	}
	if($results[$z]->s_rented == 0){
	if (!($stmt = $mysqli->prepare("UPDATE Inventory SET rented=1 WHERE Inventory.ID = $upd"))) {
               echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                                                                                 }
	}
	else{
		if (!($stmt = $mysqli->prepare("UPDATE Inventory SET rented=0 WHERE Inventory.ID = $upd"))) {
               echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
                                                                                 }
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
<form id="bubble" action=sql-interface.php  method="post">
Film Name:   <input type="text" name="Film_Name" required>
<br>
Film Category: <input type="text" name="Film_Cat" required>
<br>
Film Length:   <input type="text" name="Film_Length" required>
<br>
<input type="submit" value= "Submit">

<br>

</form>
</div>
   </section>
   <section>
   <br>
   <br>
   <br>
   <div>
   <form id= "bubble" action=sql-interface.php  method="post">
   <select name="dropdownmenu" size="1">
   <option value="all">All </option>';
   $cats = array();
   $cats[1] = $results[1]->s_cat;
   for($j =1; $j<=count($results); $j++){
	    for($z =1; $z<=count($cats); $z++) {
		if($results[$j]->s_cat == $cats[$z])
		{
			
			break;
		}
		if($z == count($cats)){
			$cats[] = $results[$j]->s_cat;
		}
   }
   }
   
   for($j=1; $j<=count($cats); $j++){
	   echo '<option value ="';
	   echo $cats[$j];
	   echo '">';
	   echo $cats[$j];
	   echo '</option> \n';
   }
   
   echo '</select>
   <input type="submit" value="Submit">
   </form>
   </div>
   </section>
   <br>
   <section>
   <div>
   <table>
   <tr> <td> ID </td> <td> Name </td>  <td> Category </td> <td> Length </td>  <td> Rented </td> <td> delete movie </td> <td> rent </td> </tr>';
   if(isset($_POST['dropdownmenu'])){
	   if($_POST['dropdownmenu'] == 'all'){
         for($i=1; $i<=count($results); $i++){
	       echo '<tr> <td>';
           echo $results[$i]->s_id;
	       echo "</td> <td>";
		    echo $results[$i]->s_name;
	       echo "</td> <td>";
		    echo $results[$i]->s_cat;
	       echo "</td> <td>";
		    echo $results[$i]->s_length;
	       echo "</td> <td>";
		   if($results[$i]->s_rented == 0)
		    echo 'available';
		else
		   echo 'not available';
	       echo '</td> <td> 
		   <form action=sql-interface.php  method="post">
		   <input type="submit" name="delete_row" value="';
           
		   echo $results[$i]->s_id;
		   echo '">
		   </form></td> <td> 
		   <form action=sql-interface.php  method="post">
		   <input type="submit" name="rent_row" value="';
		   echo $results[$i]->s_id;
		   echo'"> </form></td>  </tr>';
	   
           }
		}
		
		else 
		{
			for($i=1; $i<=count($results); $i++){
				if($_POST['dropdownmenu'] == $results[$i]->s_cat){
	       echo '<tr> <td>';
           echo $results[$i]->s_id;
	       echo "</td> <td>";
		    echo $results[$i]->s_name;
	       echo "</td> <td>";
		    echo $results[$i]->s_cat;
	       echo "</td> <td>";
		    echo $results[$i]->s_length;
	       echo "</td> <td>";
		   if($results[$i]->s_rented == 0)
		    echo 'available';
		else
		   echo 'not available';
	       echo '</td> <td> 
		   <form action=sql-interface.php  method="post">
		   <input type="submit" name="delete_row" value="';
           
		   echo $results[$i]->s_id;
		   echo '">
		   </form></td> <td> 
		   <form action=sql-interface.php  method="post">
		   <input type="submit" name="rent_row" value="';
		   echo $results[$i]->s_id;
		   echo'"> </form></td>  </tr>';
	   
           }
			}
		}
   }
   
   echo '</table>
   </div>
   </section>
   
   </body>
   </html>';
   
	
	}
?>