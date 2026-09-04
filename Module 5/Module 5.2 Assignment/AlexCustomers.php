<!-- 
    Alexander Baldree
    Customers Array
    09/03/2026
    CSD440

    Purpose:
    This program creates an array containing at least
    ten customers. Each customer includes a first name,
    last name, age, and phone number.

    The program displays all customer records and uses
    PHP array functions to search for customers using
    different data fields.
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alex Customers</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 40px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
        }

        h1,
        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #e9e9e9;
        }

        .search-result {
            margin-bottom: 25px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Alex Customers</h1>

    <?php

    /*
     * Name: Alex Baldree
     * Assignment: Customers Array
     * Date: September 3, 2026
     *
     * Purpose:
     * This program creates an array containing at least
     * ten customers. Each customer includes a first name,
     * last name, age, and phone number.
     *
     * The program displays all customer records and uses
     * PHP array functions to search for customers using
     * different data fields.
     */

    // Create an array containing 10 customer records.
    $customers = [
        [
            "firstName" => "Alex",
            "lastName" => "Baldree",
            "age" => 28,
            "phone" => "901-555-1001"
        ],
        [
            "firstName" => "Jordan",
            "lastName" => "Smith",
            "age" => 34,
            "phone" => "901-555-1002"
        ],
        [
            "firstName" => "Sara",
            "lastName" => "Johnson",
            "age" => 22,
            "phone" => "901-555-1003"
        ],
        [
            "firstName" => "Max",
            "lastName" => "Williams",
            "age" => 41,
            "phone" => "901-555-1004"
        ],
        [
            "firstName" => "Aftab",
            "lastName" => "Rahman",
            "age" => 30,
            "phone" => "901-555-1005"
        ],
        [
            "firstName" => "Tiffany",
            "lastName" => "Brown",
            "age" => 27,
            "phone" => "901-555-1006"
        ],
        [
            "firstName" => "Miguel",
            "lastName" => "Garcia",
            "age" => 35,
            "phone" => "901-555-1007"
        ],
        [
            "firstName" => "Rashai",
            "lastName" => "Davis",
            "age" => 24,
            "phone" => "901-555-1008"
        ],
        [
            "firstName" => "Matthew",
            "lastName" => "Miller",
            "age" => 31,
            "phone" => "901-555-1009"
        ],
        [
            "firstName" => "Patrice",
            "lastName" => "Wilson",
            "age" => 35,
            "phone" => "901-555-1010"
        ]
    ];

    ?>

    <!-- Display all customer records -->
    <h2>All Customers</h2>

    <table>
        <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Age</th>
            <th>Phone Number</th>
        </tr>
        </thead>

        <tbody>

        <?php foreach ($customers as $customer): ?>

            <tr>
                <td><?php echo $customer["firstName"]; ?></td>
                <td><?php echo $customer["lastName"]; ?></td>
                <td><?php echo $customer["age"]; ?></td>
                <td><?php echo $customer["phone"]; ?></td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>


    <!-- Search by first name -->
    <div class="search-result">

        <h2>Search by First Name</h2>

        <?php

        /*
         * array_column() creates an array containing
         * only the firstName values.
         *
         * array_search() returns the index where
         * the requested value was found.
         */

        $firstNames = array_column($customers, "firstName");

        $firstNameIndex = array_search("Sara", $firstNames);

        if ($firstNameIndex !== false) {

            $customer = $customers[$firstNameIndex];

            echo "<p>";
            echo "Customer Found: ";
            echo $customer["firstName"] . " ";
            echo $customer["lastName"] . ", ";
            echo "Age: " . $customer["age"] . ", ";
            echo "Phone: " . $customer["phone"];
            echo "</p>";
        }

        ?>

    </div>


    <!-- Search by last name -->
    <div class="search-result">

        <h2>Search by Last Name</h2>

        <?php

        $lastNames = array_column($customers, "lastName");

        $lastNameIndex = array_search("Garcia", $lastNames);

        if ($lastNameIndex !== false) {

            $customer = $customers[$lastNameIndex];

            echo "<p>";
            echo "Customer Found: ";
            echo $customer["firstName"] . " ";
            echo $customer["lastName"] . ", ";
            echo "Age: " . $customer["age"] . ", ";
            echo "Phone: " . $customer["phone"];
            echo "</p>";
        }

        ?>

    </div>


    <!-- Search by phone number -->
    <div class="search-result">

        <h2>Search by Phone Number</h2>

        <?php

        $phoneNumbers = array_column($customers, "phone");

        $phoneIndex = array_search("901-555-1005", $phoneNumbers);

        if ($phoneIndex !== false) {

            $customer = $customers[$phoneIndex];

            echo "<p>";
            echo "Customer Found: ";
            echo $customer["firstName"] . " ";
            echo $customer["lastName"] . ", ";
            echo "Age: " . $customer["age"] . ", ";
            echo "Phone: " . $customer["phone"];
            echo "</p>";
        }

        ?>

    </div>


    <!-- Search for multiple customers by age -->
    <div class="search-result">

        <h2>Customers Who Are Age 35</h2>

        <?php

        /*
         * array_filter() checks every record in the
         * customer array and returns all customers
         * whose age matches the search value.
         */

        $ageResults = array_filter(
            $customers,
            function ($customer) {
                return $customer["age"] == 35;
            }
        );

        if (count($ageResults) > 0) {

            foreach ($ageResults as $customer) {

                echo "<p>";
                echo $customer["firstName"] . " ";
                echo $customer["lastName"] . ", ";
                echo "Age: " . $customer["age"] . ", ";
                echo "Phone: " . $customer["phone"];
                echo "</p>";
            }

        } else {

            echo "<p>No customers were found.</p>";
        }

        ?>

    </div>


    <!-- Search for customers older than 30 -->
    <div class="search-result">

        <h2>Customers Older Than 30</h2>

        <?php

        $olderCustomers = array_filter(
            $customers,
            function ($customer) {
                return $customer["age"] > 30;
            }
        );

        foreach ($olderCustomers as $customer) {

            echo "<p>";
            echo $customer["firstName"] . " ";
            echo $customer["lastName"] . ", ";
            echo "Age: " . $customer["age"] . ", ";
            echo "Phone: " . $customer["phone"];
            echo "</p>";
        }

        ?>

    </div>

</div>

</body>

</html>