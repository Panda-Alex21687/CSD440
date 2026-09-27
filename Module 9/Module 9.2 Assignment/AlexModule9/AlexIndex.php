<?php
/*
    Alexander Baldree
    AlexIndex.php

    Purpose:
    Main index page for the MySQLi assignment. This page provides links
    to the new search and add-record pages along with all Module 8 files.
*/
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alex MySQLi Assignment - Index</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 40px;
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

        .links {
            margin-top: 25px;
        }

        .links a {
            display: block;
            background-color: #e9e9e9;
            color: #222;
            text-decoration: none;
            border: 1px solid #bbb;
            padding: 12px;
            margin: 10px 0;
        }

        .links a:hover {
            background-color: #dcdcdc;
        }

        .note {
            margin-top: 25px;
            padding: 12px;
            background-color: #f8f8f8;
            border-left: 4px solid #777;
        }
    </style>

</head>

<body>

<div class="container">

    <h1>Alex MySQLi Assignment</h1>

    <h2>Esports Games Database</h2>

    <p>
        This page provides links to the database search form, add-record form,
        and the PHP files created in Module 8.
    </p>

    <div class="links">

        <a href="AlexQuery.php">
            Search the Esports Games Database
        </a>

        <a href="AlexForms.php">
            Add a New Esports Game
        </a>

        <a href="AlexCreateTable.php">
            Module 8 - Create Table
        </a>

        <a href="AlexPopulateTable.php">
            Module 8 - Populate Table
        </a>

        <a href="AlexQueryTable.php">
            Module 8 - Display All Records
        </a>

        <a href="AlexDropTable.php">
            Module 8 - Drop Table
        </a>

    </div>

    <div class="note">
        <strong>Database:</strong> baseball_01<br>
        <strong>Table:</strong> alex_esports_games
    </div>

</div>

</body>
</html>
