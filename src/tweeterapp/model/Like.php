<?php
namespace tweeterapp\model;
class Like extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'like';
    protected $primarykey = 'id';
    public $timestamps = false;
}