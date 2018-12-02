<?php

namespace App\Forms;
/**
 * Created by PhpStorm.
 * User: LAYOUTindex
 * Date: 02/12/2018
 * Time: 02:09 PM
 */

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;

use Phalcon\Validation\Validator\Email ;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;


class RegisterForm extends Form
{
    public function initialize()
    {
        $username = new Text('email',[
            'class'=>'form-control',
            'required' => 'true',
            'placeholder'=>'email'
        ]);



        $username->addValidators([
            new PresenceOf(['message' => 'Email is required']),
            new Email(['message' => 'Please Insert Valid mail']),

        ]);

        $password = new Password('password', [
            "class" => "form-control",
            "required" => true,
            "placeholder" => "Password"
        ]);

        $password->addValidators([
            new PresenceOf(['message' => 'Password is required']),
            new StringLength(['min' => 5, 'message' => 'Password is too short. Minimum 5 characters.']),
        ]);

        $confirm_password = new Password('confirm_password', [
            "class" => "form-control",
            "required" => true,
            "placeholder" => "Confirm Password"
        ]);

        $confirm_password->addValidators([
            new PresenceOf(['message' => 'Password is required']),
            new StringLength(['min' => 5, 'message' => 'Password is too short. Minimum 5 characters.']),
            new Confirmation(['message'=>'Password and confirm password must be same', "with" =>'password'])
        ]);

        $submit = new Submit('submit', [
            "value" => "Sign UP",
            "class" => "btn btn-primary",
        ]);

        $this->add($username);
        $this->add($password);
        $this->add($confirm_password);
        $this->add($submit);
    }
}