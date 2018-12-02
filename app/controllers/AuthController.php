<?php
use App\Forms\LoginForm;
use App\Forms\RegisterForm;

class AuthController extends \Phalcon\Mvc\Controller
{

    /**
     * login page
     */
    public function indexAction()
    {
        //$this->tag->setTitle('Phalcon :: Login');
        

        if( $this->session->get('auth') ){

            return $this->response->redirect('favorites');
        }

        $this->view->form = new LoginForm();


    }

    /**
     * Register page
     */
    public function getRegisterAction()
    {
        $this->view->form = new RegisterForm();
    }

    /**
     * Sign in
     * @email
     * @password
     */
    public function signUpAction()
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect('register');
        }

        if (!$this->security->checkToken()) {
            $this->flashSession->error("Invalid Token");
            return $this->response->redirect('register');
        }
        

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');


        $user = new Users;

        $register_form = new RegisterForm();
        $register_form->bind($_POST,$user);



        if (!$register_form->isValid()) {

            foreach ($user->validate_messages as $message) {
                $this->flashSession->error($message);


                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'getRegister',
                ]);

                return;
            }



        }

        $user->setEmail($email);
        $user->setPassword($password);
        
        $resp = $user->create();


        
       if( $resp == false ){

           foreach ($user->validate_messages as $message) {
               $this->flashSession->error($message);
               break;
           }



           return $this->response->redirect('register');
       }

        $this->session->set('auth', $user->getID());

        return $this->response->redirect('favorites');

    }

    public function signInAction()
    {
        if (!$this->request->isPost()) {
            return $this->response->redirect('/');
        }
        


        if (!$this->security->checkToken()) {
            $this->flashSession->error("Invalid Token");
            return $this->response->redirect('/');
        }

        $loginForm = new LoginForm();
        $user = new Users;
        $loginForm->bind($_POST,$user);

        if (!$loginForm->isValid()) {
            foreach ($loginForm->getMessages() as $message) {
                $this->flashSession->error($message);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'login',
                ]);
                return;
            }
        }



        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');


        $user = Users::findFirst([
            'email = :email:',
            'bind' => [
                'email' => $email
            ]
        ]);

        

        if (!$user) {
            $this->flashSession->error("Invalid login ");
            return $this->response->redirect('');
        }

        if ( $user->checkPassword($password) == FALSE ){
            $this->flashSession->error("Invalid password ");
            return $this->response->redirect('');
        }




            $this->session->set('auth', $user->getID());

            return $this->response->redirect('favorites');

    }

    public function signOutAction()
    {
        $this->session->set('auth', null);
        return $this->response->redirect('');
    }
}

