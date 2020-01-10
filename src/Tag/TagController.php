<?php

namespace Elpr\Tag;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Elpr\Question\HTMLForm\QuestionLoginForm;
use Elpr\Question\HTMLForm\CreateQuestionForm;
use Elpr\Question\HTMLForm\UpdateQuestionForm;
use Elpr\Question\Question;
use Elpr\Question\TagToQuestion;
use Elpr\Tag\Tag;
use Elpr\User\User;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class TagController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */
    //private $data;



    // /**
    //  * The initialize method is optional and will always be called before the
    //  * target method/action. This is a convienient method where you could
    //  * setup internal properties that are commonly used by several methods.
    //  *
    //  * @return void
    //  */
    // public function initialize() : void
    // {
    //     ;
    // }



    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function indexActionGet(): object
    {
        $page = $this->di->get("page");;
        $tag = new Tag();
        $tag->setDb($this->di->get("dbqb"));
        $tags = $tag->findAll();

        $page->add("question/tags", [
            "tags" => $tags,
        ]);
        return $page->render([
            "title" => "A index page",
        ]);
    }

    /**
     * Description.
     *
     * @param datatype $variable Description
     *
     * @throws Exception
     *
     * @return object as a response object
     */
    public function tagActionGet(int $id): object
    {
        $page = $this->di->get("page");;
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $tagToQuestion = new TagToQuestion();
        $tagToQuestion->setDb($this->di->get("dbqb"));
        $qids = $tagToQuestion->findAllWhere("tid = ?", $id);
        $questions = array();
        foreach ($qids as $qid) {
            array_push($questions, $question->findById($qid->qid));
        }

        foreach ($questions as $key => $quest) {
            $quest->tags = [];
            $tags = $tagToQuestion->findAllWhere("qid = ?", $quest->id);
            if ($tags) {
                $tagArr = array();
                foreach ($tags as $key => $item) {
                    $tag = new Tag();
                    $tag->setDb($this->di->get("dbqb"));
                    array_push($tagArr, $tag->findWhere("id = ?", $item->tid));
                }
                $quest->tags = $tagArr;
            }

            $user = new User();
            $user->setDb($this->di->get("dbqb"));
            $quest->user = $user->findById($quest->uid);
        }

        $page->add("question/bytag", [
            "questions" => $questions,
        ]);
        return $page->render([
            "title" => "A index page",
        ]);
    }
}
