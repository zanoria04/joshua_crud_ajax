<?php
session_start();

// initializing variables
$email    = "";
$errors = array(); 

// connect to the database
$connect = mysqli_connect("localhost", "root", "", "testing");




// REGISTER USER
if (isset($_POST['reg_user'])) {

  // receive all input values from the form
  $email = mysqli_real_escape_string($connect, $_POST['email']);
  $password_1 = mysqli_real_escape_string($connect, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($connect, $_POST['password_2']);




  // form validation: to ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }




  // checking the database to make sure 
  // a user does not already exist with the same email and/or password
  $user_check_query = "SELECT * FROM login_account WHERE email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }





  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1); //encrypt the password before saving in the database

  	$query = "INSERT INTO login_account (email, password) 
  			  VALUES('$email', '$password')";
  	mysqli_query($connect, $query);
  	$_SESSION['email'] = $email;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}






// LOGIN USER
if (isset($_POST['login_user'])) {
  $email = mysqli_real_escape_string($connect, $_POST['email']);
  $password = mysqli_real_escape_string($connect, $_POST['password']);

  if (empty($email)) {
    array_push($errors, "Email is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    $password = md5($password); //encrypt the password before saving in the database
    
    $query = "SELECT * FROM login_account WHERE email='$email' AND password='$password'";
    $results = mysqli_query($connect, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['email'] = $email;
      $_SESSION['success'] = "You are now logged in!";
      header('location: index.php');
    }else {
      array_push($errors, "Wrong email/password combination");
    }
  }
}

?>