<?php
/*
 * AlexJSON.php
 * Alexander Baldree
 * 10/01/26
 * CSD440
 *
 * Purpose:
 * This program displays a form that collects eight different
 * pieces of information from the user. When the form is submitted,
 * PHP validates the input and uses json_encode() to convert the
 * submitted information into JSON format.
 *
 * If all required information is entered correctly, the JSON data
 * is displayed in a formatted output area. If there is a problem
 * with the submitted information, an error message is displayed.
 */

// Variables used to store output messages.
$jsonOutput = "";
$errorMessage = "";

// Check to see if the form was submitted using POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and clean the submitted form data.
    $firstName = trim($_POST["firstName"] ?? "");
    $lastName = trim($_POST["lastName"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $age = trim($_POST["age"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $city = trim($_POST["city"] ?? "");
    $state = trim($_POST["state"] ?? "");
    $favoriteLanguage = trim($_POST["favoriteLanguage"] ?? "");

    // Verify that none of the required fields are empty.
    if (
        empty($firstName) ||
        empty($lastName) ||
        empty($email) ||
        empty($age) ||
        empty($phone) ||
        empty($city) ||
        empty($state) ||
        empty($favoriteLanguage)
    ) {
        $errorMessage = "Error: Please complete all eight fields.";
    }

    // Verify that the email address is valid.
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Error: Please enter a valid email address.";
    }

    // Verify that age contains a valid number.
    elseif (!filter_var($age, FILTER_VALIDATE_INT) || $age < 1) {
        $errorMessage = "Error: Please enter a valid age.";
    }

    else {

        /*
         * Store the submitted information in an associative array.
         * This array will be converted into JSON.
         */
        $userData = [
            "firstName" => $firstName,
            "lastName" => $lastName,
            "email" => $email,
            "age" => (int)$age,
            "phone" => $phone,
            "city" => $city,
            "state" => $state,
            "favoriteProgrammingLanguage" => $favoriteLanguage
        ];

        /*
         * Convert the PHP array into JSON.
         * JSON_PRETTY_PRINT makes the output easier to read.
         */
        $jsonOutput = json_encode($userData, JSON_PRETTY_PRINT);

        // Check for a JSON encoding error.
        if ($jsonOutput === false) {
            $errorMessage = "Error: The submitted data could not be converted to JSON.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Alex JSON Form</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            margin-top: 20px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }

        .output {
            margin-top: 25px;
            padding: 15px;
            background-color: #eeeeee;
            border-left: 5px solid #333;
        }

        .error {
            margin-top: 25px;
            padding: 15px;
            background-color: #ffe6e6;
            border-left: 5px solid red;
            color: #990000;
        }

        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>JSON User Information Form</h1>

    <p>
        Please complete all eight fields below. After the form is submitted,
        the information will be converted into JSON format.
    </p>

    <form method="post" action="">

        <!-- Field 1 -->
        <label for="firstName">First Name:</label>
        <input
            type="text"
            id="firstName"
            name="firstName"
            required
        >

        <!-- Field 2 -->
        <label for="lastName">Last Name:</label>
        <input
            type="text"
            id="lastName"
            name="lastName"
            required
        >

        <!-- Field 3 -->
        <label for="email">Email Address:</label>
        <input
            type="email"
            id="email"
            name="email"
            required
        >

        <!-- Field 4 -->
        <label for="age">Age:</label>
        <input
            type="number"
            id="age"
            name="age"
            min="1"
            required
        >

        <!-- Field 5 -->
        <label for="phone">Phone Number:</label>
        <input
            type="tel"
            id="phone"
            name="phone"
            required
        >

        <!-- Field 6 -->
        <label for="city">City:</label>
        <input
            type="text"
            id="city"
            name="city"
            required
        >

        <!-- Field 7 -->
        <label for="state">State:</label>
        <input
            type="text"
            id="state"
            name="state"
            required
        >

        <!-- Field 8 -->
        <label for="favoriteLanguage">
            Favorite Programming Language:
        </label>

        <select
            id="favoriteLanguage"
            name="favoriteLanguage"
            required
        >
            <option value="">Select a language</option>
            <option value="Java">Java</option>
            <option value="PHP">PHP</option>
            <option value="JavaScript">JavaScript</option>
            <option value="Python">Python</option>
            <option value="C#">C#</option>
            <option value="C++">C++</option>
        </select>

        <input type="submit" value="Convert to JSON">

    </form>

    <?php
    /*
     * Display the formatted JSON result when the
     * form has been successfully processed.
     */
    if (!empty($jsonOutput)) {
        echo '<div class="output">';
        echo '<h2>JSON Output</h2>';
        echo '<pre>';
        echo htmlspecialchars($jsonOutput);
        echo '</pre>';
        echo '</div>';
    }

    /*
     * Display an error message if the form
     * contains missing or invalid information.
     */
    if (!empty($errorMessage)) {
        echo '<div class="error">';
        echo '<h2>Form Error</h2>';
        echo htmlspecialchars($errorMessage);
        echo '</div>';
    }
    ?>

</div>

</body>

</html>