<?php

namespace App;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, HasApiTokens;

    protected $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
        'api_token',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
        'phone_number',
        'remember_token',
        'email_verified_at',
    ];

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class, 'created_by_id', 'id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'updated_by_id', 'id');
    }

    public function quotationRevisions()
    {
        return $this->hasMany(QuotationRevision::class, 'updated_by_id', 'id');
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class, 'user_id', 'id');
    }

    public function saleContracts()
    {
        return $this->hasMany(SaleContract::class, 'created_by_id', 'id');
    }

    public function saleContractPdfs()
    {
        return $this->hasMany(SaleContractPdf::class, 'uploaded_by_id', 'id');
    }

    public function paymentHistories()
    {
        return $this->hasMany(PaymentHistory::class, 'created_by_id', 'id');
    }

    public function equipmentDeliverySchedules()
    {
        return $this->hasMany(EquipmentDeliverySchedule::class, 'created_by_id', 'id');
    }

    public function subCompanies()
    {
        return $this->hasMany(SubCompany::class, 'created_by_id', 'id');
    }

    public function inHouseInstallations()
    {
        return $this->hasMany(InHouseInstallation::class, 'sale_engineer_id', 'id');
    }

    public function installationProgresses()
    {
        return $this->hasMany(InstallationProgress::class, 'created_by_id', 'id');
    }

    public function materialDeliveryProgresses()
    {
        return $this->hasMany(MaterialDeliveryProgress::class, 'created_by_id', 'id');
    }

    public function servicingTeams()
    {
        return $this->hasMany(ServicingTeam::class, 'created_by_id', 'id');
    }

    public function inhouseInstallationTeams()
    {
        return $this->hasMany(InhouseInstallationTeam::class, 'created_by_id', 'id');
    }

    public function onCalls()
    {
        return $this->hasMany(OnCall::class, 'created_by_id', 'id');
    }

    public function servicingSetups()
    {
        return $this->hasMany(ServicingSetup::class, 'created_by_id', 'id');
    }

    public function servicingComplementaries()
    {
        return $this->hasMany(ServicingComplementary::class, 'created_by_id', 'id');
    }

    public function servicingContracts()
    {
        return $this->hasMany(ServicingContract::class, 'created_by_id', 'id');
    }

    public function warrantyClaimActions()
    {
        return $this->hasMany(WarrantyClaimAction::class, 'created_by_id', 'id');
    }

    public function repairTeams()
    {
        return $this->hasMany(RepairTeam::class, 'created_by_id', 'id');
    }

    public function warrantyClaimValidations()
    {
        return $this->hasMany(WarrantyClaimValidation::class, 'created_by_id', 'id');
    }

    public function warrantyClaims()
    {
        return $this->hasMany(WarrantyClaim::class, 'created_by_id', 'id');
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class, 'created_by_id', 'id');
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function remainingJobs()
    {
        return $this->belongsToMany(RemainingJob::class, 'in_charges');
    }

    public function scopeReminderJobsList()
    {
        return $this->roles->flatten()->pluck('reminderTypes.*.remainingJobs')->flatten();
    }
}
