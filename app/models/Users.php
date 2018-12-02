<?php

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email ;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Message as ValidateMessages;
use Phalcon\Security;

class Users extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $email;

    /**
     *
     * @var string
     */
    private $password;


    /**
     * @var obejct
     */
    public $validate_messages;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcontest");
        $this->setSource("Users");
    }

    public function getID()
    {
        return $this->id;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'Users';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users[]|Users|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Users|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {

        return parent::findFirst($parameters);
    }

    /**
     * Set user name
     * @param $username
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set Password
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {

        $security = new Security();

        $this->password = $security->hash($password);

        return $this;
    }

    public function checkPassword($password){

        $security = new Security();
        
        $resp = $security->checkHash($password,$this->password);
        
        return $resp;
    }


    /**
     * Create new User Object
     * @return $this|bool
     */
    public function create($data = NULL, $whiteList = NULL)
    {
        $validator = new Validation();
        $this->validate_messages = null;

        $validator->add(
            'email',
            new Email(
                [
                    'model'   => $this,
                    'message' => 'Invalid email',
                ]
            )
        );

        $validator->add(
            'email',
            new Uniqueness(
                [
                    'model'   => $this,
                    'message' => 'mail address already exist',
                    'cancelOnFail' => true,
                ]
            )
        );



        $this->validate_messages = $validator->validate([
            'email'=>$this->email
        ]);

        if( count($this->validate_messages) > 0){

            return false;

        }else{
            $this->save();
            return $this;
        }



    }

}
