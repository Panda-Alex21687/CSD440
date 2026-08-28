<?php
/*
 * Alexander Baldree
 * AlexPalindrome.php
 * Palindrome Program
 * CSD440
 *
 * 
 * This program tests six different strings to determine whether
 * each string is a palindrome. A palindrome reads the same
 * forward and backward.
 *
 * The program displays the original string, the reversed string,
 * and the result of the palindrome test.
 */

/*
 * testPalindrome
 * Determines whether a string is a palindrome.
 * $text - The string that will be tested.
 * Returns true if the string is a palindrome and false if it is not.
 */
function testPalindrome($text)
{
    // Convert the string to lowercase so capitalization does not affect the test.
    $cleanText = strtolower($text);

    // Remove spaces and non-alphanumeric characters.
    $cleanText = preg_replace("/[^a-z0-9]/", "", $cleanText);

    // Reverse the cleaned string.
    $reversedText = strrev($cleanText);

    // Compare the original cleaned string to the reversed string.
    return $cleanText === $reversedText;
}

/*
 * Function: displayPalindromeTest
 * Purpose: Displays the original string, reversed string,
 * and whether the string is a palindrome.
 * Parameter: $text - The string being tested.
 */
function displayPalindromeTest($text)
{
    // Clean the string for an accurate comparison.
    $cleanText = strtolower($text);
    $cleanText = preg_replace("/[^a-z0-9]/", "", $cleanText);

    // Reverse the cleaned string.
    $reversedText = strrev($cleanText);

    // Determine the result using the palindrome function.
    if (testPalindrome($text)) {
        $result = "Yes - This is a palindrome.";
    } else {
        $result = "No - This is not a palindrome.";
    }

    // Display the results.
    echo "<div class='result'>";
    echo "<p><strong>Original String:</strong> " . htmlspecialchars($text) . "</p>";
    echo "<p><strong>Forward:</strong> " . htmlspecialchars($cleanText) . "</p>";
    echo "<p><strong>Backward:</strong> " . htmlspecialchars($reversedText) . "</p>";
    echo "<p><strong>Result:</strong> " . $result . "</p>";
    echo "</div>";
}

// Six strings used for testing.
// Three are palindromes and three are not.
$strings = array(
    "Racecar",
    "Level",
    "Never odd or even",
    "Computer",
    "Programming",
    "Bellevue"
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alex Baldree - Palindrome Test</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        .description {
            text-align: center;
            margin-bottom: 30px;
        }

        .result {
            border: 1px solid #cccccc;
            border-left: 5px solid #333333;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .result p {
            margin: 7px 0;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Palindrome Test Program</h1>

        <p class="description">
            This program tests six strings to determine whether each one
            reads the same forward and backward.
        </p>

        <?php
        /*
         * Loop through each string in the array and send it to
         * the displayPalindromeTest function.
         */
        foreach ($strings as $string) {
            displayPalindromeTest($string);
        }
        ?>

    </div>

</body>

</html>