<?php

namespace Elpr\Question\HTMLForm;

use Anax\HTMLForm\FormModel;
use Psr\Container\ContainerInterface;
use Elpr\Question\Question;
use Elpr\Question\TagToQuestion;

/**
 * Example of FormModel implementation.
 */
class CreateQuestionForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Psr\Container\ContainerInterface $di a service container
     */
    public function __construct(ContainerInterface $di)
    {
        parent::__construct($di);
        $question = new Question;
        $allTags = $question->getAllTags($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Create question",
            ],
            [
                "title" => [
                    "type"        => "text",
                    "required" => "true"
                ],

                "text" => [
                    "type"        => "textarea",
                    "placeholder" => "Write your question...",
                ],

                "tags" => [
                    "type" => "select-multiple",
                    "label" => "Select one or more tags",

                    "options" => $allTags
                    //"value"   => "8",
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
        $title = $this->form->value("title");
        $text = $this->form->value("text");
        $tag = $this->form->value("tags");
        $session = $this->di->get("session");

        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $question->title = $title;
        $question->text = $text;
        $question->created = time();
        $question->uid = $session->get("userId");
        $question->score = 0;
        $question->save();

        foreach ($tag as $key => $value) {
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
        $this->di->get("response")->redirect("questions")->send();
    }
}
