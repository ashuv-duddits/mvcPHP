<?php
//namespace App\controllers;

class UserController extends BaseController
{
    public function indexAction($requestController)
    {
        $id = $_SESSION['user_id'];
        $userModel = UserDB::getModelById($id);
        $error = !empty($_GET['error']) ? true : false;
        return $this->render($requestController, 'index', ['user' => $userModel, 'error' => $error]);
    }
    public function dataAction($requestController)
    {
        $message = htmlspecialchars($_POST['message']);
        if (empty($message)) {
            $this->redirect('/user/index?error=1');
            exit();
        }
        $userId = $this->session->getUser();
        $post = new Post(['user_id' => $userId, 'message' => $message]);
        $postId = PostDB::savePost($post);

        if (!empty($_FILES['userfile']['tmp_name'])) {
            $fileContent = file_get_contents($_FILES['userfile']['tmp_name']);
            $nameFile = $postId . '.png';
            $url = realpath('images') . DIRECTORY_SEPARATOR . $nameFile;
            $fileModel = FileDB::getModelById($postId);
            $fileModel->setUrl($nameFile);
            FileDB::updateFile($fileModel);
            file_put_contents($url, $fileContent);
        }
        return $this->render($requestController, 'data');
    }
}
