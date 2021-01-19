<?php

namespace mywishlist\model;
use \Illuminate\Database\Eloquent\Model;

class Listes
    extends Model
    {

        /* Parametres de la table */
        protected $table = 'liste';
        protected $primaryKey = 'no';
        public $timestamps = false;
        public function items()
        {
            return $this->hasMany('\mywishlist\model\Items', 'liste_id', 'no');
        }

        public function messages()
        {
            return $this->hasMany('\mywishlist\model\MessageListe', 'idListe', 'no');
        }
        
    }