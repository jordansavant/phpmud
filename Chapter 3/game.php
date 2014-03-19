<?php

/**
 * 1. New function that uses a built in PHP function
 * 2. While loops
 * 3. How to read a terminal line and keep it historically
 * 4. If / Else block
 * 5. Exiting the script
 */

function printMessage($message)
{
    echo "$message\n";
}

function clearScreen()
{
    printMessage(str_repeat("\n", 100));
}

clearScreen();
printMessage("---------------------------------");
printMessage("Welcome to the dungeons of dread!");
printMessage("---------------------------------");

while(true)
{
    //  Get command
    $line = readline("What would you like to do? ");
    $line = trim($line);

    // Add to history for convenience of Up arrow
    readline_add_history($line);

    sleep(1);

    if($line == 'quit')
    {
        exit();
    }
    else
    {
        printMessage($line);
    }
}

