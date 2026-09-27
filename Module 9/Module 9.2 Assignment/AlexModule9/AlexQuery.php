<?php
/*
    Alexander Baldree
    AlexQuery.php

    Purpose:
    Allows the user to search the alex_esports_games table using form input.
    MySQLi prepared statements are used so user input is not placed directly
    into the SQL statement.
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

// Default values
$searchField = "";
$searchValue = "";
$result = null;
$message = "";

// Allowed fields prevent an invalid or unexpected column name
$allowedFields = [
    "game_title" => "Game Title",
    "genre" => "Genre",
    "platform" => "Platform",
    "release_year" => "Release Year",
    "team_size" => "Team Size",
    "personal_rating" => "Personal Rating",
    "team_based" => "Team Based"
];

// Process the form only after the user submits it
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $searchField = $_POST["search_field"] ?? "";
    $searchValue = trim($_POST["search_value"] ?? "");

    // Validate the selected field
    if (!array_key_exists($searchField, $allowedFields)) {

        $message = "Please select a valid search field.";

    } elseif ($searchValue === "") {

        $message = "Please enter a value to search for.";

    } else {

        /*
            Text fields use LIKE so partial matches work.
            Numeric fields use an exact match.
        */
        if (in_array($searchField, ["game_title", "genre", "platform"], true)) {

            $sql = "SELECT *
                    FROM alex_esports_games
                    WHERE $searchField LIKE ?
                    ORDER BY personal_rating DESC, game_title ASC";

            $stmt = mysqli_prepare($conn, $sql);

            if (!$stmt) {
                die("Error preparing statement: " . mysqli_error($conn));
            }

            $searchParameter = "%" . $searchValue . "%";

            mysqli_stmt_bind_param(
                $stmt,
                "s",
                $searchParameter
            );

        } elseif ($searchField === "personal_rating") {

            if (!is_numeric($searchValue)) {
                $message = "Personal rating must be a number.";
            } else {

                $sql = "SELECT *
                        FROM alex_esports_games
                        WHERE personal_rating = ?
                        ORDER BY game_title ASC";

                $stmt = mysqli_prepare($conn, $sql);

                if (!$stmt) {
                    die("Error preparing statement: " . mysqli_error($conn));
                }

                $rating = (float)$searchValue;

                mysqli_stmt_bind_param(
                    $stmt,
                    "d",
                    $rating
                );
            }

        } else {

            if (!filter_var($searchValue, FILTER_VALIDATE_INT) && $searchValue !== "0") {
                $message = "This search field requires a whole number.";
            } else {

                $sql = "SELECT *
                        FROM alex_esports_games
                        WHERE $searchField = ?
                        ORDER BY personal_rating DESC, game_title ASC";

                $stmt = mysqli_prepare($conn, $sql);

                if (!$stmt) {
                    die("Error preparing statement: " . mysqli_error($conn));
                }

                $number = (int)$searchValue;

                mysqli_stmt_bind_param(
                    $stmt,
                    "i",
                    $number
                );
            }
        }

        // Run the query only if validation did not create an error message
        if ($message === "") {

            if (!$stmt) {
                die("Error preparing statement: " . mysqli_error($conn));
            }

            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if (!$result) {
                die("Query failed: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($result) === 0) {
                $message = "No matching records were found.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alex MySQLi Assignment - Query</title>

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

        form {
            max-width: 650px;
            margin: 25px auto;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        select,
        input[type="text"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            margin-top: 18px;
            padding: 10px 20px;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 25px;
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

        .message {
            text-align: center;
            font-weight: bold;
            margin: 20px 0;
        }

        .navigation {
            margin-top: 25px;
            text-align: center;
        }

        .navigation a {
            color: #222;
        }
    </style>

</head>

<body>

<div class="container">

    <h1>Alex MySQLi Assignment</h1>

    <h2>Search Esports Games</h2>

    <form action="AlexQuery.php" method="post">

        <label for="search_field">
            Select a field to search:
        </label>

        <select
            id="search_field"
            name="search_field"
            required
        >

            <option value="">
                Select a field
            </option>

            <?php foreach ($allowedFields as $field => $label): ?>

                <option
                    value="<?php echo htmlspecialchars($field); ?>"
                    <?php
                    if ($searchField === $field) {
                        echo "selected";
                    }
                    ?>
                >
                    <?php echo htmlspecialchars($label); ?>
                </option>

            <?php endforeach; ?>

        </select>

        <label for="search_value">
            Enter a search value:
        </label>

        <input
            type="text"
            id="search_value"
            name="search_value"
            value="<?php echo htmlspecialchars($searchValue); ?>"
            required
        >

        <input
            type="submit"
            value="Search"
        >

    </form>

    <?php if ($message !== ""): ?>

        <p class="message">
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php endif; ?>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>

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

            <?php while ($row = mysqli_fetch_assoc($result)): ?>

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

    <?php endif; ?>

    <div class="navigation">

        <a href="AlexIndex.php">
            Return to Index
        </a>

    </div>

</div>

</body>
</html>

<?php
// Free result memory when a result exists
if ($result) {
    mysqli_free_result($result);
}

// Close prepared statement when one was created
if (isset($stmt) && $stmt) {
    mysqli_stmt_close($stmt);
}

// Close database connection
mysqli_close($conn);
?>
