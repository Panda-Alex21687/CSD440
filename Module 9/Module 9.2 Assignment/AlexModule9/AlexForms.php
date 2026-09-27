<?php
/*
    Alexander Baldree
    AlexForms.php

    Purpose:
    Displays a form that allows the user to add a new record to the
    alex_esports_games table. MySQLi prepared statements are used for
    the INSERT query.
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

// Default values used by the form
$gameTitle = "";
$genre = "";
$platform = "";
$releaseYear = "";
$teamSize = "";
$personalRating = "";
$teamBased = "";
$message = "";
$success = false;

// Process the form after it is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $gameTitle = trim($_POST["game_title"] ?? "");
    $genre = trim($_POST["genre"] ?? "");
    $platform = trim($_POST["platform"] ?? "");
    $releaseYear = trim($_POST["release_year"] ?? "");
    $teamSize = trim($_POST["team_size"] ?? "");
    $personalRating = trim($_POST["personal_rating"] ?? "");
    $teamBased = trim($_POST["team_based"] ?? "");

    // Validate that all fields contain values
    if (
        $gameTitle === "" ||
        $genre === "" ||
        $platform === "" ||
        $releaseYear === "" ||
        $teamSize === "" ||
        $personalRating === "" ||
        $teamBased === ""
    ) {

        $message = "Please complete every field.";

    } elseif (
        !filter_var($releaseYear, FILTER_VALIDATE_INT) ||
        (int)$releaseYear < 1950 ||
        (int)$releaseYear > 2100
    ) {

        $message = "Please enter a valid release year.";

    } elseif (
        !filter_var($teamSize, FILTER_VALIDATE_INT) ||
        (int)$teamSize < 1
    ) {

        $message = "Team size must be a whole number greater than zero.";

    } elseif (
        !is_numeric($personalRating) ||
        (float)$personalRating < 0 ||
        (float)$personalRating > 10
    ) {

        $message = "Personal rating must be between 0 and 10.";

    } elseif ($teamBased !== "0" && $teamBased !== "1") {

        $message = "Please select whether the game is team based.";

    } else {

        // SQL INSERT statement
        $sql = "INSERT INTO alex_esports_games
                (game_title, genre, platform, release_year, team_size, personal_rating, team_based)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Prepare statement
        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            die("Error preparing statement: " . mysqli_error($conn));
        }

        // Convert numeric values to the appropriate PHP types
        $releaseYearNumber = (int)$releaseYear;
        $teamSizeNumber = (int)$teamSize;
        $ratingNumber = (float)$personalRating;
        $teamBasedNumber = (int)$teamBased;

        /*
            Bind values to the prepared statement.
            s = string
            i = integer
            d = double
        */
        mysqli_stmt_bind_param(
            $stmt,
            "sssiidi",
            $gameTitle,
            $genre,
            $platform,
            $releaseYearNumber,
            $teamSizeNumber,
            $ratingNumber,
            $teamBasedNumber
        );

        // Execute the INSERT statement
        if (mysqli_stmt_execute($stmt)) {

            $message = "The new game was added successfully.";
            $success = true;

            // Clear the form after a successful insert
            $gameTitle = "";
            $genre = "";
            $platform = "";
            $releaseYear = "";
            $teamSize = "";
            $personalRating = "";
            $teamBased = "";

        } else {

            $message = "Error adding record: " . mysqli_stmt_error($stmt);
        }

        // Close prepared statement
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alex MySQLi Assignment - Add Record</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 30px;
        }

        .container {
            background-color: white;
            padding: 25px;
            max-width: 750px;
            margin: auto;
            border: 1px solid #ccc;
        }

        h1,
        h2 {
            text-align: center;
        }

        form {
            margin-top: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .message {
            text-align: center;
            font-weight: bold;
            padding: 12px;
            margin-top: 20px;
            background-color: #eeeeee;
        }

        .success {
            background-color: #e7f6e7;
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

    <h2>Add an Esports Game</h2>

    <?php if ($message !== ""): ?>

        <p class="message <?php echo $success ? "success" : ""; ?>">
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php endif; ?>

    <form action="AlexForms.php" method="post">

        <label for="game_title">
            Game Title:
        </label>

        <input
            type="text"
            id="game_title"
            name="game_title"
            maxlength="100"
            value="<?php echo htmlspecialchars($gameTitle); ?>"
            required
        >

        <label for="genre">
            Genre:
        </label>

        <input
            type="text"
            id="genre"
            name="genre"
            maxlength="75"
            value="<?php echo htmlspecialchars($genre); ?>"
            required
        >

        <label for="platform">
            Platform:
        </label>

        <input
            type="text"
            id="platform"
            name="platform"
            maxlength="100"
            value="<?php echo htmlspecialchars($platform); ?>"
            required
        >

        <label for="release_year">
            Release Year:
        </label>

        <input
            type="number"
            id="release_year"
            name="release_year"
            min="1950"
            max="2100"
            value="<?php echo htmlspecialchars($releaseYear); ?>"
            required
        >

        <label for="team_size">
            Team Size:
        </label>

        <input
            type="number"
            id="team_size"
            name="team_size"
            min="1"
            value="<?php echo htmlspecialchars($teamSize); ?>"
            required
        >

        <label for="personal_rating">
            Personal Rating:
        </label>

        <input
            type="number"
            id="personal_rating"
            name="personal_rating"
            min="0"
            max="10"
            step="0.1"
            value="<?php echo htmlspecialchars($personalRating); ?>"
            required
        >

        <label for="team_based">
            Team Based:
        </label>

        <select
            id="team_based"
            name="team_based"
            required
        >

            <option value="">
                Select an option
            </option>

            <option
                value="1"
                <?php echo $teamBased === "1" ? "selected" : ""; ?>
            >
                Yes
            </option>

            <option
                value="0"
                <?php echo $teamBased === "0" ? "selected" : ""; ?>
            >
                No
            </option>

        </select>

        <input
            type="submit"
            value="Add Record"
        >

    </form>

    <div class="navigation">

        <a href="AlexIndex.php">
            Return to Index
        </a>

    </div>

</div>

</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
