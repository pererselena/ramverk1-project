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
use Elpr\Filter\TextFilter;

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
        $page->add("home/flash", [], "flash");
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
        $page = $this->di->get("page");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $tagToQuestion = new TagToQuestion();
        $tagToQuestion->setDb($this->di->get("dbqb"));
        $qids = $tagToQuestion->findAllWhere("tid = ?", $id);
        $questions = array();
        $textFilter = new TextFilter();
        foreach ($qids as $qid) {
            array_push($questions, $question->findById($qid->qid));
        }

        foreach ($questions as $quest) {
            $quest->tags = [];
            $tags = $tagToQuestion->findAllWhere("qid = ?", $quest->id);
            $quest->text = $textFilter->markdown($quest->text);
            if ($tags) {
                $tagArr = array();
                foreach ($tags as $item) {
                    $tag = new Tag();
                    $tag->setDb($this->di->get("dbqb"));
                    array_push($tagArr, $tag->findWhere("id = ?", $item->tid));
                }
                $quest->tags = $tagArr;
            }
            $quest->numAns = sizeof($quest->getAnswers($this->di));
            $user = new User();
            $user->setDb($this->di->get("dbqb"));
            $quest->user = $user->findById($quest->uid);
            $quest->user->getReputation($this->di);
        }

        $page->add("question/bytag", [
            "questions" => $questions,
        ]);
        return $page->render([
            "title" => "A index page",
        ]);
    }
}
