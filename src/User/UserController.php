<?php

namespace Elpr\User;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;
use Elpr\Answer\Acomment;
use Elpr\Answer\Answer;
use Elpr\Question\Question;
use Elpr\User\HTMLForm\UserLoginForm;
use Elpr\User\HTMLForm\CreateUserForm;
use Elpr\User\HTMLForm\UpdateForm;
use Elpr\User\User;
use Elpr\Question\Qcomment;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 */
class UserController implements ContainerInjectableInterface
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
    public function indexActionGet() : object
    {
        $page = $this->di->get("page");;
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $users = $user->findAll();
        foreach ($users as $curUser) {
            $curUser->activityScore($this->di);
        }

        $page->add("user/users", [
            "users" => $users,
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
    public function loginAction() : object
    {
        $page = $this->di->get("page");
        $form = new UserLoginForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A login page",
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
    public function registerAction() : object
    {
        $page = $this->di->get("page");
        $form = new CreateUserForm($this->di);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "A create user page",
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
     * @return bool
     */
    public function logoutAction()
    {
        if ($this->isLoggedIn()) {
            $session = $this->di->get("session");
            $session->delete("userEmail");
        }
        return $this->di->response->redirect("user/login");
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
    public function profileAction(): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $session = $this->di->get("session");
        $id = $session->get("userId");
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->findAllWhere("uid = ?", $id);
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllWhere("uid = ?", $id);
        $acomment = new Acomment();
        $acomment->setDb($this->di->get("dbqb"));
        $acomments = $acomment->findAllWhere("uid = ?", $id);
        $qcomment = new Qcomment();
        $qcomment->setDb($this->di->get("dbqb"));
        $qcomments = $qcomment->findAllWhere("uid = ?", $id);
        $numQuest = count($questions);
        $numAnswer = count($answers);
        $numComments = count($acomments) + count($qcomments);
        foreach ($acomments as $acomment) {
            $acomment->qid = $answer->findWhere("id = ?", $acomment->aid)->qid;
        }

        $page->add("user/profile", [
            "user" => $user->findWhere("email = ?", $session->get("userEmail")),
            "questions" => $questions,
            "answers" => $answers,
            "acomments" => $acomments,
            "numQuest" => $numQuest,
            "numAnswer" => $numAnswer,
            "numComments" => $numComments,
            "qcomments" => $qcomments,
        ]);

        return $page->render([
            "title" => "Profile",
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
    public function userprofileActionGet(int $id): object
    {
        $page = $this->di->get("page");;
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $profile = $user->findById($id);
        $question = new Question();
        $question->setDb($this->di->get("dbqb"));
        $questions = $question->findAllWhere("uid = ?", $id);
        $answer = new Answer();
        $answer->setDb($this->di->get("dbqb"));
        $answers = $answer->findAllWhere("uid = ?", $id);
        $acomment = new Acomment();
        $acomment->setDb($this->di->get("dbqb"));
        $acomments = $acomment->findAllWhere("uid = ?", $id);
        $qcomment = new Qcomment();
        $qcomment->setDb($this->di->get("dbqb"));
        $qcomments = $qcomment->findAllWhere("uid = ?", $id);
        $numQuest = count($questions);
        $numAnswer = count($answers);
        $numComments = count($acomments) + count($qcomments);
        foreach ($acomments as $acomment) {
            $acomment->qid = $answer->findWhere("id = ?", $acomment->aid)->qid;
        }


        $page->add("user/profile-id", [
            "profile" => $profile,
            "questions" => $questions,
            "answers" => $answers,
            "acomments" => $acomments,
            "numQuest" => $numQuest,
            "numAnswer" => $numAnswer,
            "numComments" => $numComments,
            "qcomments" => $qcomments,
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
    public function updateAction(): object
    {
        if (!$this->isLoggedIn()) {
            return $this->di->response->redirect("user/login");
        }
        $page = $this->di->get("page");
        $user = new User();
        $user->setDb($this->di->get("dbqb"));
        $session = $this->di->get("session");
        $email = $session->get("userEmail");
        $form = new UpdateForm($this->di, $email);
        $form->check();

        $page->add("anax/v2/article/default", [
            "content" => $form->getHTML(),
        ]);

        return $page->render([
            "title" => "Update profile",
        ]);
    }
}
