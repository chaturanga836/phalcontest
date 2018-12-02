<?php
namespace App\Forms;
/**
 * Created by PhpStorm.
 * User: LAYOUTindex
 * Date: 02/12/2018
 * Time: 12:28 PM
 */

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;

use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Email;

class LoginForm extends Form
{
    public function initialize()
    {
        $username = new Text('email',[
            'class'=>'form-control',
            'required' => 'true',
            'placeholder'=>'username'
        ]);

        $username->addValidators([
            new PresenceOf(['message' => 'Username is required',]),
            new Email(['message' => 'Please Insert Valid mail'])

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

        $submit = new Submit('submit', [
            "value" => "Sign In",
            "class" => "btn btn-primary",
        ]);

        $this->add($username);
        $this->add($password);
        $this->add($submit);
    }
}