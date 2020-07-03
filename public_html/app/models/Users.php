<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;

class Users extends Model {

    protected $id;
    protected $username;
    protected $password;
    protected $name;
    protected $email;
    protected $created_at;
    protected $active;

    /**
     * This function is called only once every application initialisation
     */
    public function initialize() {
        $this->setSource('Users');
    }
    
    /**
     * This function is called every time a new object is created
     */
    public function onConstruct() {
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function getActive() {
        return $this->active;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
    }

    public function setPassword($password) {
        $this->password = password_hash($password,PASSWORD_BCRYPT);
        return $this;
    }

    public function setName($name) { 
        $this->name = $name;
        return $this;
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

    public function validation() {
        $validator = new Validation();
        
        $validator->add(
            'email',
            new EmailValidator([
            'message' => 'Invalid email given'
        ]));

        $validator->add(
            'email',
            new UniquenessValidator([
            'message' => 'Sorry, The email was registered by another user'
        ]));

        $validator->add(
            'username',
            new UniquenessValidator([
            'message' => 'Sorry, That username is already taken'
        ]));
        
        return $this->validate($validator);
    }
}