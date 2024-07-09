<?php

class UserController
{
    private $userDao;

    public function __construct()
    {
        $this->userDao = new UserDaoImpl();
    }

    public function index()
    {
        $loginSubmitted = filter_input(INPUT_POST, "btnLogin");
        if (isset($loginSubmitted)) {
            $email = filter_input(INPUT_POST, "txtEmail");
            $password = filter_input(INPUT_POST, "txtPassword");
            $result = $this->userDao->userLogin($email, $password);
            if ($result != NULL && $result->getEmail() == $email) {
                $_SESSION["web_user"] = true;
                $_SESSION["web_user_id"] = $result->getId();
                $_SESSION["web_user_name"] = $result->getName();
                $_SESSION["web_user_role"] = $result->getRole();
                header("location:index.php");
            } else {
                echo "<div class='bg-danger'>Invalid id or password</div>";
            }
        }
        include_once 'View/login-view.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('location:index.php');
    }

    public function register()
    {
        $submitPressed = filter_input(INPUT_POST, 'btnSubmit');
        if (isset($submitPressed)) {
            $name = filter_input(INPUT_POST,'txtName');
            $noHP = filter_input(INPUT_POST,'txtNoHP');
            $email = filter_input(INPUT_POST,'txtEmail');
            $password = filter_input(INPUT_POST,'txtPassword');
            $trimName = trim($name);
            $trimNoHP = trim($noHP);
            $trimEmail = trim($email);
            $trimPassword = trim($password);
            if (empty($trimName) || empty($trimNoHP) || empty($trimEmail) || empty($trimPassword)) {
                echo '<div class="bg-error">Please fill Carefully</div>';
            } else {
                $user = new User();
                $user->setName($trimName);
                $user->setPhone($trimNoHP);
                $user->setEmail($trimEmail);
                $user->setPassword($trimPassword);
                $result = $this->userDao->register($user);
                if ($result) {
                    echo '<div class="bg-success">Data succesfully added</div>';
                    header('location:index.php?key=login');
                } else {
                    echo '<div class="bg-danger">Error on add data</div>';
                }
            }
        }
        include_once 'View/register-view.php';
    }
}