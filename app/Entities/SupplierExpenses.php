<?php

namespace Delos\Dgp\Entities;

use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class SupplierExpenses extends AbstractAudit
{
    use SoftDeleteWithRestoreTrait, RelationshipsTrait;
    // 'original_name',
    //     'link',
    //     's3_name',


    protected $fillable =[
       'provider_id',
       'invoice',
       'issue_date',
       'value',
       'payment_type_provider_id',
       'description_id',
       'key_description',
       'note',
       'provider_id',
       'establishment_id',
       'voucher_type_id',
       'exported',
       'project_id',
       'debit_memo_id',
       'original_name',
       's3_name',
       'import',
       'voucher_number'
    ];

    protected $casts =[
        'issue_date' =>'datetime',
        'exported' => 'boolean',
        'value' => 'float',
        'import' =>'boolean'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class)->withTrashed();
    }

    public function paymentTypeProvider()
    {
        return $this->belongsTo(PaymentTypeProviders::class,'payment_type_provider_id');
    }

    public function voucherType(){
        return $this->belongsTo(VoucherType::class);
    }

    public function provider(){
        return $this->belongsTo(Provider::class)->withTrashed();
    }

    public function debit(){
        return $this->belongsTo(DebitMemo::class,'debit_memo_id');
    }

    public function setIssueDateAttribute($value)
    {
        $value = Carbon::createFromFormat('d/m/Y', $value);
        $this->attributes['issue_date'] = $value->format('Y-m-d');
    }

    public function setValueAttribute($value)
    {
        $numberFormatter = new \NumberFormatter('pt-BR', \NumberFormatter::DECIMAL);
        $float = $numberFormatter->parse($value);
        $this->attributes['value'] = $float;
    }

    public function getUrlFileAttribute()
    {
        if( $this->attributes['s3_name'] =='https://delos-project-dgp.s3-sa-east-1.amazonaws.com/images/Despesa+Importada.jpeg'){
            return $this->attributes['s3_name'];
        }
        return env('FILESYSTEM_DISK') == 's3' ? Storage::url('images/invoices-providers/' . $this->s3_name) : asset('images/invoices-providers/' . $this->s3_name);
    }

    public function getValueAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    
    public function getVoucherNumberCompiledAttribute(){
        if($this->attributes['voucher_number']){
            
            $vouchernumber = $this->voucherType->name == 'E-mail' ? 'EMAIL' : mb_split('-',$this->attributes['voucher_number'])[0];
            return $vouchernumber;
        }

        return null;
    }


    
}
