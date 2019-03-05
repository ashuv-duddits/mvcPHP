<?php
class index_controller extends Core_Abstract_Controller
{
    public function indexAction()
    {
        if (!$this->session->isGuest()) {
            $this->redirect('/user/index');
        }
        $error = !empty($_GET['error']) ? true : false;
        $this->view->error = $error;
    }

    public function loginAction()
    {
        if (empty($_POST['login']) || empty($_POST['password'])) {
            //throw new Exception('Вы ввели неверные регистрационные данные');
        }
        $user = user_model_db::getModelByLogin($_POST['login']);
        if ($user == null && !empty($_POST['login'])) {
            $receiveLogin = strtolower(trim($userData['login']));
            $receivePassword = sha1(trim($userData['password']));
            $user = new user_model(['login' => $receiveLogin, 'password' => $receivePassword]);
            $userId = user_model_db::saveUser($user);
            $this->session->login($userId);
        } elseif (!empty($_POST['login']) && sha1(trim($_POST['password'])) == $user->getPassword()) {
            $userId = $user->getId();
            $this->session->login($userId);
        } else {
            $this->redirect('/index/index?error=1');
        }
        $this->redirect('/index/index');
    }

    public function logoutAction()
    {
        $this->session->logout();
        $this->redirect('/index/index');
    }
}
