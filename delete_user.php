<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    $sql = "DELETE FROM USER WHERE ID = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<body>

<h2>Delete User</h2>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
  User ID: <input type="text" name="id"><br><br>
  <input type="submit" value="Delete">
</form>

</body>
</html>
