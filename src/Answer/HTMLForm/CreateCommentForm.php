<?php

namespace Elpr\Answer\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Elpr\Answer\Answer;
use Elpr\Answer\Acomment;

/**
 * Example of FormModel implementation.
 */
class CreateCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, int $aid, int $qid)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Add comment",
            ],
            [
                "aid" => [
                    "type" => "hidden",
                    "required" => "true",
                    "value" => $aid
                ],
                "qid" => [
                    "type" => "hidden",
                    "required" => "true",
                    "value" => $qid
                ],

                "text" => [
                    "type"        => "textarea",
                    "placeholder" => "Write your comment...",
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
        $aid = $this->form->value("aid");
        $session = $this->di->get("session");

        $comment = new Acomment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->text = $text;
        $comment->aid = $aid;
        $comment->created = time();
        $comment->uid = $session->get("userId");
        $comment->score = 0;
        $comment->save();

        $this->form->addOutput("Comment was created.");
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
