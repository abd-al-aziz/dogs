<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consultation extends Model
{
    use HasFactory;

    public function showBadge($status){
        $html = '';
        if($this->status == 0){
            $html = '<span class="badge badge--warning">'.trans('Pending').'</span>';
        }
        elseif($this->status == 1){
            $html = '<span class="badge badge--success">'.trans('Completed').'</span>';
        }else{
            $html = '<span><span class="badge badge--dark">'.trans('Initiated').'</span></span>';
        }
        return $html;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
