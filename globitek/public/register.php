<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
  $firstname = $lastname = $email = $username = "";
  $errors = array();
  // if this is a POST request, process the form
  // Hint: private/functions.php can help
  if(is_post_request()){

    // Confirm that POST values are present before accessing them.
    if(isset($_POST['first_name'])) { $firstname = $_POST['first_name']; }
    if(isset($_POST['last_name'])) { $lastname = $_POST['last_name']; }
    if(isset($_POST['email'])) { $email = $_POST['email']; }
    if(isset($_POST['username'])) { $username = $_POST['username']; }

    // Perform Validations
    // Hint: Write these in private/validation_functions.php
    if (is_blank($firstname)) {
      $errors[] = "First name cannot be blank.";
    } elseif (!has_length($firstname, array('min' => 2, 'max' => 255))) {
      $errors[] = "First name must be between 2 and 255 characters.";
    } elseif (!preg_match("/\A[A-Za-z\s\-,\.\']+\Z/",$firstname)){
      $errors[] = "First name must be only letters, space and symbols(- , . ').";
    }

    if (is_blank($lastname)) {
      $errors[] = "Last name cannot be blank.";
    } elseif (!has_length($lastname, array('min' => 2, 'max' => 255))) {
      $errors[] = "Last name must be between 2 and 255 characters.";
    } elseif (!preg_match("/\A[A-Za-z\s\-,\.\']+\Z/",$lastname)){
      $errors[] = "Last name must be only letters, space and symbols(- , . ').";
    }

    if (is_blank($email)) {
      $errors[] = "Email cannot be blank.";
    } elseif (!has_valid_email_format($email)) {
      $errors[] = "Email must be a valid format.";
    }
      $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if (is_blank($username)) {
      $errors[] = "Username cannot be blank.";
    } elseif (!has_length($username, array('min' => 8, 'max' => 255))) {
      $errors[] = "Username must be be at least 8 characters.";
    } elseif (!preg_match("/\A[A-Za-z0-9\_]+\Z/",$username)){
      $errors[] = "Username must be only letters, numbers and symbols.";
    } elseif (mysqli_num_rows(mysqli_query($connection,"SELECT *FROM users WHERE username='$username'")) > 0){
      $errors[] = "Username already exist.";
    }
  //  $query = mysqli_query("SELECT username FROM users WHERE username='".$_POST['username']."'");
  //  if(mysqli_num_rows($username) > 0){
    //  $errors[] = "Username already exist.";
  //  }


    function test_input($data){
        $data = htmlspecialchars($data);
        $data = urlencode($data);
        $data = rawurlencode($data);
        return $data;
    }

      // if there were no errors, submit data to database
      // Write SQL INSERT statement
      // $sql = "";
      if (empty($errors)) {
        $created_at = date("Y-m-d H:i:s");
        $sql = "INSERT INTO users ";
        $sql .= "(first_name, last_name, email, username,created_at) ";
        $sql .= "VALUES (";
        $sql .= "'" . $firstname . "',";
        $sql .= "'" . $lastname . "',";
        $sql .= "'" . $email . "',";
        $sql .= "'" . $username . "',";
        $sql .= "'" . $created_at . "'";
        $sql .= ")";

      // For INSERT statments, $result is just true/false
      $result = db_query($db, $sql);
        if($result) {
           db_close($db);
           redirect_to('registration_success.php');
       } else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
        echo db_error($db);
        db_close($db);
         exit;
       }
    }
  }
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php echo display_errors($errors); ?>


  <form action="register.php" method="post">
   First name:<br>
   <input type="text" name="first_name" value="<?php echo h($firstname); ?>" /><br />
   Last name:<br>
   <input type="text" name="last_name" value="<?php echo h($lastname); ?>" /><br />
   Email:<br>
   <input type="text" name="email" value="<?php echo h($email); ?>" /><br />
   Username:<br>
   <input type="text" name="username" value="<?php echo h($username); ?>" /><br />

   <br />
   <input type="submit" name="submit" value="Submit" />
 </form>


</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
