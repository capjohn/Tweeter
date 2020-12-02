<?php
namespace tweeterapp\control;

class TweeterAdminController extends \mf\control\AbstractController
{
    public function _construct()
    {
        parent::_construct();
    }
    public function login()
    {
        $vue = new \tweeterapp\view\TweeterView(null);
        $vue->render('login');
    }
    public function checkLogin()
    {
        $post = $this->request->post;
        $auth = new \tweeterapp\auth\TweeterAuthentification();
        $auth->loginUser($post["username"],$post["password"]);
        \mf\router\Router::executeRoute('perso');
    }
    public function logout()
    {
        $auth = new \mf\auth\Authentification();
        $auth->logout();
        \mf\router\Router::executeRoute('home');
    }
    public function checkSignup()
    {
        $auth = new \tweeterapp\auth\TweeterAuthentification();
        $vue = new \tweeterapp\view\TweeterView(null);

        if(isset($this->request->post['username'], $this->request->post['password'],$this->request->post['fullname']))
        {
            $auth->createUser($this->request->post['username'], $this->request->post['password'],$this->request->post['fullname']);
            \mf\router\Router::executeRoute('login');
        }
        else
        {
            $vue->render('signup');
        }
    }
    public function signup(){
        $vue = new \tweeterapp\view\TweeterView(null);
        $vue->render('signup');
    }

    //Controller du tableau de bord de l'admin avec les données des followers des utilisateurs par ordre décroissant
    public function tableau(){
        $users = \tweeterapp\model\User::select('id','username')->orderBy('followers','DESC')->get();
        foreach($users as $user)
        {
            $user->followers = $user->followedCount();
            $user->save();
            $liste_user[$user->username] = $user->followedBy()->get();
        }
        $vue = new \tweeterapp\view\TweeterView($liste_user);
        $vue->render('tableau');
    }
}