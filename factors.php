<?php
/**
 * This php file implements a function that will list the factors, up to a number 'n'.
 * A value 'n' is received from an incoming POST request using the 'filter_input' function to ensure the input being received from the client is an integer.
 * The function 'factors' takes a single parameter 'n', and implements the logic for determining which of the numbers up to 'n' are factors of 'n'. It will
 * loop up to the number 'n', checking each iteration to see if the current iteration can evenly divide 'n'. Once all factors have been found, they are 
 * displayed.
 * 
 * @author Brendan Dileo
 */

 $n = filter_input(INPUT_POST, 'n', FILTER_VALIDATE_INT); // Ensures the input received through the POST request is an integer.

 /**
  * This function will determine each of the factors up to a number 'n' provided by the client.
  * This value n is passed as a parameter to the function, and uses an if statement to check if it holds false, which would be a result of an invalid input.
  * If n is a valid integer, it is trimmed to remove any whitespace, and an if statement is used to ensure that n is a number greater than 0. If n validates,
  * a variable factors is declared as an array which will hold the factors of n. Before checking the rest of the factors, 1 is added to the array by default
  * to reflect the fact that 1 is a factor of all numbers. Then a for loop that starts at 2, and iterates up to, and including n incrementing by 1 for each 
  * iteration. Inside the loop an if statement checks if n is evenly divisible by the current iteration i, as if it is, the current iteration i is a factor 
  * of n. The value of i is then added to the array of factors. This loop will continue to execute until i is equal to n, effectively adding each factor found.
  * Once all factors have been found, the array is displayed in an ordered list. 
  * 
  * @param int $n The number that will be factored.
  * @return void The function echos (displays) the factors.
  */

function factors($n) {
    if ($n == false) { // Checks if the input was valid.
        echo "Error! You must enter a number!"; 
        return;
    }

    $n = trim($n); // Trims whitespace, if any.
    if ($n > 0) {
        $factors = array();
        array_push($factors, 1); // 1 is always a factor.
        for ($i = 2; $i <= $n; $i++) {
            if ($n % $i == 0) {
                array_push($factors, $i);
            }
        }
        echo '<ol>';
        // Displays a string representation of the 'factors' array.
        echo '<li>' . implode("</li><li>", $factors) . '</li>';
        echo '</ol>';
    } else {
        echo "Error! You must enter a positive number.";            
    }
}

$factors = factors($n);
?>
