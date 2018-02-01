<?php

/**
 * Character Class
 * Base class for all game characters
 * Has health, stats and random chance of hit
 */
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