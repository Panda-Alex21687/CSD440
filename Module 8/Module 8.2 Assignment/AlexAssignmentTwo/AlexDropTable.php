<?php
/*
    Alexander Baldree
    AlexAssignmentTwo
    AlexDropTable.php
    Drops the alex_esports_games table
             from the baseball_01 database.
*/

// Database connection information
$host = "localhost";
$username = "student1";
$password = "pass";
$database = "baseball_01";

// Connect to MySQL
$conn = mysqli_connect($host, $username, $password, $database);

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// SQL statement to drop the table
$sql = "DROP TABLE IF EXISTS alex_esports_games";

// Run query
if (mysqli_query($conn, $sql)) {
    $message = "The alex_esports_games table was dropped successfully.";
} else {
    $message = "Error dropping table: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alex Assignment Two - Drop Table</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 40px;
        }

        .container {
            background-color: white;
            padding: 25px;
            max-width: 700px;
            margin: auto;
            border: 1px solid #ccc;
        }

        h1 {
            text-align: center;
        }

        p {
            text-align: center;
            font-size: 18px;
        }
    </style>

</head>

<body>

<div class="container">

    <h1>Alex Assignment Two</h1>

    <h2>Drop Table</h2>

    <p>
        <?php echo htmlspecialchars($message); ?>
    </p>

</div>

</body>
</html>