<?php

namespace tweeterapp\view;

class TweeterView extends \mf\view\AbstractView {
  
    /* Constructeur 
    *
    * Appelle le constructeur de la classe parent
    */
    public function __construct( $data ){
        parent::__construct($data);
    }

    /* Méthode renderHeader
     *
     *  Retourne le fragment HTML de l'entête (unique pour toutes les vues)
     */ 
    private function renderHeader(){

        $header  = <<<EOT
        <h1>MiniTweeTR</h1>
EOT;
        return $header;
    }

    private function renderTopMenu(){
        $auth = new \mf\auth\Authentification();
        $rooter = new \mf\router\Router();
        $urlHome = $rooter->urlFor('home',null);
        $urlLogin = $rooter->urlFor('login',null);
        $urlSignup = $rooter->urlFor('signup',null);
        $urlperso = $rooter->urlFor('perso',null);
        $urlLogout = $rooter->urlFor('logout',null);
        $app_root = (new \mf\utils\HttpRequest())->root;
        if($auth->logged_in)
        {
            $menu  = <<<EOT
            <div class="tweet-control">
            <a href="${urlHome}">
                <img alt="home" src="$app_root/html/home.png">
            </a>
        </div>
        <div class="tweet-control">
            <a href="${urlperso}">
                <img alt="follow" src="$app_root/html/followees.png">
            </a>
        </div>
        <div class="tweet-control">
            <a href="${urlLogout}">
                <img alt="logout" src="$app_root/html/logout.png">
            </a>
        </div>
EOT;
        }
        else{
            $menu  = <<<EOT
            <div class="tweet-control">
            <a href="${urlHome}">
                <img alt="home" src="$app_root/html/home.png">
            </a>
        </div>
        <div class="tweet-control">
            <a href="${urlLogin}">
                <img alt="login" src="$app_root/html/login.png">
            </a>
        </div>
        <div class="tweet-control">
            <a href="${urlSignup}">
                <img alt="signup" src="$app_root/html/signup.png">
            </a>
        </div>
EOT;
        }
        return $menu;
    }
    
    /* Méthode renderFooter
     *
     * Retourne le fragment HTML du bas de la page (unique pour toutes les vues)
     */
    private function renderFooter(){
        return 'La super app créée en Licence Pro &copy;2020';
    }

    /* Méthode renderHome
     *
     * Vue de la fonctionalité afficher tous les Tweets. 
     *  
     */
    private function renderHome(){

        $r = new \mf\router\Router();
        $chaine_retour ="<h2> Derniers Tweets</h2>";
        
        foreach ($this->data as $tweet){
            
            $hrefTweet = $r->urlFor("view",array(["id",$tweet->id]));
            $hrefUser = $r->urlFor("user",array(["id",$tweet->author]));
            
            $chaine_retour = $chaine_retour."<div class=\"tweet\"><a href=\"$hrefTweet\"><div class=\"tweet-text\">".$tweet->text."</div></a><div class=\"tweet-footer\"><span class=\"tweet-timestamp\">".$tweet->created_at."</span><span class=\"tweet-author\"><a href=\"$hrefUser\">".$tweet->author()->first()->fullname."</a></span></div></div>";
        }

        return $chaine_retour;
        /*
         * Retourne le fragment HTML qui affiche tous les Tweets. 
         *  
         * L'attribut $this->data contient un tableau d'objets tweet.
         * 
         */        
    }

    /* Méthode renderUserTweets
     *
     * Vue de la fonctionalité afficher tout les Tweets d'un utilisateur donné. 
     * 
     */
     
    private function renderUserTweets(){
        $r = new \mf\router\Router();
        $chaine_retour= "<h2>Tweets de ";
        $passage =1;
        foreach ($this->data as $tweet){
            $hrefTweet = $r->urlFor("view",array(["id",$tweet->id]));
            if($passage>0)
            {
                $chaine_retour = $chaine_retour.$tweet->author()->first()->fullname."</h2>";
                $passage--;
            }
            $chaine_retour = $chaine_retour."<div class=\"tweet\"><a href=\"$hrefTweet\">$tweet->text</a><div class=\"tweet-footer\"><span class=\"tweet-timestamp\">".$tweet->created_at."</span><span class=\"tweet-author\">".$tweet->author()->first()->fullname."</span></div></div>";
        }
        return $chaine_retour;
        /* 
         * Retourne le fragment HTML pour afficher
         * tous les Tweets d'un utilisateur donné. 
         *  
         * L'attribut $this->data contient un objet User.
         *
         */
        
    }
  
