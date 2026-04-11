<?php
$host = "localhost";
$user = "labuser";
$password = "Lab123456!";
$dbname = "wk13lab";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = "";
$result = null;

if (isset($_GET['firstname'])) {
    $search = $_GET['firstname'];

    // Vulnerable SQL query on purpose
    $sql = "SELECT * FROM users WHERE firstname = '$search' AND active = 1";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>getusers_1</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 8px;
            width: 250px;
        }
        button {
            padding: 8px 12px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>User Search - Vulnerable Version</h2>

    <form method="GET" action="">
        <label for="firstname">Enter first name:</label>
        <input type="text" name="firstname" id="firstname" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <?php if ($result !== null): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Active</th>
            </tr>

            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['firstname']; ?></td>
                        <td><?php echo $row['lastname']; ?></td>
                        <td><?php echo $row['active']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No results found.</td>
                </tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>
</body>
</html>

<?php
$conn->close();
?>
