<?php
include 'db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM USER WHERE name LIKE '%$search%' OR email LIKE '%$search%'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<body>

<h2>Search User</h2>
<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
  Search: <input type="text" name="search" value="<?php echo $search; ?>"><br><br>
  <input type="submit" value="Search">
</form>

<h2>Results:</h2>
<table border="1">
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Birthday</th>
    <th>Email</th>
    <th>City ID</th>
  </tr>

<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["ID"]."</td><td>".$row["name"]."</td><td>".$row["birthday"]."</td><td>".$row["email"]."</td><td>".$row["city_id"]."</td></tr>";
    }
} else {
    echo "<tr><td colspan='5'>No results found</td></tr>";
}
$conn->close();
?>
</table>

</body>
</html>
