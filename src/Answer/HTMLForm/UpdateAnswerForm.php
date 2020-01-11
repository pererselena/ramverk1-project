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
    public function __construct(ContainerInterface $di, int $qid)
    {
        parent::__construct($di);
        $answer = new Answer;
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Create answer",
            ],
            [
                "qid" => [
                    "type" => "hidden",
                    "required" => "true",
                    "value" => $qid
                ],

                "text" => [
                    "type"        => "textarea",
                    "placeholder" => "Write your answer...",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create",
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
        $text = $this->form->value("text");
        $qid = $this->form->value("qid");
        $session = $this->di->get("session");

        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answer->text = $text;
        $answer->qid = $qid;
        $answer->created = time();
        $answer->uid = $session->get("userId");
        $answer->score = 0;
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
        $this->di->get("response")->redirect("../../questions/question/$qid")->send();
    }
}
