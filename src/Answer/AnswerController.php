<?php

namespace Elpr\Answer;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Elpr\Answer\HTMLForm\CreateAnswerForm;
use Elpr\Answer\HTMLForm\CreateCommentForm;
use Elpr\Answer\HTMLForm\UpdateCommentForm;
use Elpr\Answer\HTMLForm\UpdateAnswerForm;
use Elpr\Answer\Answer;
use Elpr\User\User;
use Elpr\Answer\Acomment;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class AnswerController implements ContainerInjectableInterface
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
    public function createcommentAction(int $aid): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $qid = $answer->findById($aid)->qid;
        $form = new CreateCommentForm($this->di, $aid, $qid);
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
    public function updatecommentAction(int $aid): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $qid = $answer->findById($aid)->qid;
        $form = new UpdateCommentForm($this->di, $aid, $qid);
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
    public function createAction(int $qid): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $form = new CreateAnswerForm($this->di, $qid);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create answer page",
        ]);
    }

    // /**
    //  * Description.
    //  *
    //  * @param datatype $variable Description
    //  *
    //  * @throws Exception
    //  *
    //  * @return object as a response object
    //  */
    // public function questionActionGet(int $id): object
    // {
    //     $page = $this->di->get("page");;
    //     $question = new Question();
    //     $question->setDb($this->di->get("dbqb"));
    //     $quest = $question->findById($id);
    //     $tagToQuestion = new TagToQuestion();
    //     $tagToQuestion->setDb($this->di->get("dbqb"));

    //     $quest->tags = [];
    //     $tags = $tagToQuestion->findAllWhere("qid = ?", $quest->id);
    //     if ($tags) {
    //         $tagArr = array();
    //         foreach ($tags as $key => $item) {
    //             $tag = new Tag();
    //             $tag->setDb($this->di->get("dbqb"));
    //             array_push($tagArr, $tag->findWhere("id = ?", $item->tid));
    //         }
    //         $quest->tags = $tagArr;
    //     }

    //     $user = new User();
    //     $user->setDb($this->di->get("dbqb"));
    //     $quest->user = $user->findById($quest->uid);

    //     $page->add("question/question", [
    //         "question" => $quest,
    //     ]);
    //     return $page->render([
    //         "title" => "A index page",
    //     ]);
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
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $ans = $answer->findById($id);
        if ($ans->uid == $userId) {
            $form = new UpdateAnswerForm($this->di, $id);
            $form->check();

            $page->add("anax/v2/article/default", [
                "content" => $form->getHTML(),
            ]);

            return $page->render([
                "title" => "Update answer",
            ]);
        }
        $page->add("anax/v2/article/default", [
            "content" => "OOPS!!! You are not the owner of this answer!",
        ]);

        return $page->render([
            "title" => "Error",
        ]);
    }


    // /**
    //  * Description.
    //  *
    //  * @param datatype $variable Description
    //  *
    //  * @throws Exception
    //  *
    //  * @return bool
    //  */
    // private function isLoggedIn()
    // {
    //     $session = $this->di->get("session");

    //     if ($session->get("userEmail")) {
    //         return true;
    //     }

    //     return false;
    // }

    // /**
    //  * Description.
    //  *
    //  * @param datatype $variable Description
    //  *
    //  * @throws Exception
    //  *
    //  * @return bool
    //  */
    // public function logoutAction()
    // {
    //     if ($this->isLoggedIn()) {
    //         $session = $this->di->get("session");
    //         $session->delete("userEmail");
    //     }
    //     return $this->di->response->redirect("user/login");
    // }

    // /**
    //  * Description.
    //  *
    //  * @param datatype $variable Description
    //  *
    //  * @throws Exception
    //  *
    //  * @return object as a response object
    //  */
    // public function profileAction(): object
    // {
    //     if (!$this->isLoggedIn()) {
    //         return $this->di->response->redirect("user/login");
    //     }
    //     $page = $this->di->get("page");
    //     $user = new User();
    //     $user->setDb($this->di->get("dbqb"));
    //     $session = $this->di->get("session");

    //     $page->add("user/profile", [
    //         "user" => $user->findWhere("email = ?", $session->get("userEmail")),
    //     ]);

    //     return $page->render([
    //         "title" => "Profile",
    //     ]);
    // }


}
