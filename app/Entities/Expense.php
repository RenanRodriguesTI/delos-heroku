<?php

namespace Delos\Dgp\Entities;

use Carbon\Carbon;
use Delos\Dgp\Repositories\Criterias\MultiTenant\RelationshipsTrait;
use Illuminate\Support\Facades\Storage;

class Expense extends AbstractAudit
{
    use RelationshipsTrait;
    use SoftDeleteWithRestoreTrait;

    protected $fillable = [
        'user_id',
        'invoice',
        'issue_date',
        'value',
        'payment_type_id',
        'description',
        'note',
        'original_name',
        'link',
        's3_name',
        'exported',
        'request_id',
        'project_id',
        'debit_memo_id'
    ];

    protected $casts = [
        'issue_date' => 'datetime',
        'exported' => 'boolean',
        'value' => 'float'
    ];

    public function request()
    {
        return $this->belongsTo(Request::class)->withTrashed();
    }

    public function project()
    {
        return $this->belongsTo(Project::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function debitMemo()
    {
        return $this->belongsTo(DebitMemo::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function setNoteAttribute($value)
    {
        if(!empty($value)) {
            $this->attributes['note'] = $value;
        }
    }

    public function setValueAttribute($value)
    {
        $numberFormatter = new \NumberFormatter('pt-BR', \NumberFormatter::DECIMAL);
        $float = $numberFormatter->parse($value);
        $this->attributes['value'] = $float;
    }

    public function getValueAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getUrlFileAttribute()
    {
        return env('FILESYSTEM_DISK') == 's3' ? Storage::url('images/invoices/' . session('groupCompanies')[0] . '/' . $this->project_id. '/' . $this->user->id . '/' . $this->s3_name) : asset('images/invoices/' . session('groupCompanies')[0] . '/' . $this->request->project->id. '/' . $this->user->id . '/' . $this->s3_name);
    }

    public function getCompiledInvoiceAttribute()
    {
        return mb_split('-', $this->attributes['invoice'])[0];
    }

    public function setIssueDateAttribute($value)
    {
        $value = Carbon::createFromFormat('d/m/Y', $value);
        $this->attributes['issue_date'] = $value->format('Y-m-d');
    }

    public function getStatusAttribute()
    {
        return $this->exported ? 'exported' : 'non-exported';
    }
}
