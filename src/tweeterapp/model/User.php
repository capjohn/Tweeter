<?php
namespace tweeterapp\model;
class User extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'user';
    protected $primarykey = 'id';
    public $timestamps = false;
    public function tweets(){
        return $this->hasMany('tweeterapp\model\Tweet', 'author');
    }
    public function followedBy(){
        return $this->belongsToMany('tweeterapp\model\User','follow','followee','follower');
    }
    public function liked(){
        return $this->belongsToMany('tweeterapp\model\Tweet','tweeterapp\model\Like','user_id','tweet_id');
    }
    public function follows(){
        return $this->belongsToMany('tweeterapp\model\User','tweeterapp\model\Follow','follower','followee');
    }
    public function followedCount(){
        return $this->belongsToMany('tweeterapp\model\User','follow','followee','follower')->count();
    }
}