<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $birthday = $_POST["birthday"];
    $email = $_POST["email"];
    $city_id = $_POST["city_id"];

    $sql = "INSERT INTO USER (name, birthday, email, city_id) VALUES ('$name', '$birthday', '$email', '$city_id')";

    if ($conn->query($sql) === TRUE) {
        echo "New user added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<body>

<h2>Add User</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  Name: <input type="text" name="name"><br><br>
  Birthday: <input type="text" name="birthday"><br><br>
  Email: <input type="text" name="email"><br><br>
  City ID: <input type="text" name="city_id"><br><br>
  <input type="submit" value="Submit">
</form>

</body>
</html>
