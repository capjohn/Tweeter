<?php
namespace tweeterapp\model;
class Follow extends \Illuminate\Database\Eloquent\Model {
    protected $table = 'follow';
    protected $primarykey = 'id';
    public $timestamps = false;
}