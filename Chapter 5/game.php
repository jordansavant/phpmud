<?php

/*
 * 1. Extended enemies to live within an array
 * 2. explode() function on $line
 * 3. New randomFloat() function and varying our enemies and float type
 * 4. unset() variables
 */


/**
 * Examples of PHP Functions
 */
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

/**
 * Examples of PHP Classes
 */
class Player extends Character
{
    public function __construct()
    {
        parent::__construct("Player");
    }
}


class Enemy extends Character
{
    public function __construct($name)
    {
        parent::__construct($name);

        $this->strength = 10 + rand(0, 20);
        $this->health = 50 + rand(0, 80);
    }
}


class Character
{
    public function __construct($name)
    {
        $this->health = 100;
        $this->strength = 30;
        $this->name = $name;
        $this->chanceOfHit = .5;
    }

    public $name;
    public $health;
    public $strength;
    public $chanceOfHit;

    public function attack(Character $enemy)
    {
        if(getRandomFloat() < $this->chanceOfHit)
        {
            printMessage("$this->name attacks $enemy->name for $this->strength");

            $enemy->harm($this, $this->strength);
        }
        else
        {
            printMessage("$this->name attacks $enemy->name but misses!");
        }
    }

    public function harm(Character $character, $amount)
    {
        $this->health -= $amount;

        if($this->health <= 0)
        {
            $this->passAway();
        }
    }

    private function passAway()
    {
        printMessage("$this->name dies");
    }
}


/**
 * Example game
 */

$player = new Player();
$enemies = array();
$enemies['Orc'] = new Enemy('Orc');
$enemies['Troll'] = new Enemy('Troll');

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
