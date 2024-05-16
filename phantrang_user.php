<?php
include 'db.php';

// Xử lý thêm user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {
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

// Xử lý xóa user
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_user"])) {
    $id = $_POST["id"];

    $sql = "DELETE FROM USER WHERE ID = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Xử lý tìm kiếm
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Phân trang
$limit = 10; // Số lượng kết quả trên mỗi trang
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$sql_total = "SELECT COUNT(ID) AS total FROM USER WHERE name LIKE '%$search%' OR email LIKE '%$search%'";
$result_total = $conn->query($sql_total);
$total = $result_total->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

$sql = "SELECT * FROM USER WHERE name LIKE '%$search%' OR email LIKE '%$search%' LIMIT $start, $limit";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <style>
        /* Thiết lập bố cục cho danh sách người dùng */
        #user-list-container {
            float: right;
            margin-left: 20px;
            width: 40%;
        }
        #user-list-container table {
            width: 100%;
            border-collapse: collapse;
        }
        #user-list-container th, #user-list-container td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        #user-list-container th {
            background-color: #f2f2f2;
        }
        
        /* Thiết lập bố cục cho các form thêm, xóa và tìm kiếm */
        .form-container {
            float: left;
            margin-right: 20px;
            width: 40%;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add User</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <input type="hidden" name="add_user" value="1">
        Name: <input type="text" name="name"><br><br>
        Birthday: <input type="text" name="birthday"><br><br>
        Email: <input type="text" name="email"><br><br>
        City ID: <input type="text" name="city_id"><br><br>
        <input type="submit" value="Submit">
    </form>

    <h2>Delete User</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <input type="hidden" name="delete_user" value="1">
        User ID: <input type="text" name="id"><br><br>
        <input type="submit" value="Delete">
    </form>

    <h2>Search User</h2>
    <form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>">
        Search: <input type="text" name="search" value="<?php echo isset($search) ? $search : ''; ?>"><br><br>
        <input type="submit" value="Search">
    </form>
</div>

<div id="user-list-container">
    <h2>User List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Birthday</th>
            <th>Email</th>
            <th>City ID</th>
        </tr>
        <?php
        if (isset($result) && $result !== null && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>".$row["ID"]."</td><td>".$row["name"]."</td><td>".$row["birthday"]."</td><td>".$row["email"]."</td><td>".$row["city_id"]."</td></tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No results found</td></tr>";
        }
        ?>
    </table>

    <?php
    $total_pages = isset($total_pages) ? $total_pages : 1;
    ?>
    <div>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo isset($search) ? $search : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
</div>

</body>
</html>