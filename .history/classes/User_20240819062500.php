<?php

class User
{
    private $db;
    private $user_id;
    private $userDetails;

    public function __construct($db, $user_id)
    {
        $this->db = $db;
        $this->user_id = $user_id;
        $this->loadUserProfile();
    }

    private function loadUserProfile()
    {
        $stmt = $this->db->prepare('SELECT firstname, lastname, email, street, housenumber, city, zipcode, country, profile_image FROM users WHERE id = ?');
        $stmt->execute([$this->user_id]);
        $this->userDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Method to return the profile image
    public function getProfileImage()
    {
        return $this->userDetails['profile_image'] ? $this->userDetails['profile_image'] : 'profil_icon_w.png';
    }

    // Other methods for getting user details...
    public function getFirstname()
    {
        return $this->userDetails['firstname'];
    }

    public function getLastname()
    {
        return $this->userDetails['lastname'];
    }

    public function getEmail()
    {
        return $this->userDetails['email'];
    }

    public function getStreet()
    {
        return $this->userDetails['street'];
    }

    public function getHousenumber()
    {
        return $this->userDetails['housenumber'];
    }

    public function getCity()
    {
        return $this->userDetails['city'];
    }

    public function getZipcode()
    {
        return $this->userDetails['zipcode'];
    }

    public function getCountry()
    {
        return $this->userDetails['country'];
    }
}
