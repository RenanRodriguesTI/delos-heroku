<?php

namespace Delos\Dgp\Entities;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Log
 *
 * @author delos
 */
class AbstractAudit extends Authenticatable implements AuditableContract
{
    use Auditable;
    
    # Specify what actions you want to audit
    protected $auditableTypes = [
        'created', 'updated', 'deleted', 'saved', 'restored'
    ];

    # push group_company_id into array
    public function transformAudit(array $data)
    {
        $data = $this->addNewUserIdIfSourceIsRegisterForm( $data );
        $data = $this->addGroupCompanyId( $data );
        
        return $data;
    }


    public function addNewUserIdIfSourceIsRegisterForm( array $data )
    {
        if( strpos($data['url'], 'auth/register') ) {
            $data['user_id'] = $data['new_values']['id'];
        }

        return $data;
    }

    
    public function addGroupCompanyId( array $data )
    {
        $groupId = null;

        if( isset(\Auth::user()->group_company_id) ) {
            $groupId = \Auth::user()->group_company_id;
        }

        $groupArray = ['group_company_id' => $groupId];
        
        return ($data + $groupArray);
    }
}