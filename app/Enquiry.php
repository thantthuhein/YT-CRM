<?php

namespace App;

use Carbon\Carbon;
use ScoutElastic\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enquiry extends Model
{
    use SoftDeletes;
    use Searchable;
    protected $indexConfigurator = EnquiryIndexConfigurator::class;

    public $table = 'enquiries';
    protected $searchRules = [
        EnquirySearchRule::class
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const HAS_FUTURE_ACTION_SELECT = [
        'Yes' => 'Yes',
        'No'  => 'No',
    ];

    const HAS_INSTALLATION_SELECT = [
        'Yes' => 'Yes',
        'No'  => 'No',
        'TBA' => 'TBA',
    ];

    const STATUS_SELECT = [
        'active'   => 'Active',
        'inactive' => 'InActive',
        'pending'  => 'Pending',
    ];

    protected $fillable = [
        'status',
        'sale_engineer_id',
        'location',
        'company_id',
        'project_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'customer_id',
        'created_by_id',
        'updated_by_id',
        'receiver_name',
        'type_of_sales_id',
        'has_installation',
        'enquiries_type_id',
        'has_future_action',
    ];
    protected $mapping = [
        'properties' => [
            'location' => [],
            'receiver_name' => [],
            'status'=>[],
            'company'=>[],
            'project'=>[],
            'customer' => []
            // 'address' => [
            //     'type' => 'string',
            //     'analyzer' => 'english'
            // ]
        ]
    ];
    public function toSearchableArray()
    {
        $array = $this->toArray();
        $array['location'] = $this->location;
        $array['receiver']=$this->receiver_name;
        $array['status']=$this->status;
        $array['project'] = $this->project->name ?? null;
        $array['company'] = $this->company->name ?? null;
        $array['customer']=$this->customer->name ?? null;
        $array['quotation']=$this->quotations->first()->number ?? null;
        return $array;
        // return array_merge(
        //     // By default all model fields will be indexed
        //     parent::toSearchableArray(),
        //     ['name' => $this->name]
        // );
    }

    // public function airconTypeConnectors()
    // {
        // return $this->hasMany(AirconTypeConnector::class, 'enquiries_id', 'id');
    // }
    public function getCustomerNameAttribute() {
        return Customer::where('id',$this->customer_id)->first()->name ?? '';
    }
    public function saleContract() {
        return $this->morphOne(SaleContract::class, 'morphableEnquiryQuotation', "morphable_type", 'morphable', 'id');
    }

    public function airconTypes(){
        return $this->belongsToMany(AirconType::class,'aircon_type_connectors', "enquiries_id", 'aircon_type_id');
    }

    public function getairconTypeIdsAttribute(){
        return $this->airconTypes()->pluck('aircon_types.id')->toArray();
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'enquiries_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sale_engineer_id');
    }

    public function enquiries_type()
    {
        return $this->belongsTo(EnquiriesType::class, 'enquiries_type_id');
    }

    public function type_of_sales()
    {
        return $this->belongsTo(TypeOfSale::class, 'type_of_sales_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function isExistedToday($customer_id)
    { 
        $enquiries = Enquiry::where('customer_id', $customer_id)->get();

        $enquiries = $enquiries->filter(function($enquiry) {
            return $enquiry->created_at->diffInDays(Carbon::now()) <= 1;
        });
        
        if (count($enquiries) > 1) {
            return true;
        } else {
            return false;
        }
    }

    public function scopeSuccess($query)
    {
        return $query->where('status', 'active');
    }
}
