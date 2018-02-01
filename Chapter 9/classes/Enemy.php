<?php

/**
 * Enemy SubClass
 * A character that represents a player adversary
 */
class Enemy extends Character
{
    public function __construct($name)
    {
        parent::__construct($name);

        $this->strength = 10 + rand(0, 20);
        $this->health = 50 + rand(0, 80);
    }
}