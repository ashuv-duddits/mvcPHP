<?php
class Core_Abstract_Controller
{
    public $tpl;
    /** @var Core_View */
    public $view;
    /** @var Core_DB */
    protected $DB;
    /** @var Core_Session */
    protected $session;

    public function __construct()
    {
        $this->session = new Core_Session();
        /** @var Core_Request */
        $request = Core_Context::getInstance()->getRequest();
        $this->tpl = strtolower($request->getRequestAction()) . '.phtml';
//
//        session_start();
//        if (isset($_SESSION['user_id'])) {
//            $userModel = User_Model_DB::getModelById($_SESSION['user_id']);
//            $this->view->user = $userModel;
//        }
    }
    protected function redirect($url)
    {
        header("Location: $url");
        exit();
    }
}