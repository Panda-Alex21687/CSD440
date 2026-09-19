<?php
/*
    Alexander Baldree
    AlexAssignmentTwo
    AlexPopulateTable.php
    Populates the alex_esports_games table
             with video game and esports records.
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

// Clear existing records so duplicate records are not created
$clearTable = "DELETE FROM alex_esports_games";

if (!mysqli_query($conn, $clearTable)) {
    die("Error clearing table: " . mysqli_error($conn));
}

// Reset AUTO_INCREMENT
mysqli_query($conn, "ALTER TABLE alex_esports_games AUTO_INCREMENT = 1");

// SQL INSERT statement
$sql = "INSERT INTO alex_esports_games
        (game_title, genre, platform, release_year, team_size, personal_rating, team_based)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

// Prepare statement
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

// Records to insert
$games = [
    ["Rocket League", "Sports", "Multi-platform", 2015, 3, 10.0, 1],
    ["Valorant", "First-Person Shooter", "PC/Console", 2020, 5, 8.5, 1],
    ["League of Legends", "MOBA", "PC", 2009, 5, 8.0, 1],
    ["Overwatch 2", "Hero Shooter", "Multi-platform", 2022, 5, 8.0, 1],
    ["Fortnite", "Battle Royale", "Multi-platform", 2017, 4, 8.5, 1],
    ["Apex Legends", "Battle Royale", "Multi-platform", 2019, 3, 8.0, 1],
    ["Counter-Strike 2", "First-Person Shooter", "PC", 2023, 5, 8.5, 1],
    ["Rainbow Six Siege", "Tactical Shooter", "Multi-platform", 2015, 5, 8.5, 1],
    ["Dota 2", "MOBA", "PC", 2013, 5, 7.5, 1],
    ["Minecraft", "Sandbox", "Multi-platform", 2011, 8, 9.0, 0]
];

$recordsAdded = 0;

// Insert each record
foreach ($games as $game) {

    $gameTitle = $game[0];
    $genre = $game[1];
    $platform = $game[2];
    $releaseYear = $game[3];
    $teamSize = $game[4];
    $personalRating = $game[5];
    $teamBased = $game[6];

    mysqli_stmt_bind_param(
        $stmt,
        "sssiidi",
        $gameTitle,
        $genre,
        $platform,
        $releaseYear,
        $teamSize,
        $personalRating,
        $teamBased
    );

    if (mysqli_stmt_execute($stmt)) {
        $recordsAdded++;
    }
}

// Close prepared statement
mysqli_stmt_close($stmt);

// Close connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alex Assignment Two - Populate Table</title>

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

    <h2>Populate Table</h2>

    <p>
        <?php echo $recordsAdded; ?> records were successfully added.
    </p>

</div>

</body>
</html>