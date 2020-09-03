<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCompany extends Model
{
    use SoftDeletes;

    public $table = 'sub_companies';

    const IS_ACTIVE_RADIO = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'is_active',
        'created_at',
        'updated_at',
        'deleted_at',
        'company_name',
        'created_by_id',
        'updated_by_id',
        'contact_person_name',
        'contact_person_phone_number',
    ];

    public function subComInstallations()
    {
        return $this->belongsToMany(SubComInstallation::class, 'sub_com_connectors', 'sub_com_id', 'sub_com_installation_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function getOverallRatingsAttribute()
    {        
        return $this->getOverallRatings($this->subComInstallations()->whereHas('sale_contract'));  
    }

    public function getOverallRatings($installations)
    {        
        $overall_rating = $installations->get()->map(function($installation) {
            return $installation->rating;
        });
        
        if ($overall_rating->isEmpty()) {
            return 0;
        }
        
        for ( $i=1; $i <= 5; $i++ ) { 
            $data[$i] = $overall_rating->filter(function($rating) use ($i) {
                return $rating == $i;
            })->count();        
        }

        $data = collect($data);

        return $this->calculateRatings($data);
    }

    public function calculateRatings($data)
    {
        $result = (5 * $data[5] + 4 * $data[4] + 3 * $data[3] + 2 * $data[2] + 1 * $data[1]) / ($data[5] + $data[4] + $data[3] + $data[2] + $data[1]);

        return round($result, 1);
    }    
}
