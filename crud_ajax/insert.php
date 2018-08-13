<?php
$connect = mysqli_connect("localhost", "root", "", "testing");
if(isset($_POST["name"], $_POST["company"], $_POST["contact"], $_POST["email"]))
{
 $name = mysqli_real_escape_string($connect, $_POST["name"]);
 $company = mysqli_real_escape_string($connect, $_POST["company"]);
 $contact = mysqli_real_escape_string($connect, $_POST["contact"]);
 $email = mysqli_real_escape_string($connect, $_POST["email"]);

 $query = "INSERT INTO user(name, company, contact, email) VALUES('$name', '$company', '$contact', '$email')";
 if(mysqli_query($connect, $query))
 {
  echo 'Contact Inserted';
 }
}
?>
