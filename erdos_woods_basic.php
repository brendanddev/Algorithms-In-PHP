<?php
/**
 * This php file implements a solution to Question 2 Part 2: Erdos-Woods Numbers.
 * Two integers are received through a POST request using the 'filter_input' function to ensure that the values are integers.
 * These two integers represent the start and the end of the sequence of numbers. The logic inside of the function is used
 * to determine if any of the numbers between the start and the end of the sequence are Erdos-Woods numbers, which for the
 * sake of the assignment is determined if any of the numbers between start and end do not share a factor with the start and end. 
 * 
 * From my understanding, the question is asking for numbers that do not share a factor with EITHER start or end.
 * If that was not the correct way of doing it, the logic can easily be changed from '||' to '&&' in order to include
 * numbers that don't share a prime factor with BOTH start and end. This is just the way I understood the question.
 * 
 * @author Brendan Dileo
 */

 $start = filter_input(INPUT_POST, 'start', FILTER_VALIDATE_INT); // Ensures the input received through the POST request is a valid integer.
 $end = filter_input(INPUT_POST, 'end', FILTER_VALIDATE_INT); // Ensures the input received through the POST request is a valid integer.

/** 
* This function is used to determine if any numbers between the start and end provided by the client, are erdos woods numbers.
* The function ensures that the start is larger than 0, and the end is 100 or less. The prime factors up to 47 are hardcoded into an array, 
* to speed up the process of determining factors. The prime factors of start and end will be stored in an array, and once they have been 
* determined, a boolean flag is used to indicate whether or not the number is considered a erdos woods number. Any prime factors of start 
* and end are determined, and then each number between start and end is looped through, checking if the number shares a common prime with 
* either start or end, which would not be a erdos number. Each erdos woods number is displayed in an unordered html list.
*
* @param int $start The number that begins the sequence.
* @param int $end The number that ends the sequence.
* @return void The function echos (displays) the factors.
*/

function erdosWoodsNumbers($start, $end) {
    if ($start > 0 && $end <= 100) { // Checks to see if start is larger than 0, and end is 100 or less.
        if ($start >= $end) { // Checks if start is equal to end or larger than end.
            echo "Error! The start value cannot be equal to or larger than the end value!"; // Displays error message, this input would be invalid.
        } else { 
            $primes = [2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47]; // First 15 prime numbers.
            $factors = array(); // Holds common prime factors.
                        
            foreach ($primes as $prime) { 
                if ($start % $prime == 0 || $end % $prime == 0) { // Checks if start and end have any prime factors.
                    array_push($factors, $prime); // If they do it is added to the factors array.
                }
            }

            echo '<ul>';
            for ($s = $start + 1; $s < $end; $s++) { // Loops through numbers between start and end.
                $isErdos = true;
                foreach ($factors as $factor) {
                    if ($s % $factor == 0) { // If the number has a common prime factor, it is now an erdos woods.
                        $isErdos = false; // Flag indicates it is not an erdos woods.
                        break;
                    }
                }

                if ($isErdos) { // If the number is an erdos woods number, it will be displayed in an unordered list.
                    echo '<li>' . $s . '</li>';
                }    
            }
            echo '</ul>';
        }
    } else {
        echo "Error! You must enter a integer between 1 - 100!";
    }
}

erdosWoodsNumbers($start, $end);
?>

