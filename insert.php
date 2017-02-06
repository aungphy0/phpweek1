<!Doctype html>
<html>
    <head>
<?php
$servername = "localhost";
$username = "root";
$password = "385565@@ap";
$dbname = "globitek";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$first = $_POST["firstname"];
$last = $_POST["lastname"];
$email = $_POST["email"];
$username = $_POST["username"];
$sql = "INSERT INTO user (firstname, lastname, email, username)
VALUES ('$first','$last','$email','$username')";

if ($conn->query($sql) === TRUE) {
    echo "Registration Success!"  . "<br>" . "New record created successfully";
    
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

   
$conn->close();
?>

</head>
</html>
