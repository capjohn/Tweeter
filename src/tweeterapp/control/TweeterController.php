<?php

namespace tweeterapp\control;

/* Classe TweeterController :
 *  
 * Réalise les algorithmes des fonctionnalités suivantes: 
 *
 *  - afficher la liste des Tweets 
 *  - afficher un Tweet
 *  - afficher les tweet d'un utilisateur 
 *  - afficher la le formulaire pour poster un Tweet
 *  - afficher la liste des utilisateurs suivis 
 *  - évaluer un Tweet
 *  - suivre un utilisateur
 *   
 */

class TweeterController extends \mf\control\AbstractController {


    /* Constructeur :
     * 
     * Appelle le constructeur parent
     *
     * c.f. la classe \mf\control\AbstractController
     * 
     */
    
    public function __construct(){
        parent::__construct();
    }


    /* Méthode viewHome : 
     * 
     * Réalise la fonctionnalité : afficher la liste de Tweet
     * 
     */
    
    public function viewHome(){

        $tweets = \tweeterapp\model\Tweet::orderBy('created_at','DESC')->get();
        $vue = new \tweeterapp\view\TweeterView($tweets);
        $vue->render('home');
        /* Algorithme :
         *  
         *  1 Récupérer tout les tweet en utilisant le modèle Tweet
         *  2 Parcourir le résultat 
         *      afficher le text du tweet, l'auteur et la date de création
         *  3 Retourner un block HTML qui met en forme la liste
         * 
         */
        
    }

    /* Méthode viewTweet : 
     *  
     * Réalise la fonctionnalité afficher un Tweet
     *
     */
    
    public function viewTweet(){
        $id = $this->request->get;
        $tweet = \tweeterapp\model\Tweet::select()->where('id','=',$id)->first();
        $vue = new \tweeterapp\view\TweeterView($tweet);
        $vue->render('view');
        /* Algorithme : 
         *  
         *  1 L'identifiant du Tweet en question est passé en paramètre (id) 
         *      d'une requête GET 
         *  2 Récupérer le Tweet depuis le modèle Tweet
         *  3 Afficher toutes les informations du tweet 
         *      (text, auteur, date, score)
         *  4 Retourner un block HTML qui met en forme le Tweet
         * 
         *  Erreurs possibles : (*** à implanter ultérieurement ***)
         *    - pas de paramètre dans la requête
         *    - le paramètre passé ne correspond pas a un identifiant existant
         *    - le paramètre passé n'est pas un entier 
         * 
         */

    }


    /* Méthode viewUserTweets :
     *
     * Réalise la fonctionnalité afficher les tweet d'un utilisateur
     *
     */
    
    public function viewUserTweets(){
        $id = $this->request->get;
        $user = \tweeterapp\model\User::where('id','=', $id)->first();
        $liste_tweet = $user->tweets()->orderBy('created_at','DESC')->get();
        $vue = new \tweeterapp\view\TweeterView($liste_tweet);
        $vue->render('user');
        /*
         *
         *  1 L'identifiant de l'utilisateur en question est passé en 
         *      paramètre (id) d'une requête GET 
         *  2 Récupérer l'utilisateur et ses Tweets depuis le modèle 
         *      Tweet et User
         *  3 Afficher les informations de l'utilisateur 
         *      (non, login, nombre de suiveurs) 
         *  4 Afficher ses Tweets (text, auteur, date)
         *  5 Retourner un block HTML qui met en forme la liste
         *
         *  Erreurs possibles : (*** à implanter ultérieurement ***)
         *    - pas de paramètre dans la requête
         *    - le paramètre passé ne correspond pas a un identifiant existant
         *    - le paramètre passé n'est pas un entier 
         * 
         */
        
    }

    public function viewPost(){
        $vue = new \tweeterapp\view\TweeterView("");
        $vue->render('post');
    }

    public function viewSend(){
        $username= $_SESSION['user_login'];
        $user = \tweeterapp\model\User::where('username','=', $username)->first();
        $tweet = new \tweeterapp\model\Tweet();
        $tweet->text = filter_var($this->request->post['value'],FILTER_SANITIZE_SPECIAL_CHARS);
        $tweet->author = $user->id;
        $tweet->score = 0;
        $tweet->save();
        $vue = new \tweeterapp\view\TweeterView("");
        $vue->render('send');
    }

    public function viewLike(){
        $user = \tweeterapp\model\User::where('username','=', $_SESSION['user_login'])->first();
        $id = $this->request->get;
        $requete = \tweeterapp\model\Tweet::select()->where('id','=',$id);
        $tweet = $requete->first();
        $requeteLike = \tweeterapp\model\Like::where('user_id','=',$user->id)->where('tweet_id','=',$tweet->id)->first();
        if(!$requeteLike)
        {
            $like = new \tweeterapp\model\Like();
            $like->user_id = $user->id;
            $like->tweet_id = $tweet->id;
            $like->save();
            $final_tweet = \tweeterapp\model\Tweet::find($tweet->id);
            $final_tweet->score = (($tweet->score)+1);
            $final_tweet->save();
            $vue = new \tweeterapp\view\TweeterView($final_tweet);
        }
        else{
            $like = \tweeterapp\model\Like::find($requeteLike->id);
            $like->delete();
            $final_tweet = \tweeterapp\model\Tweet::find($tweet->id);
            $final_tweet->score = (($tweet->score)-1);
            $final_tweet->save();
            $vue = new \tweeterapp\view\TweeterView($final_tweet);
        }
        $vue->render('view');
    }
    public function viewFollow(){
        $user = \tweeterapp\model\User::where('username','=', $_SESSION['user_login'])->first();
        $id = $this->request->get;
        $requete = \tweeterapp\model\Tweet::select()->where('id','=',$id);
        $tweet = $requete->first();
        $requeteFollow = \tweeterapp\model\Follow::where('follower','=',$user->id)->where('followee','=',$tweet->author)->first();
        if(empty($requeteFollow))
        {
            $follow = new \tweeterapp\model\Follow();
            $follow->follower=$user->id;
            $follow->followee=$tweet->author;
            $follow->save();
            $user->followers = $user->followedCount();
            $user->save();
        }
        else{
            echo("Vous suivez déja cette personne");
        }
        $vue = new \tweeterapp\view\TweeterView($tweet);
        $vue->render('view');
    }

    public function viewPerso(){
        $user = \tweeterapp\model\User::where('username','=', $_SESSION['user_login'])->first();
        $follow = $user->follows()->get();
        foreach($follow as $following)
        {
            $liste_tweet[$following->username] = $following->tweets()->orderBy('created_at','DESC')->get();
        }
        $liste_tweet[1]= $user->followedBy()->get();
        $vue = new \tweeterapp\view\TweeterView($liste_tweet);
        $vue->render('perso');
    }
}
