<?php

namespace mywishlist\model;

use \Illuminate\Database\Eloquent\Model;

class Client
    extends Model
    {
        protected $table = 'client';
        protected $primaryKey = 'idClient';
        public $timestamps = false;
        public $incrementing = false;
    }