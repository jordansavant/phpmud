<?php

/**
 * 1. Classes and objects
 * 2. Switch statements
 */

function printMessage($message)
{
    echo "$message\n";
}

function clearScreen()
{
    printMessage(str_repeat("\n", 100));
}

class Character
{
    public function __construct($name)
    {
        $this->health = 100;
        $this->strength = 30;
        $this->name = $name;
    }

    public $name;
    public $health;
    public $strength;

    public function attack(Character $enemy)
    {
    }

    public function harm(Character $character, $amount)
    {
    }

    private function passAway()
    {
    }
}


clearScreen();
printMessage("---------------------------------");
printMessage("Welcome to the dungeons of dread!");
printMessage("---------------------------------");


$character = null;
while(true)
{
    //  Get command
    $line = readline("What would you like to do? ");
    readline_add_history($line);
    $line = trim($line);

    sleep(1);

    switch($line)
    {
        case 'quit':
            exit();
            break;

        case 'create':

            $character = new Character('Player');
            printMessage("Player created");

            break;

        default:
        case 'about':

            if($character instanceof Character)
            {
                printMessage("Name: $character->name");
                printMessage("Health: $character->health");
                printMessage("Strength: $character->strength");
            }
            else
            {
                printMessage("Player has not been created");
            }

            break;

    }
}
