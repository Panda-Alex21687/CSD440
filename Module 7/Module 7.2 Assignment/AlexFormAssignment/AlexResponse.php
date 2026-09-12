<?php

/*
    Name: Alexander Baldree
    PHP Form Program
    09/12/26
    CSD440

    Purpose:
    This PHP program receives seven fields of data from
    AlexForm.html. The program verifies that every field
    contains valid information. If all information is valid,
    the submitted data is displayed. If there are problems,
    an error message is displayed to the user.
*/

// Create an array that will hold validation errors.
$errors = [];

// Make sure the form was submitted using POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    /*
        Get the submitted information.

        trim() removes unnecessary spaces from the beginning
        and end of the user's input.
    */

    $firstName = trim($_POST["firstName"] ?? "");
    $lastName = trim($_POST["lastName"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $age = trim($_POST["age"] ?? "");
    $birthDate = trim($_POST["birthDate"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $favoriteColor = trim($_POST["favoriteColor"] ?? "");


    // -------------------------------------------------
    // Validate first name
    // -------------------------------------------------

    if ($firstName === "") {

        $errors[] = "First name is required.";

    } elseif (!preg_match("/^[a-zA-Z-' ]+$/", $firstName)) {

        $errors[] = "First name contains invalid characters.";
    }


    // -------------------------------------------------
    // Validate last name
    // -------------------------------------------------

    if ($lastName === "") {

        $errors[] = "Last name is required.";

    } elseif (!preg_match("/^[a-zA-Z-' ]+$/", $lastName)) {

        $errors[] = "Last name contains invalid characters.";
    }


    // -------------------------------------------------
    // Validate email address
    // -------------------------------------------------

    if ($email === "") {

        $errors[] = "Email address is required.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $errors[] = "Please enter a valid email address.";
    }


    // -------------------------------------------------
    // Validate age
    // -------------------------------------------------

    if ($age === "") {

        $errors[] = "Age is required.";

    } elseif (
        filter_var(
            $age,
            FILTER_VALIDATE_INT,
            ["options" => ["min_range" => 1, "max_range" => 120]]
        ) === false
    ) {

        $errors[] = "Age must be a whole number between 1 and 120.";
    }


    // -------------------------------------------------
    // Validate birth date
    // -------------------------------------------------

    if ($birthDate === "") {

        $errors[] = "Birth date is required.";

    } else {

        $date = DateTime::createFromFormat("Y-m-d", $birthDate);

        if (!$date || $date->format("Y-m-d") !== $birthDate) {

            $errors[] = "Please enter a valid birth date.";

        } elseif ($date > new DateTime()) {

            $errors[] = "Birth date cannot be in the future.";
        }
    }


    // -------------------------------------------------
    // Validate phone number
    // -------------------------------------------------

    if ($phone === "") {

        $errors[] = "Phone number is required.";

    } elseif (!preg_match("/^[0-9\s\-\(\)]+$/", $phone)) {

        $errors[] = "Please enter a valid phone number.";

    } else {

        /*
            Remove everything except numbers so the program
            can verify that the user entered 10 digits.
        */

        $phoneDigits = preg_replace("/\D/", "", $phone);

        if (strlen($phoneDigits) !== 10) {

            $errors[] = "Phone number must contain 10 digits.";
        }
    }


    // -------------------------------------------------
    // Validate favorite color
    // -------------------------------------------------

    $validColors = [
        "Blue",
        "Green",
        "Red",
        "Purple",
        "Orange",
        "Black"
    ];

    if ($favoriteColor === "") {

        $errors[] = "Favorite color is required.";

    } elseif (!in_array($favoriteColor, $validColors, true)) {

        $errors[] = "Please select a valid favorite color.";
    }

} else {

    /*
        If someone attempts to access AlexResponse.php
        without submitting the form, return an error.
    */

    $errors[] = "The form was not submitted correctly.";

    $firstName = "";
    $lastName = "";
    $email = "";
    $age = "";
    $birthDate = "";
    $phone = "";
    $favoriteColor = "";
}


/*
    htmlspecialchars() is used when displaying information.

    This prevents HTML or JavaScript entered by a user
    from being interpreted as executable browser code.
*/

function cleanOutput($data)
{
    return htmlspecialchars($data, ENT_QUOTES, "UTF-8");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Alex Form Response</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;

            box-shadow:
                0 4px 10px
                rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        .success {
            color: #16713b;
            text-align: center;
        }

        .error {
            color: #b42318;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th,
        td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #1d5fa7;
            color: white;
            width: 35%;
        }

        .button {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 20px;

            background-color: #1d5fa7;
            color: white;

            text-decoration: none;
            border-radius: 5px;
        }

        .button:hover {
            background-color: #164b84;
        }

    </style>

</head>

<body>

<div class="container">

<?php

/*
    If validation errors exist, display the error page.

    Otherwise, display all of the information entered
    by the user.
*/

if (!empty($errors)) {
?>

    <h1 class="error">
        Form Submission Error
    </h1>

    <p>
        There was a problem with the information entered.
        Please correct the following:
    </p>

    <ul class="error">

        <?php foreach ($errors as $error): ?>

            <li>
                <?php echo cleanOutput($error); ?>
            </li>

        <?php endforeach; ?>

    </ul>

    <a
        class="button"
        href="AlexForm.html">
        Return to Form
    </a>

<?php

} else {

    // Format the birth date for easier reading.

    $formattedBirthDate =
        date(
            "F j, Y",
            strtotime($birthDate)
        );

?>

    <h1 class="success">
        Form Successfully Submitted
    </h1>

    <p>
        Thank you. The information you entered
        has been successfully validated.
    </p>

    <table>

        <tr>
            <th>First Name</th>

            <td>
                <?php echo cleanOutput($firstName); ?>
            </td>
        </tr>


        <tr>
            <th>Last Name</th>

            <td>
                <?php echo cleanOutput($lastName); ?>
            </td>
        </tr>


        <tr>
            <th>Email Address</th>

            <td>
                <?php echo cleanOutput($email); ?>
            </td>
        </tr>


        <tr>
            <th>Age</th>

            <td>
                <?php echo cleanOutput($age); ?>
            </td>
        </tr>


        <tr>
            <th>Birth Date</th>

            <td>
                <?php echo cleanOutput($formattedBirthDate); ?>
            </td>
        </tr>


        <tr>
            <th>Phone Number</th>

            <td>
                <?php echo cleanOutput($phone); ?>
            </td>
        </tr>


        <tr>
            <th>Favorite Color</th>

            <td>
                <?php echo cleanOutput($favoriteColor); ?>
            </td>
        </tr>

    </table>


    <a
        class="button"
        href="AlexForm.html">
        Submit Another Form
    </a>

<?php
}
?>

</div>

</body>

</html>