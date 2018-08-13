
<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" type="text/css" href="style1.css">
</head>
<body>
  <div class="header" style="background: black;" >
  	<h2 >Login</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('error.php'); ?>
  	<div class="input-group">
  		<label>Email Address</label>
  		<input type="text" name="email" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user" style="background: grey;">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
  </form>
</body>
</html>