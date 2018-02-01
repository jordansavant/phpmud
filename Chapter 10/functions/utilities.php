<?php

function getRandomFloat()
{
    return rand(0, 100) / 100;
}

function printMessage($message)
{
    echo "$message\n";
}

function printHelp()
{
    printMessage("Commands:");
    printMessage("  attack [enemy name]");
    printMessage("  explore [room name]");
    printMessage("  leave");
    printMessage("  help");
    printMessage("  quit");
}

function clearScreen()
{
    printMessage(str_repeat("\n", 100));
}

function getCommand($prompt)
{
    //  Get command
    $line = readline("$prompt ");
    readline_add_history($line);
    $line = trim($line);

    // Explode line into commands and arguments
    $input = explode(' ', $line);
    $command = $input[0];
    
    sleep(1);
    clearScreen();

    return $input;
}