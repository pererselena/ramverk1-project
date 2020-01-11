<?php

namespace Elpr\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Elpr\Question\Question;
use Elpr\Question\Qcomment;

/**
 * Example of FormModel implementation.
 */
class UpdateCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, int $id)
    {
        parent::__construct($di);
        $comment = $this->getItemDetails($id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update comment",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $comment->id,
                ],

                "qid" => [
                    "type" => "hidden",
                    "required" => "true",
                    "value" => $comment->qid
                ],

                "text" => [
                    "type"        => "textarea",
                    "value" => $comment->text,
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
     * @return comment
     */
    public function getItemDetails($id): object
    {
        $comment = new Qcomment();
        $comment->setDb($this->di->get("dbqb"));
        $comment->findById($id);
        return $comment;
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

        $comment = $this->getItemDetails($this->form->value("id"));
        $comment->setDb($this->di->get("dbqb"));
        $comment->text = $text;
        $comment->qid = $qid;
        $comment->updated = time();
        $comment->uid = $session->get("userId");
        $comment->save();

        $this->form->addOutput("comment was updated.");
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
