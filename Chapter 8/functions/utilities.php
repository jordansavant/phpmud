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
    printMessage("  quit");
}

function clearScreen()
{
    printMessage(str_repeat("\n", 100));
}