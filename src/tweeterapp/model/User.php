<?php
namespace tweeterapp\model;
class User extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'user';
    protected $primarykey = 'id';
    public $timestamps = false;
    //Récupère les tweets de l'auteur demandé (ForeignKey)
    public function tweets(){
        return $this->hasMany('tweeterapp\model\Tweet', 'author');
    }
    //Récupère les followers de l'utilisateur(followee) dans la table Follow
    public function followedBy(){
        return $this->belongsToMany('tweeterapp\model\User','follow','followee','follower');
    }
    //Récupère l'id du tweet et l'id du user ayant like le tweet. Dans la table Like
    public function liked(){
        return $this->belongsToMany('tweeterapp\model\Tweet','like','user_id','tweet_id');
    }
    //Récupère les id des followers que l'utilisateur suit dans la table Follow
    public function follows(){
        return $this->belongsToMany('tweeterapp\model\User','follow','follower','followee');
    }
    //Récupère comme FollowedBy les followers de l'utilisateur et compte son nombre
    public function followedCount(){
        return $this->belongsToMany('tweeterapp\model\User','follow','followee','follower')->count();
    }
}
