<?php

namespace Elpr\Answer\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Elpr\Answer\Answer;
use Elpr\Answer\Acomment;

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
    public function __construct(ContainerInterface $di, int $id, int $qid)
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

                "aid" => [
                    "type" => "hidden",
                    "required" => "true",
                    "value" => $comment->aid
                ],

                "qid" => [
                    "type" => "hidden",
                    "required" => "true",
                    "value" => $qid
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
        $comment = new Acomment();
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
        $aid = $this->form->value("aid");
        $session = $this->di->get("session");

        $comment = $this->getItemDetails($this->form->value("id"));
        $comment->setDb($this->di->get("dbqb"));
        $comment->text = $text;
        $comment->aid = $aid;
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
