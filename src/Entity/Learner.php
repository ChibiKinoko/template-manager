<?php

namespace App\Entity;

class Learner
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
     * @var string
     */
    public string $email;

    /**
     * Learner Entity constructor
     * @param  int    $id
     * @param  string $firstname
     * @param  string $email
     * @return void
     */
    public function __construct(int $id, string $firstname, string $lastname, string $email)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
    }
}
