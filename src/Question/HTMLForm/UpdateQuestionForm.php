<?php

namespace Elpr\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Elpr\Question\Question;
use Elpr\Question\TagToQuestion;
use Elpr\Tag\Tag;

/**
 * Example of FormModel implementation.
 */
class UpdateQuestionForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di, $id)
    {
        parent::__construct($di);
        $question = $this->getItemDetails($id);
        $allTags = $question->getAllTags($di);
        $selectedTags = $question->getTags($di, $id);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update question",
            ],
            [
                "id" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "readonly" => true,
                    "value" => $question->id,
                ],
                "title" => [
                    "type"        => "text",
                    "required" => "true",
                    "value" => $question->title,
                ],

                "text" => [
                    "type"        => "textarea",
                    "value" => $question->text
                ],

                "tags" => [
                    "type" => "select-multiple",
                    "label" => "Select one or more tags",

                    "options" => $allTags,
                    "checked"   => $selectedTags,
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
     * @return Question
     */
    public function getItemDetails($id): object
    {
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->findById($id);
        return $question;
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
        $title = $this->form->value("title");
        $text = $this->form->value("text");
        $tag = $this->form->value("tags");
        $session = $this->di->get("session");

        $question = $this->getItemDetails($this->form->value("id"));
        $question->setDb($this->di->get("dbqb"));
        $question->title = $title;
        $question->text = $text;
        $question->updated = time();
        $question->uid = $session->get("userId");
        $question->save();
        $question->deleteTags($this->di);

        foreach ($tag as $key => $value) {
            var_dump($value);
            $tagToQuestion = new TagToQuestion();
            $tagToQuestion->setDb($this->di->get("dbqb"));
            $tagToQuestion->qid = $question->id;
            $tagToQuestion->tid = $value;
            $tagToQuestion->save();
        }

        $this->form->addOutput("question was created.");
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
        $qid = $this->form->value("id");
        $this->di->get("response")->redirect("questions/question/$qid")->send();
    }
}
