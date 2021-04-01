<?php
include_once('include/db.php');
//check if button register is click
if(isset($_POST['register'])){

	//get the data using $_POST[], inside the $_POST[] is the name inside the input tag
	$username=$_POST['username'];
	$password=$_POST['password'];
	$permission=$_POST['permission'];
	//insert into user query
	$query="INSERT INTO tb_login (Username,Password,Permission) Values('$username','$password','$permission')";
	//check if the query run success;
	if($result=mysqli_query($conn,$query)){
		//messagebox will show when users and login success to insert
		echo "<script>window.location.href = 'login_page.php';
		alert('Successfully Register.');</script>";
	}else{			
		echo "<script>alert('Fails to Register')</script>";
	}
}
if (isset($_POST['login'])) {
	echo "<script>window.location.href='login_page.php'</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
</head>
<style>
body{
	background-color: lightgreen;
}

input{
	background-color:initial;
    background-color: lightgreen;
    color:green;
}
</style>
<body>
	<div class="container">
		<h1>Register</h1>
		<form action="register.php" method="post" style="margin-top: 20px;">
			<label>Username</label><input type="text" name="username" required><br>
			<label>Password</label><input type="text" name="password" required><br>
			<select name="permission">
				<option value="Seller">Seller</option>
				<option value="Buyer">Buyer</option>
			</select><br>
			<input type="submit" name="register" value="Register">
			<input type="button" name="login" value="Login" onclick="window.location.href='login_page.php'">
		</form>
	</div>
</body>
</html>