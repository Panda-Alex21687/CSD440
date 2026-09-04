<!--
     * Name: Alexander Baldree
     * MyInteger Class
     * 09/03/2026
     * CSD440
     *
     * 
     * This program creates a class named AlexMyInteger.
     * The class stores one integer value and provides methods
     * to determine whether numbers are even, odd, or prime.
     * The class also contains getter and setter methods.
     * Two objects are created to test all class methods.
     */

    /**
     * Class AlexMyInteger
     *
     * Stores a single integer and provides methods for
     * testing even, odd, and prime numbers.
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alex MyInteger Assignment</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
        }

        h1 {
            text-align: center;
        }

        .result {
            margin-bottom: 25px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Alex MyInteger</h1>

    <?php

   
    class AlexMyInteger
    {
        // Integer stored inside the object.
        private int $value;

        /**
         * Constructor
         *
         * Sets the initial integer when the object is created.
         *
         * @param int $value Integer to store.
         */
        public function __construct(int $value)
        {
            $this->value = $value;
        }

        /**
         * Getter method.
         *
         * Returns the stored integer.
         *
         * @return int
         */
        public function getValue(): int
        {
            return $this->value;
        }

        /**
         * Setter method.
         *
         * Changes the stored integer.
         *
         * @param int $value New integer value.
         * @return void
         */
        public function setValue(int $value): void
        {
            $this->value = $value;
        }

        /**
         * Determines whether a supplied integer is even.
         *
         * @param int $number Integer to test.
         * @return bool
         */
        public function isEven(int $number): bool
        {
            return $number % 2 === 0;
        }

        /**
         * Determines whether a supplied integer is odd.
         *
         * @param int $number Integer to test.
         * @return bool
         */
        public function isOdd(int $number): bool
        {
            return $number % 2 !== 0;
        }

        /**
         * Determines whether the object's stored integer is prime.
         *
         * A prime number must be greater than 1 and can only
         * be evenly divided by 1 and itself.
         *
         * @return bool
         */
        public function isPrime(): bool
        {
            // Numbers less than 2 are not prime.
            if ($this->value < 2) {
                return false;
            }

            /*
             * Only test divisors through the square root
             * of the stored value.
             */
            for ($i = 2; $i <= sqrt($this->value); $i++) {
                if ($this->value % $i === 0) {
                    return false;
                }
            }

            return true;
        }
    }

    /*
     * Create two instances of the AlexMyInteger class.
     */
    $integer1 = new AlexMyInteger(7);
    $integer2 = new AlexMyInteger(12);

    ?>

    <div class="result">

        <h2>First MyInteger Object</h2>

        <?php

        $value1 = $integer1->getValue();

        echo "<p>Stored Integer: " . $value1 . "</p>";

        echo "<p>Is " . $value1 . " even? "
            . ($integer1->isEven($value1) ? "Yes" : "No")
            . "</p>";

        echo "<p>Is " . $value1 . " odd? "
            . ($integer1->isOdd($value1) ? "Yes" : "No")
            . "</p>";

        echo "<p>Is " . $value1 . " prime? "
            . ($integer1->isPrime() ? "Yes" : "No")
            . "</p>";

        ?>

    </div>


    <div class="result">

        <h2>Second MyInteger Object</h2>

        <?php

        $value2 = $integer2->getValue();

        echo "<p>Stored Integer: " . $value2 . "</p>";

        echo "<p>Is " . $value2 . " even? "
            . ($integer2->isEven($value2) ? "Yes" : "No")
            . "</p>";

        echo "<p>Is " . $value2 . " odd? "
            . ($integer2->isOdd($value2) ? "Yes" : "No")
            . "</p>";

        echo "<p>Is " . $value2 . " prime? "
            . ($integer2->isPrime() ? "Yes" : "No")
            . "</p>";

        ?>

    </div>


    <div class="result">

        <h2>Testing the Setter Method</h2>

        <?php

        // Change the first object's value from 7 to 20.
        $integer1->setValue(20);

        $newValue = $integer1->getValue();

        echo "<p>The first integer was changed using setValue().</p>";

        echo "<p>New Stored Integer: " . $newValue . "</p>";

        echo "<p>Is " . $newValue . " even? "
            . ($integer1->isEven($newValue) ? "Yes" : "No")
            . "</p>";

        echo "<p>Is " . $newValue . " odd? "
            . ($integer1->isOdd($newValue) ? "Yes" : "No")
            . "</p>";

        echo "<p>Is " . $newValue . " prime? "
            . ($integer1->isPrime() ? "Yes" : "No")
            . "</p>";

        ?>

    </div>

</div>

</body>
</html>