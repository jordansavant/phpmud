<?php

/*
 * 1. Separating our Data from our Code
 * 2. JSON encoding and decoding
 * 3. File contents to strings
 */

require "functions/utilities.php";
require "functions/autoloader.php";

$worldJSON = file_get_contents("world.json");
$world = json_decode($worldJSON);

$player = new Player();
$enemies = array();
foreach ($world->enemies as $enemy) {
    $enemies[$enemy] = new Enemy($enemy);
}

clearScreen();
printMessage("---------------------------------");
printMessage("Welcome to the dungeons of dread!");
printMessage("---------------------------------");
printHelp();

$gameOver = false;
while(!$gameOver)
{
    // Explain world
    printMessage("");
    printMessage("Your condition...\n  Health: $player->health\n  Strength: $player->strength");
    printMessage("You see...");
    foreach($enemies as $enemy)
    {
        printMessage("  Enemy $enemy->name with health $enemy->health and strength $enemy->strength");
    }
    printMessage("");


    //  Get command
    $line = readline("What would you like to do? ");
    readline_add_history($line);
    $line = trim($line);

    // Explode line into commands and arguments
    $input = explode(' ', $line);
    $command = $input[0];

    sleep(1);
    clearScreen();

    switch($command)
    {
        case 'quit':
            exit();
            break;

        case 'attack':

            $enemy_name = $input[1];
            if(isset($enemies[$enemy_name]))
            {
                $player->attack($enemies[$enemy_name]);
            }
            else
            {
                printMessage("You attack an enemy that does not exist!");
            }

            break;

        default:
        case 'help':
            printHelp();
            break;

    }


    // Process enemies
    sleep(1);
    foreach($enemies as $k => $enemy)
    {
        if($enemy->health <= 0)
        {
            unset($enemies[$k]);
            continue;
        }

        $enemy->attack($player);
        sleep(1);

        if($player->health <= 0)
        {
            printMessage("Your fateful day as an adventurer has come...");
            $gameOver = true;
            break;
        }
    }

    if(count($enemies) == 0)
    {
        printMessage("You are victorious and gain much treasure!");
        $gameOver = true;
    }
}

printMessage("---------------------------------");
printMessage("          Game Over              ");
printMessage("---------------------------------");
