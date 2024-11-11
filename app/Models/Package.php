<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;


    public function statusBadge($status){
        $badge = '';
        if($status == 1){
            $badge = '<span class="badge badge--success">'.trans('Active').'</span>';
        }elseif($status == 2){
            $badge = '<span class="badge badge--success">'.trans('Featured').'</span>';
        }else{
             $badge = '<span class="badge badge--warning">'.trans('In-Active').'</span>';
        }
        return $badge;
    }
}