    /* Méthode renderViewTweet 
     * 
     * Rréalise la vue de la fonctionnalité affichage d'un tweet
     *
     */
    private function renderViewTweet(){
        $rooter = new \mf\router\Router();
        $urlLike = $rooter->urlFor('like',null);
        $chaine_retour = "<div class=\"tweet\">";
        $hrefTweet = $rooter->urlFor("user",array(["id",$this->data->author]));
        $urlLike = $rooter->urlFor('like',array(["id",$this->data->id]));
        $urlFollow = $rooter->urlFor('follow',array(["id",$this->data->id]));
        $app_root = (new \mf\utils\HttpRequest())->root;
        $chaine_retour .= "
        <div class=\"tweet-text\">"
            .$this->data->text.
        "</div>
        <div class=\"tweet-footer\">
            <span class=\"tweet-timestamp\">"
                .$this->data->created_at.
            "</span>
            <span class=\"tweet-author\">
                <a href=\"$hrefTweet\">".$this->data->author()->first()->fullname."</a>
            </span>
        </div>
        <div class=\"tweet-footer\"><hr>
            <span class=\"tweet-score tweet-control\">".$this->data->score."</span>";
        $auth = new \mf\auth\Authentification();
        if($auth->logged_in)
        {
            $chaine_retour .="<a class=\"tweet-control\" href=\"${urlLike}\">
                <img alt=\"Like\" src=\"$app_root/html/like.png\">
            </a>
            <a class=\"tweet-control\" href=\"${urlFollow}\">
                <img alt=\"Like\" src=\"$app_root/html/follow.png\">
            </a>
        </div>";
        }
        else{
            $chaine_retour .= "</div>";
        }
        return $chaine_retour."</div>";
            /* 
         * Retourne le fragment HTML qui réalise l'affichage d'un tweet 
         * en particulié 
         * 
         * L'attribut $this->data contient un objet Tweet
         *
         */
    }

    /* Méthode renderPostTweet
     *
     * Realise la vue de régider un Tweet
     *
     */
    protected function renderPostTweet(){
        
        /* Méthode renderPostTweet
         *
         * Retourne la framgment HTML qui dessine un formulaire pour la rédaction 
         * d'un tweet, l'action (bouton de validation) du formulaire est la route "/send/"
         *
         */
        $r = new \mf\router\Router();
        $url = $r->urlFor("send",null);
        $formulaire = <<<EOT
        <form method="post" class="forms" action="${url}">
            <textarea id="tweet-form" name="value">
            </textarea>
            <br>
            <button id="send_button" type="submit">
            Envoyer
            </button>
        </form>
EOT;
        return $formulaire;    
    }

    //Retourne une chaine de caractère HTML après l'enregistrement du tweet dans la BDD
    protected function renderSend()
    {
        return "<div>Tweet ajouté à la base de données avec succés!</div>";
    }

    //Retourne le code HTML du formulaire de connexion demandant le nom d'utilisateur et son mot de passe
    private function renderLogin(){
        $r = new \mf\router\Router();
        $url = $r->urlFor("checklogin",null);
        $formulaire = <<<EOT
            <form method="post" class="forms" action="${url}">
                <input class="forms-text" type="text" name="username" placeholder="Ici votre username">
                <br>
                <input class="forms-text" type="password" name="password" placeholder="Password">
                <button class="forms-button" type="submit">
                Login
                </button>
            </form>
EOT;
        return $formulaire;   
    }
    
    //Retourne un code HTML qui affiche si l'utilisateur est authentifié, un bouton "NEW" en bas de page qui envoi à la vue Post Tweet 
    private function renderBottomMenu(){

        $auth = new \mf\auth\Authentification();
        $chaine_button = "";
        if($auth->logged_in)
        {
            $r = new \mf\router\Router();
            $url = $r->urlFor("post",null);
            $chaine_button .= <<<EOT
            <nav class=theme-backcolor1>    
            <a class="theme-backcolor2" href="{$url}">
            New
            </a>
        </nav>
EOT;
        }
        return $chaine_button;
    }

    //Retourne un code HTML avec une interface de création de compte
    private function renderSignup(){
        $r = new \mf\router\Router();
        $url = $r->urlFor("checksignup",null);
        $formulaire = <<<EOT
            <form method="post" class="forms" action="${url}">
                <input class="forms-text" type="text" name="fullname" placeholder="Fullname">
                <br>
                <input class="forms-text" type="text" name="username" placeholder="Username">
                <br>
                <input class="forms-text" type="password" name="password" placeholder="Password">
                <br>
                <input class="forms-text" type="password" name="password_verify" placeholder="Retaper Password">
                <button class="forms-button" type="submit">
                Create
                </button>
            </form>
EOT;
        return $formulaire;   
    }

