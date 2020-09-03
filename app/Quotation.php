<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ScoutElastic\Searchable;

class Quotation extends Model
{
    use SoftDeletes;
    use Searchable;

    protected $indexConfigurator = QuotationIndexConfigurator::class;

    public $table = 'quotations';

    protected $searchRules = [
        QuotationSearchRule::class
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        'pending'  => 'Pending',
        'possible' => 'Possible',
        'win'      => 'Win',
        'loss'     => 'Loss',
    ];

    protected $fillable = [
        'number',
        'quotation_number',
        'quotation_number_type',
        'year',
        'created_at',
        'updated_at',
        'status',
        'deleted_at',
        'customer_id',
        'enquiries_id',
        'created_by_id',
        'updated_by_id',
        'customer_address',
    ];
    
    protected $mapping = [
        'properties' => [
            'number'                    => [],
            'quotation_number'          => [],
            'quotation_number_type'     => [],
            'year'                      => [],
            'customer_address'          => [],
            'status'                    => [],
        ]
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array['number'] = $this->number;
        $array['customer_address']=$this->customer_address;
        return $array;
    }

    public function saleContract() {
        return $this->morphOne(SaleContract::class, 'morphableEnquiryQuotation', "morphable_type", 'morphable', 'id');
    }

    public function quotationRevisions()
    {
        return $this->hasMany(QuotationRevision::class, 'quotation_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    public function enquiries()
    {
        return $this->belongsTo(Enquiry::class, 'enquiries_id');
    }

    public function enquiry()
    {
        return $this->enquiries()->latest()->first();
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    // public function getNumberAttribute()
    // {
    //     return str_replace('YYYY', $this->year, str_replace('****', $this->quotation_number, $this->quotation_number_type));
    // }    

    public function setNumberAttribute($value)
    {
        return $this->attributes['number'] = $this->quotation_number_type . ' ' . $value . " / " . $this->year;
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', 'win');
    }

    public function scopeSalesEngineer($query, $sales_engineer)
    {
        return $query->whereHas('enquiries', function($q) use ($sales_engineer) {
            $q->whereHas('user', function($q) use ($sales_engineer) {
                $q->where('name', 'like', '%' . $sales_engineer . '%');
            });
        });
    }

    public function getSalesEngineerAttribute()
    {
        return $this->enquiry()->user->name ?? '';
    }
}
