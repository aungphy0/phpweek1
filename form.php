<!DOCTYPE HTML>  
<html>
<head>
<style>

</style>
</head>
<body>  

<?php
// define variables and set to empty values
$firstErr = $emailErr = $lastErr = $userErr = "";
$first = $email = $last = $username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["firstname"])) {
    $firstErr = "First Name is required";
  } else {
    $first = test_input($_POST["firstname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$first)) {
      $firstErr = "must be only letters!"; 
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
  }
    
  if(empty($_POST["lastname"])){
     $lastErr = "Last Name is required";
  }else{
     $last = test_input($_POST["lastname"]);
    if (!preg_match("/^[a-zA-Z ] *$/",$last)) {
      $lastErr = "must be only letters!"; 
    }
  }

    if(empty($_POST["username"])){
     $userErr = "User Name is required";
  }else{
     $username = test_input($_POST["username"]);
    if (!preg_match("/^[a-zA-Z0-9 ]{8,} *$/",$last)) {
      $userErr = "User name must 8 characters long with letters, digits and white space!"; 
    }
  }
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>Register</h2>
<p>Register to become a Globitek parter.</p>
<form method="post" action="insert.php">  
  Frist name:<br> <input type="text" name="firstname" value="<?php echo $first;?>">
  <span class="error"> <?php echo $firstErr;?></span>
  <br><br>
  Last name:<br> <input type="text" name="lastname" value="<?php echo $last;?>">
  <span class="error"> <?php echo $lastErr;?></span>
  <br><br>
  E-mail:<br> <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error"> <?php echo $emailErr;?></span>
  <br><br>
  Username:<br> <input type="text" name="username" value="<?php echo $username;?>">
  <span class="error"> <?php echo $userErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>




</body>
</html>
