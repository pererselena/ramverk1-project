<?php

namespace Elpr\Answer\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Elpr\Answer\Answer;

/**
 * Example of FormModel implementation.
 */
class UpdateAnswerForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, int $id)
    {
        parent::__construct($di);
        $answer = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update answer",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $answer->id,
                ],

                "qid" => [
                    "type" => "hidden",
                    "required" => "true",
                    "value" => $answer->qid
                ],

                "text" => [
                    "type"        => "textarea",
                    "value" => $answer->text,
                    "required" => "true"
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Update",
                    "callback" => [$this, "callbackSubmit"],
                    "class" => "primaryBtn"
                ],
            ]
        );
    }

    /**
     * Get details on item to load form with.
     *
     * @param integer $id get details on item with id.
     * @return Answer
     */
    public function getItemDetails($id): object
    {
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->findById($id);
        return $answer;
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
        $text = $this->form->value("text");
        $qid = $this->form->value("qid");
        $session = $this->di->get("session");

        $answer = $this->getItemDetails($this->form->value("id"));
        $answer->setDb($this->di->get("dbqb"));
        $answer->text = $text;
        $answer->qid = $qid;
        $answer->updated = time();
        $answer->uid = $session->get("userId");
        $answer->save();

        $this->form->addOutput("answer was updated.");
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
        $qid = $this->form->value("qid");
        $this->di->get("response")->redirect("questions/question/$qid")->send();
    }
}
