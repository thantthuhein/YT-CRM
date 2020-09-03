<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class CompletingRemainingJobService {

    // protected $model;

    // public function __construct($model)
    // {
    //     $this->model = $model;
    // }

    public function __invoke($model){
        $model->completed_at = date('Y-m-d', time());
        $model->completed_by_id = Auth::user()->id;
        $model->deleted_at = now();
        $model->save();
    }

}