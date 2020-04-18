<?php

class Conversation
{
    private $id;
    private $user_1;
    private $user_2;


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of user_1
     */ 
    public function getUser_1()
    {
        return $this->user_1;
    }

    /**
     * Set the value of user_1
     *
     * @return  self
     */ 
    public function setUser_1($user_1)
    {
        $this->user_1 = $user_1;

        return $this;
    }

    /**
     * Get the value of user_2
     */ 
    public function getUser_2()
    {
        return $this->user_2;
    }

    /**
     * Set the value of user_2
     *
     * @return  self
     */ 
    public function setUser_2($user_2)
    {
        $this->user_2 = $user_2;

        return $this;
    }
}