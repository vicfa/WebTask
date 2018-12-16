<?php
$msg = "";
if( isset($_POST['loginSubmit']) ){
	$id = $_POST['id1'];
	$name = $_POST['id2'];
	$email = $_POST['id3'];
	$gender = $_POST['id4'];


	$servername = "localhost";  // server name or address wich is hosting the website
	$username = "root"; // user id of that server 
	$password = ""; // password for the given username 
	$dbname = "database1"; // data base name created for the website 

	// Create connection to database with the help of given details
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	// Check connection if connection is success or not ...if not then throw an error 
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

	if ($conn->query("INSERT INTO table1 VALUES('$id','$name','$email','$gender')") === TRUE) {
        $msg= "Data stored success !! Check your database";

    } else {
        $msg= "Something Wrong happend !!";
    }

}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<script>

		// initialize and setup facebook js sdk
		window.fbAsyncInit = function() {
		    FB.init({
		      appId      : '512492955923544',
		      xfbml      : true,
		      version    : 'v2.5'
		    });

		    
		    
		    FB.getLoginStatus(function(response) {
		    	if (response.status === 'connected') {
		    		displayData();
		    	} else if (response.status === 'not_authorized') {
		    		msg1();
		    	} else {
		    		msg2();
		    		document.getElementById('login1').click();
		    	}
		    });
		};
		(function(d, s, id){
		    var js, fjs = d.getElementsByTagName(s)[0];
		    if (d.getElementById(id)) {return;}
		    js = d.createElement(s); js.id = id;
		    js.src = "//connect.facebook.net/en_US/sdk.js";
		    fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		
		// login with facebook with extra permissions
		function login() {
			FB.login(function(response) {
				if (response.status === 'connected') {
				    displayData();	
		    	} else if (response.status === 'not_authorized') {
		    		msg1();
		    	} else {
		    		msg2();
		    	}
			}, {scope: 'email'});
		}
		
		function displayData(){
			document.getElementById('status').innerHTML = 'Logged in as valid Test User';
			FB.api('/me', 'GET', {"fields":"id,name,birthday,email,gender,posts{permalink_url},photos{link},videos{permalink_url}"}, function(response) {
				document.getElementById("loginas").innerHTML = response.name;
				document.getElementById("id1").value = response.id;
				document.getElementById("id2").value = response.name;
				document.getElementById("id3").value = response.email;
				document.getElementById("id4").value = response.gender;
				document.getElementById("dataView").hidden = false;
				
			});
		}
		function msg1(){
			document.getElementById('status').innerHTML = 'You are not a valid Test User';
				}
		function msg2(){
			document.getElementById('status').innerHTML = 'No Log in is Completed yet';
		}
		
	</script>

<center>
	<div style="border: solid; border-width: 3px;border-color: red;width: 400px;">
		<STRONG id="status"></STRONG>
		<hr>
		<strong>Logged in as <big style="color: green;" id="loginas">Null</big></strong>
		<hr>
		<button onclick="login();" id="login1">Login</button>
		<hr>
		<h2 style="color: red;"> User's data: </h2>
		<div style="text-align: left;" hidden="true" id="dataView">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
				User Id : <input type="text" name="id1" id="id1" disabled="true"><br>
				User Name : <input type="text" name="id2" id="id2" disabled="true"><br>
				Email : <input type="text" name="id3" id="id3" disabled="true"><br>
				Gender : <input type="text" name="id4" id="id4" disabled="true"><br>
				<input type="submit" name="submit" id="submit1" value="Store">
				<strong><?php echo $msg ; ?></strong>
			</form>
		</div>
	</div>	
	
</center>
</body>
</html>