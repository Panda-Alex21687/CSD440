<?php
/*
    Alexander Baldree
    AlexAssignmentTwo
    AlexQueryTable.php
    Queries the alex_esports_games table
             and displays all records.
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

// SQL query
$sql = "SELECT *
        FROM alex_esports_games
        ORDER BY personal_rating DESC, game_title ASC";

// Run query
$result = mysqli_query($conn, $sql);

// Check query
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Get number of records
$numberOfRows = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alex Assignment Two - Query Table</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 30px;
        }

        .container {
            background-color: white;
            padding: 25px;
            max-width: 1100px;
            margin: auto;
            border: 1px solid #ccc;
        }

        h1,
        h2 {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #ddd;
        }

        .record-count {
            text-align: center;
            font-size: 18px;
        }
    </style>

</head>

<body>

<div class="container">

    <h1>Alex Assignment Two</h1>

    <h2>Esports Games Database</h2>

    <p class="record-count">
        Number of records found:
        <?php echo $numberOfRows; ?>
    </p>

    <?php if ($numberOfRows > 0): ?>

        <table>

            <tr>
                <th>ID</th>
                <th>Game Title</th>
                <th>Genre</th>
                <th>Platform</th>
                <th>Release Year</th>
                <th>Team Size</th>
                <th>Rating</th>
                <th>Team Based</th>
            </tr>

            <?php while ($row = mysqli_fetch_array($result)): ?>

                <tr>

                    <td>
                        <?php echo htmlspecialchars($row["game_id"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["game_title"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["genre"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["platform"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["release_year"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["team_size"]); ?>
                    </td>

                    <td>
                        <?php echo htmlspecialchars($row["personal_rating"]); ?>/10
                    </td>

                    <td>
                        <?php
                        if ($row["team_based"] == 1) {
                            echo "Yes";
                        } else {
                            echo "No";
                        }
                        ?>
                    </td>

                </tr>

            <?php endwhile; ?>

        </table>

    <?php else: ?>

        <p>No records were found.</p>

    <?php endif; ?>

</div>

</body>
</html>

<?php

// Free query result
mysqli_free_result($result);

// Close database connection
mysqli_close($conn);

?>