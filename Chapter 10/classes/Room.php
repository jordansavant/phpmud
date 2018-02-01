<?php

/**
 * Room class has a name and enemies
 */
class Room
{
    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
        $this->enemies = Array();
    }

    public $name;
    public $description;
    public $enemies;
}