<?php

namespace Models;

use PDO;
use \Utilities\Flash;
use \Utilities\Token;
use Respect\Validation\Validator;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * User model
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{

    /**
     * Class constructor
     * 
     * @param array $data Data to insert or update a dataset (associative, key has to match column name)
     * 
     */
    public function __construct($data = []) 
    {
        foreach($data as $key => $value) {

            $this->$key = $value;
        }
    }

    /**
     * Insert user into database
     * 
     * @return boolean True if user was saved, false otherwise
     */
    public function save()
    {
        if ($this->validate()) {

            $this->password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO Users (email, password_hash)
                    VALUES (:email, :password_hash)';
            $stmt = static::getDB()->prepare($sql);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password_hash', $this->password_hash, PDO::PARAM_STR);

            return $stmt->execute();
        }

        return false;
    }

    /**
     * Find a user by email
     *
     * @param string $email
     * 
     * @return mixed User object if found, false otherwise
     */
    public static function findByEmail($email)
    {
        $sql = 'SELECT * 
                FROM Users 
                WHERE email = :email';
        $stmt = static::getDB()->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }
    
    /**
     * Find a user by id
     *
     * @param string $id
     * 
     * @return mixed User object if found, false otherwise
     */
    public static function findByID($id)
    {
        $sql = 'SELECT * 
                FROM Users 
                WHERE id = :id';
        $stmt = static::getDB()->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Remember the login by inserting a new unique token into the remembered_logins table
     * for this user record
     *
     * @return boolean True if the login was remembered successfully, false otherwise
     */
    public function rememberLogin()
    {
        $token = new Token();
        $hashed_token = $token->getHash();

        $this->remember_token = $token->getValue();
        $this->expiry_timestamp = time() + 60 * 60 * 24 * 30;

        $sql = 'INSERT INTO remembered_logins (user_id, token_hash, expires_at)
                VALUES (:user_id, :token_hash, :expires_at)';
        $stmt = static::getDB()->prepare($sql);

        $stmt->bindValue(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->bindValue(':token_hash', $hashed_token, PDO::PARAM_STR);
        $stmt->bindValue(':expires_at', date('Y-m-d H:i:s', $this->expiry_timestamp), PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Validate user data
     * 
     * @return boolean True if validation succeded, false otherwise
     */
    private function validate()
    {
        $userValidator = Validator::attribute('email', Validator::email())-> attribute('password', Validator::stringType()->length(6, null));

        try {
            $userValidator->assert($this);
        } catch(NestedValidationException $exception) {
            $errors = $exception->findMessages([
                'email' => 'Please enter a valid email address',
                'length' => 'Password length has to be at least 6 characters'
            ]);
        }

        if (!empty($errors)) {
            foreach ($errors as $errorName => $errorMessage) {
                if (!empty($errorMessage)) {
                    Flash::addMessage($errorMessage, Flash::ERROR, $errorName);
                }
            }
        }
        
        return empty($errors);
    }
}
