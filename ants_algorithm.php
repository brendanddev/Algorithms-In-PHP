<?php
/**
 * This php file implements a solution to the Question 1: Marching Ants from the assignment.
 * A string is received from an incoming GET request using the 'filter_input' function to ensure security as the input is originating from the client. 
 * The function 'marching_ants' is where the logic for simulating the ants is implemented. It will take a single parameter 'ants_string' which is retrieved 
 * from the user, and first check that the string only contains 'R, B, or X', and then convert the string into an array. By first determining the number of each
 * ant in the array, and then continuously looping over the array of ants simulating their movement and checking for any encounters, the output is determined by
 * whether or not the ants have reached the opposing ants colony, if all the ants will die meaning neither win, or if black or red win.
 * 
 * @author Brendan Dileo
 */

$antsString = filter_input(INPUT_GET, 'ants', FILTER_SANITIZE_STRING); // Ensures input received from get request does not include harmful code.

/**
 * @param string $antsString A string representation of the marching ants, consisting of 'X, R, or B'.
 * @return void The function echos (displays) the result of the marching ants.
 */
function marchingAnts($antsString) {
    
    $antsString = trim($antsString, " "); // Trims whitespace from the string.
    
    if ($antsString == "") { // Checks for empty input. 
        echo "Error! You did not enter anything!";
        return;
    }

    if (preg_match("/[^XBR]/", $antsString)) { // Checks if the string contains any characters that are not 'X, B, or R'.
        echo "Error! You can only enter 'X', 'R', or 'B'!";     
        return;
    }

    $ants = str_split($antsString); // Splits the string into an array of ants (characters).
    $redAnts = 0;
    $blackAnts = 0;
    foreach ($ants as $ant) {
        if ($ant == 'R') {
            $redAnts++;
        }
        else if ($ant == 'B') {
            $blackAnts++;
        }
    }

     do {
        $hasEncounters = false; // Flag that tracks if ants have encountered each other.
        $antsTemp = $ants; // Holds a copy of the initial array.
        
        // Simulates Black Ants moving right.
        for ($i = 0; $i < count($antsTemp) - 1; $i++) { // Iterates up to the initial length of the array in the temporary array.
            if ($antsTemp[$i] == 'B' && $antsTemp[$i + 1] == 'R') { // Checks for positions of the initial array in the temporary array.
                $ants[$i] = 'X'; // Changes element of actual array.
                $ants[$i + 1] = 'X'; // Changes element of actual array.
                $blackAnts--;
                $redAnts--;
                $hasEncounters = true;
            }
        }

        $antsTemp = $ants;
        // Simulates Red Ants moving left.
        for ($i = count($antsTemp) - 1; $i >= 1; $i--) { // Iterates up to the initial length of the array in the temporary copy.
            if ($antsTemp[$i] == 'R' && $antsTemp[$i - 1] == 'B') {  // Checks for positions of the initial array in the temporary array copy.
                $ants[$i] = 'X'; // Changes element of actual array.
                $ants[$i - 1] = 'X'; // Changes element of actual array.
                $blackAnts--;
                $redAnts--;
                $hasEncounters = true;
            }
        }

        $antsSurvived = array();
        foreach ($ants as $ant) {
            if ($ant != 'X') {
                    $antsSurvived[] = $ant; // Stores all of the remaining ants in a new array $antsSurvived.
        }
        }

        $ants = $antsSurvived; // Reassigns surviving ants to the original array so the next set of encounters can be checked effectively.
    } while ($hasEncounters);
    
    // Determines outcome based on the ants that have survived.
    if ($antsSurvived) { // Checks to see if array is empty (No 'R' or 'B')
        if ($antsSurvived[0] == 'R' && end($antsSurvived) == 'B') { // Checks if a Red ant has reached the left, and a Black ant has reached the right.
            echo "M.A.D!"; // This results in M.A.D, Red ant moved all the way left, Black ant moved all the way right.
        } else {
            if ($blackAnts > $redAnts) { // Checks if there are more Black ants than Red, resulting in Black winning after simulating encounters.
                echo " Black Wins!";
            } else if ($redAnts > $blackAnts) { // Checks if there are more Red ants than Black, resulting in Red winning after simulating encounters.
                echo "Red Wins!";
            } else { // If neither color of ant has reached the other colony, and there are equal number of ants, neither side wins.
                echo "Neither!";
            }
        }
    } else { // If the array is empty (Only 'X'), neither side wins.
        echo "Neither!";
    }
}

marchingAnts($antsString); // Calls function.
?>