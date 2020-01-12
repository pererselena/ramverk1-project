<?php

namespace Elpr\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Elpr\User\User;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Register",
            ],
            [
                "name" => [
                    "type"        => "text",
                    "placeholder" => "Namn Efternamn",
                    "required" => "true"
                ],

                "tel" => [
                    "type"        => "tel",
                    "placeholder" => "+46XXXXXXXXX",
                ],

                "email" => [
                    "type"        => "email",
                    "placeholder" => "example@example.com",
                    "required" => "true"
                ],

                "password" => [
                    "type"        => "password",
                    "required" => "true"
                ],

                "password-again" => [
                    "type"        => "password",
                    "required" => "true",
                    "validation" => [
                        "match" => "password"
                    ],
                ],

                "birthdate" => [
                    "type"        => "date",
                    "required" => "true"
                ],

                "i agree" => [
                    "type"        => "checkbox",
                    "description" => "We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it.",
                    "required" => "true"
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create User",
                    "callback" => [$this, "callbackSubmit"],
                    "class" => "primaryBtn"
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $name          = $this->form->value("name");
        $email         = $this->form->value("email");
        $tel           = $this->form->value("tel");
        $birthdate     = $this->form->value("birthdate");
        $password      = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");

        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->name = $name;
        $user->tel = $tel;
        $user->email = $email;
        $user->birthdate = $birthdate;
        $user->score = 0;
        $user->gravatar($email);
        $user->setPassword($password);
        $user->votes = 0;
        $user->save();

        $session = $this->di->get("session");
        $session->set("userEmail", $user->email);
        $session->set("userId", $user->id);

        $this->form->addOutput("User was created.");
        return true;
    }

    /**
     * Callback for success-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSuccess()
    {
        $this->di->get("response")->redirect("user/profile")->send();
    }
}