    // Retourne un code HTML qui affiche les personnes que vous suivez avec leurs tweets, ainsi que le nombre de personne qui vous suit ainsi que leurs liens
    private function renderPerso()
    {
        $r = new \mf\router\Router();
        $result=0;
        foreach($this->data as $key=>$tweets)
        {
            if(empty($key))
            {
                $result=1;
            }
        }
        if($result){
            $chaine_retour ="<br><h3>Vous ne suivez personne et aucune personne vous suit</h3>";
        }
        else
        {
            $chaine_retour ="<h3>Vos Suivis :</h3>";
            $nb=0;
            foreach ($this->data as $key=>$tweets)
            {
                if(gettype($key)=="string")
                {
                    $chaine_retour .= "<h5>$key</h5>"; 
                    foreach($tweets as $tweet)
                    {
                        $hrefTweet = $r->urlFor("view",array(["id",$tweet->id]));
                        $chaine_retour = $chaine_retour."<div class=\"tweet\"><a href=\"$hrefTweet\">$tweet->text</a><div class=\"tweet-footer\"><span class=\"tweet-timestamp\">".$tweet->created_at."</span><span class=\"tweet-author\">".$tweet->author()->first()->fullname."</span></div></div>";
                    }
                }
                else if(gettype($key)=="integer")
                {
                    foreach($tweets as $value)
                    {
                        $nb++;
                    }
                    $chaine_retour .= "<h3>Vous êtes suivi par $nb Follower(s) </h3>";
                    foreach ($tweets as $follower){
                        $hrefUser = $r->urlFor("user",array(["id",$follower->id]));
                        if(!empty($follower))
                        {
                            $chaine_retour .= "<ul class=\"suivi\"><a href=\"$hrefUser\">".$follower->username."</a></ul>";
                        }
                    }
                }            
            }
        }
        return $chaine_retour;
    }

    //Retourne un code HTML du tableau de bord de l'admin avec la liste des utilisateurs par nombre de suiveur et ses suiveurs 
    private function renderTableau()
    {
        $r = new \mf\router\Router();
        $chaine_retour ="<h3> Liste des utilisateurs (avec nombre de suiveur)</h3>";
        foreach ($this->data as $key=>$users)
        {
            //$hrefUser = $r->urlFor("user",array(["id",$iduser]));
            $nb =0;
            foreach($users as $user)
            {
                $nb++;
            }

            $chaine_retour .= "<ul id=\"menu-accordeon\"><li><a href=\"#\">$key ($nb)</a><ul>";
            foreach($users as $user)
            {
                $hrefuser = $r->urlFor("user",array(["id",$user->id]));
                $chaine_retour .= "<li><a href=\"$hrefuser\">".$user->username."</a></li>";
            }
            $chaine_retour .= "</ul></li></ul>";
            
        }
        return $chaine_retour;
    }

    /* Méthode renderBody
     *
     * Retourne la framgment HTML de la balise <body> elle est appelée
     * par la méthode héritée render.
     *
     */
    
    protected function renderBody($selector){

        $header = $this->renderHeader();
        switch($selector)
        {
            case 'home': 
                $section = $this->renderHome();
            break;
            case 'user':
                $section = $this->renderUserTweets();
            break;
            case 'view':
                $section = $this->renderViewTweet();
            break;
            case 'post':
                $section = $this->renderPostTweet();
            break;
            case 'send':
                $section = $this->renderSend();
            break;
            case 'login':
                $section = $this->renderLogin();
            break;
            case 'signup':
                $section = $this->renderSignup();
            break;
            case 'perso':
                $section = $this->renderPerso();
            break;
            case 'tableau':
                $section = $this->renderTableau();
            break;
        }
        $button = $this->renderBottomMenu();
        $footer = $this->renderFooter();
        $menu = $this->renderTopMenu();
        $html = <<<EOT
        <header class="theme-backcolor1">
            ${header}
            ${menu}
        </header>
        <section class="theme-backcolor2">
            ${section}
        </section>
        ${button}
        <footer class="theme-backcolor1">
            ${footer}
        </footer>
EOT;
        return $html;
        /*
         * voire la classe AbstractView
         * 
         */
        
    }
}
