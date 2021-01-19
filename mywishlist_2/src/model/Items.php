<?php

namespace mywishlist\model;
use \Illuminate\Database\Eloquent\Model;

class Items
    extends Model
    {

        protected $table = 'item';
        protected $primaryKey = 'id';
        public $timestamps = false;

        public function liste() {return $this->belongsTo('mywishlist\model\Listes','liste_id','no');}
        
        public function reservation()
        {
            return $this->hasMany('\mywishlist\model\Reservation', 'idItem', 'id');
        }
    }