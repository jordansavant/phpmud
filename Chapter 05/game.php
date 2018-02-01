<?php

/*
 * 1. Inheritence and Polymorphism
 * 2. rand()
 * 3. Added logic to class methods
 * 4. Switch while to be variable based
 */

function printMessage($message)
{
    echo "$message\n";
}

function clearScreen()
{
    printMessage(str_repeat("\n", 100));
}

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
    }

    public $name;
    public $health;
    public $strength;

    public function attack(Character $enemy)
    {
        printMessage("$this->name attacks $enemy->name for $this->strength");
        $enemy->harm($this, $this->strength);
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



clearScreen();
printMessage("---------------------------------");
printMessage("Welcome to the dungeons of dread!");
printMessage("---------------------------------");

$player = new Player();
$enemy = new Enemy('Orc');

$gameOver = false;
while(!$gameOver)
{
    // Explain world
    printMessage("");
    printMessage("Your condition...\n  Health: $player->health\n  Strength: $player->strength");
    printMessage("You see...");
    printMessage("  Enemy $enemy->name with health $enemy->health and strength $enemy->strength");
    printMessage("");


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

        case 'attack':

            $player->attack($enemy);

            break;
    }


    // Process enemies
    sleep(1);
    if($enemy->health > 0)
    {
        $enemy->attack($player);
    }
    else
    {
        printMessage("You are victorious and gain much treasure!");
        $gameOver = true;
    }

    if($player->health <= 0)
    {
        printMessage("Your fateful day as an adventurer has come...");
        $gameOver = true;
    }
}

printMessage("---------------------------------");
printMessage("          Game Over              ");
printMessage("---------------------------------");
