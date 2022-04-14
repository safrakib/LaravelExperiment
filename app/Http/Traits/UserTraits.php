<?php 

namespace App\Http\Traits;
use Illuminate\Support\Facades\DB;

trait UserTraits {
    public function getAllUser(){
        return DB::table('users')->get();
    }
}



?>