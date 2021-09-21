<?php

namespace App\Entity;


class Instructor
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $firstname;

    /**
     * @var string
     */
    public string $lastname;

    /**
     * Instructor Entity constructor
     * @param  int    $id
     * @param  string $firstname
     * @param  string $lastname
     * @return void
     */
    public function __construct(int $id, string $firstname, string $lastname)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }
}
