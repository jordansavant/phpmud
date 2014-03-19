<?php

/*
 * 1. $argv variable
 * 2. Arrays
 * 3. exit function
 */

function printMessage($message)
{
    echo "$message\n";
}

$message = $argv[1];
if($message == '')
{
    printMessage("Message argument was not passed");
    exit(1);
}
printMessage($message);

