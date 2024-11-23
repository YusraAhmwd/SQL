<?php
//connection to the database and select a DB to work with
$dbhandle = mysqli_connect('localhost', 'root', '', 'php_security')  or die('MySQL not connected');
//mysqli_select_db('php_security',$dbhandle)  or die ( 'Could not select php_security' );

if (!$dbhandle) {
	die ( 'Could not select php_security' );
}

// execute the SQL query and return records
$username = $_POST["username"];
$password = $_POST["password"];

if (!preg_match("/^[a-zA-Z]{8,12}$/D",$username)) {
  $nameErr = "Only letters are allowed and the minimum number of the letters are 8";
  echo $nameErr;
}

//////////////////////////////////////////////////////////////////////////////////
//Parameterized built-in function
//uncomment these to fix SQL injection using Parametrized built-in function
//$username = mysqli_real_escape_string($dbhandle, $_POST["username"] );
//$password = mysqli_real_escape_string($dbhandle, $_POST["password"] );

///////////////////////////////////////////////////////////////////////////////////


/*
/////////////////////////////////////////////////////////////////////////////////////
//prepared sql statement
// create a prepared statement 
$stmt = mysqli_stmt_init($dbhandle);
$safe_query  = "SELECT * FROM users WHERE username=? AND password=?";
mysqli_stmt_prepare($stmt,$safe_query);
mysqli_stmt_bind_param($stmt, "ss", $username,$password);
// execute query //
mysqli_stmt_execute($stmt);
// bind result variables 
$result = mysqli_stmt_get_result($stmt);
////////////////////////////////////////////////////////////////////////////////////////
*/

// comment this section (4 lines if you use prepared statement)
$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
echo "<font color=red><b> The query string that is formed for the Database is: </b></font></br />";
echo $query . "<br />";
$result = mysqli_query($dbhandle, $query);

// fetch tha data from the database
$num = mysqli_num_rows($result);

if ($num > 0) {
	print 'got matching user as follows: <br />';
	while ($row =  mysqli_fetch_assoc($result)) {
		echo "User: " . $row ["username"] . " - " . $row ["password"]. " " . "<br />" ;
	}
	
} else {
	if(isset($safe_query)){
		echo $safe_query.'<br>';
	}
	echo "0 results";
}


// close the connection
mysqli_close ( $dbhandle );
?>
