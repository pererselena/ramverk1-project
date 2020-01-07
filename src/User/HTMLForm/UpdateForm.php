<?php

namespace Elpr\User\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Elpr\User\User;

/**
 * Form to update an item.
 */
class UpdateForm extends FormModel
{
    /**
     * Constructor injects with DI container and the email to update.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     * @param integer             $email to update
     */
    public function __construct(ContainerInterface $di, $email)
    {
        parent::__construct($di);
        $user = $this->getItemDetails($email);
        $this->form->create(
[
                "id" => __CLASS__,
                "legend" => "Update profile",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $user->id,
                ],

                "email" => [
                    "type"        => "email",
                    "value" => $user->email,
                    "readonly" => true,
                ],

                "name" => [
                    "type"        => "text",
                    "value" => $user->name,
                ],

                "tel" => [
                    "type"        => "tel",
                    "value" => $user->tel,
                ],

                "password" => [
                    "type"        => "password",
                ],

                "password-again" => [
                    "type"        => "password",
                    "validation" => [
                        "match" => "password"
                    ],
                ],

                "birthdate" => [
                    "type"        => "date",
                    "value" => $user->birthdate,
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
                    "callback" => [$this, "callbackSubmit"],
                    "class" => "primaryBtn"
                ]
            ]
        );
    }



    /**
     * Get details on item to load form with.
     *
     * @param integer $email get details on item with email.
     * @return User
     */
    public function getItemDetails($email) : object
    {
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("email", $email);
        return $user;
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return bool true if okey, false if something went wrong.
     */
    public function callbackSubmit() : bool
    {
        $password      = $this->form->value("password");
        $passwordAgain = $this->form->value("password-again");

        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $user->find("id", $this->form->value("id"));
        $user->name = $this->form->value("name");
        $user->email = $this->form->value("email");
        $user->birthdate = $this->form->value("birthdate");
        $user->tel = $this->form->value("tel");
        $user->gravatar($this->form->value("email"));
        if ($password !== "") {
            $user->setPassword($password);
            // Check password matches
            if ($password !== $passwordAgain) {
                $this->form->rememberValues();
                $this->form->addOutput("Password did not match.");
                return false;
            }
        }

        $user->save();
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
