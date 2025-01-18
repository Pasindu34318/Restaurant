<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Restaurant";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql_chefs = "CREATE TABLE IF NOT EXISTS ChefDetails (
    id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    Level VARCHAR(20) NOT NULL
)";

if ($conn->query($sql_chefs) === TRUE) {
    //echo "Chefs table created successfully<br>";
} else {
    echo "Error creating chefs table: " . $conn->error . "<br>";
}

$sql_products = "CREATE TABLE IF NOT EXISTS ProductDetails (
    pid INT PRIMARY KEY AUTO_INCREMENT,
    pname VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL
)";

if ($conn->query($sql_products) === TRUE) {
    //echo "Products table created successfully<br>";
} else {
    echo "Error creating products table: " . $conn->error . "<br>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="mainContainer">


    <div class="tableContainer">
    <table>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Level</th>
            </tr>
            <?php
            $sql = "SELECT * FROM ChefDetails";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["first_name"] . "</td>";
                    echo "<td>" . $row["last_name"] . "</td>";
                    echo "<td>" . $row["Level"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No chefs found</td></tr>";
            }
            ?>
        </table>
        <table>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
            <?php
            $sql = "SELECT * FROM ProductDetails";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["pid"] . "</td>";
                    echo "<td>" . $row["pname"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No products found</td></tr>";
            }
            ?>
        </table>
    </div>

    <div>

    <div class="formContainer">
        <form action="index.php" method="post">
            <h1>chef form</h1>
            <label for="">First Name</label>
            <input type="text" name="first_name" id="">
            <label for="">Last Name</label>
            <input type="text" name="last_name" id="">
            <label for="">level</label>
            <input type="text" name="level" id="">
            <input type="submit" value="submit">
        </form>
        <form action="index.php" method="post">
            <h1>product form</h1>
            <label for="">Product Name</label>
            <input type="text" name="pname" id="">
            <label for="">Description</label>
            <input type="text" name="description" id="">
            <label for="">Price</label>
            <input type="text" name="price" id="">
            <input type="submit" value="submit">
        </form>

    </div>
</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["first_name"])) {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $level = $_POST["level"];
    $sql = "INSERT INTO ChefDetails (first_name, last_name, Level) VALUES ('$first_name', '$last_name', '$level')";
    if ($conn->query($sql) === TRUE) {
        //echo "New chef added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pname"])) {
    $pname = $_POST["pname"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $sql = "INSERT INTO ProductDetails (pname, description, price) VALUES ('$pname', '$description', '$price')";
    if ($conn->query($sql) === TRUE) {
        //echo "New product added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}
$conn->close();
?>
