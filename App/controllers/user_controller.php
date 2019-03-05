<?php
class user_controller extends Core_Abstract_Controller
{
    public function indexAction()
    {
        $id = $_SESSION['user_id'];
        $userModel = user_model_db::getModelById($id);
        $this->view->user = $userModel;
        $error = !empty($_GET['error']) ? true : false;
        $this->view->error = $error;
    }
    public function dataAction()
    {
        $message = htmlspecialchars($_POST['message']);
        if (empty($message)) {
            $this->redirect('/user/index?error=1');
            exit();
        }
        $userId = $this->session->getUser();
        $post = new post_model(['user_id' => $userId, 'message' => $message]);
        $postId = post_model_db::savePost($post);

        if (!empty($_FILES['userfile']['tmp_name'])) {
            $fileContent = file_get_contents($_FILES['userfile']['tmp_name']);
            $nameFile = $postId . '.png';
            $url = realpath('images') . DIRECTORY_SEPARATOR . $nameFile;
            $fileModel = file_model_db::getModelById($postId);
            $fileModel->setUrl($nameFile);
            file_model_db::updateFile($fileModel);
            file_put_contents($url, $fileContent);
        }
    }
}
