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

$activeRoom = null;
$player = new Player();
$rooms = array();
foreach ($world->rooms as $room) {
    // Create our room
    $roomObject = new Room($room->name, $room->description);
    // Supply its enemies
    foreach($room->enemies as $enemy) {
        $roomObject->enemies[$enemy] = new Enemy($enemy);
    }
    // Add it to our room list
    $rooms[$roomObject->name] = $roomObject;
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

    // Switch on game state
    if ($activeRoom == null)
    {
        // Describe rooms
        foreach($rooms as $room)
        {
            printMessage("  $room->name: $room->description");
        }
        printMessage("");

        //  Get command
        $command = getCommand("What would you like to do?");

        switch($command[0])
        {
            case 'quit':
                exit();
                break;

            case 'explore':

                $room_name = $command[1];
                if(isset($rooms[$room_name]))
                {
                    $activeRoom = $rooms[$room_name];
                    printMessage("You travel to the ".$activeRoom->name);
                }
                else
                {
                    printMessage("That room does not exist!");
                }

                break;

            default:
            case 'help':
                printHelp();
                break;
        }
    }
    else
    {
        foreach($activeRoom->enemies as $enemy)
        {
            printMessage("  Enemy $enemy->name with health $enemy->health and strength $enemy->strength");
        }
        printMessage("");

        //  Get command
        $command = getCommand("What would you like to do?");

        switch($command[0])
        {
            case 'quit':
                exit();
                break;

            case 'attack':

                $enemy_name = $command[1];

                if(isset($activeRoom->enemies[$enemy_name]))
                {
                    $player->attack($activeRoom->enemies[$enemy_name]);
                }
                else
                {
                    printMessage("You attack an enemy that does not exist!");
                }

                break;

            case 'leave':
                printMessage("You leave the ".$activeRoom->name);
                $activeRoom = null;
                break;

            default:
            case 'help':
                printHelp();
                break;

        }
    }

    // Process enemies
    if ($activeRoom)
    {
        sleep(1);
        foreach($activeRoom->enemies as $k => $enemy)
        {
            if($enemy->health <= 0)
            {
                unset($activeRoom->enemies[$k]);
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

        if(count($activeRoom->enemies) == 0)
        {
            printMessage("You are victorious and gain much treasure!");
            $activeRoom = null;
        }
    }
}

printMessage("---------------------------------");
printMessage("          Game Over              ");
printMessage("---------------------------------");
