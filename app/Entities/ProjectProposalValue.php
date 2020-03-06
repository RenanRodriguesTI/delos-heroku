<?php

namespace Delos\Dgp\Entities;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;

class ProjectProposalValue extends AbstractAudit
{
    use SoftDeleteWithRestoreTrait, RelationshipsTrait;

    protected $fillable = [
        'project_id',
        'description',
        'month',
        'value',
        'has_billed',
        'invoice_number',
        'notes',
        'os',
        'date_nf',
        'date_received',
        'date_change',
        'nf_nd',
        'expected_date',
        'import_date',
        'created_at',
        'update_at',
        'deleted_at'
    ];

    protected $casts = [
        'project_id' => 'integer',
        'value'      => 'float'
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'update_at',
        'month',
        'date_nf',
        'date_received',
        'date_change',
        'expected_date',
        'import_date'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class)->withTrashed();
    }

    public function setMonthAttribute($value) {
        $month = ($value instanceof \Carbon\Carbon)?$value:Carbon::createFromFormat('d/m/Y', $value);
        $this->attributes['month'] = $month;
    }

    public function setDateNFAttribute($value){
        if($value){
            $datenf = ($value instanceof \Carbon\Carbon)?$value:Carbon::createFromFormat('d/m/Y', $value);
            $this->attributes['date_nf'] = $datenf;
        }
    }

    public function setDateReceivedAttribute($value){
        if($value){
            $datereceived =  ($value instanceof \Carbon\Carbon)?$value:Carbon::createFromFormat('d/m/Y', $value);
            $this->attributes['date_received'] = $datereceived;
        }
        
    }

    public function setDateChangeAttribute($value){
        if($value){

            $datechange =  ($value instanceof \Carbon\Carbon)?$value:Carbon::createFromFormat('d/m/Y', $value);
            $this->attributes['date_change'] = $datechange;
        }
    }

    public function setExpectedDateAttribute($value){
        if($value){
            $expecteddate = ($value instanceof \Carbon\Carbon)?$value:Carbon::createFromFormat('d/m/Y', $value);
            $this->attributes['expected_date'] = $expecteddate;
        }
    }

    public function setImportDateAttribute($value){
        if($value){
            $importdate = ($value instanceof \Carbon\Carbon)?$value:Carbon::createFromFormat('d/m/Y', $value);
            $this->attributes['import_date']  = $importdate;
        }
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class)->withPivot('client_id');
    }
}