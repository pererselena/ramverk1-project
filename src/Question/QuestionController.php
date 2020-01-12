<?php

namespace Elpr\Question;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Elpr\Question\HTMLForm\CreateCommentForm;
use Elpr\Question\HTMLForm\UpdateCommentForm;
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
class QuestionController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;



    /**
     * @var $data description
     */

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
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->findAll();
        $tagToQuestion = new TagToQuestion();
        $tagToQuestion->setDb($this->di->get("dbqb"));
        $textFilter = new TextFilter();
        
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

            $quest->text = $textFilter->markdown($quest->text);
            $user = new User();
            $user->setDb($this->di->get("dbqb"));
            $quest->user = $user->findById($quest->uid);
        }

        $page->add("question/all", [
            "questions" => $questions,
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
     * @return bool
     */
    private function isLoggedIn()
    {
        $session = $this->di->get("session");

        if ($session->get("userEmail")) {
            return true;
        }

        return false;
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
    public function createAction(): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $form = new CreateQuestionForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create question page",
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
    public function questionActionGet(int $id): object
    {
        $page = $this->di->get("page");;
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $quest = $question->findById($id);
        $tagToQuestion = new TagToQuestion();
        $tagToQuestion->setDb($this->di->get("dbqb"));
        $textFilter = new TextFilter();
        $quest->text = $textFilter->markdown($quest->text);

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

        $quest->answers = $quest->getAnswers($this->di);
        $quest->comments = $quest->getComments($this->di);
        foreach ($quest->answers as $answer) {
            $answer->comments = $answer->getComments($this->di);
        }

        $page->add("question/question", [
            "question" => $quest,
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
    public function createcommentAction(int $qid): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $form = new CreateCommentForm($this->di, $qid);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create comment page",
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
    public function updatecommentAction(int $id): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $form = new UpdateCommentForm($this->di, $id);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A update comment page",
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
    public function updateAction(int $id): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $session = $this->di->get("session");
        $userId = $session->get("userId");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $quest = $question->findById($id);
        if ($quest->uid == $userId) {
            $form = new UpdateQuestionForm($this->di, $id);
            $form->check();

            $page->add("anax/v2/article/default", [
                "content" => $form->getHTML(),
            ]);

            return $page->render([
                "title" => "Update question",
            ]);
        }
        $page->add("anax/v2/article/default", [
            "content" => "OOPS!!! You are not the owner of this question!",
        ]);

        return $page->render([
            "title" => "Error",
        ]);
    }
}
