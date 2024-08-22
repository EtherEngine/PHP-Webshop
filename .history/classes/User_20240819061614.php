<?php

class User
{
    private $db;
    private $user_id;

    public function __construct($db, $user_id)
    {
        $this->db = $db;
        $this->user_id = $user_id;
    }

    public function getUserProfile()
    {
        $stmt = $this->db->prepare('SELECT firstname, lastname, email, street, housenumber, city, zipcode, country, profile_image FROM users WHERE id = ?');
        $stmt->execute([$this->user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
