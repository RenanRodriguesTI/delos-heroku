<?php
    /**
     * Created by PhpStorm.
     * User: allan
     * Date: 18/04/18
     * Time: 11:51
     */

    namespace Delos\Dgp\Validators;

    use Prettus\Validator\Contracts\ValidatorInterface;
    use Prettus\Validator\LaravelValidator;

    /**
     * Class AllocationValidator
     * @package Delos\Dgp\Validators
     */
    class AllocationValidator extends LaravelValidator
    {
        /**
         * @var array
         */
        protected $rules = [
            ValidatorInterface::RULE_CREATE => [
                'project_id'       => 'required|integer|exists:projects,id',
                'user_id'          => 'required|integer|exists:users,id',
                'task_id'          => 'integer|exists:tasks,id',
                'group_company_id' => 'required|integer|exists:group_companies,id',
                'start'            => 'required|date_format:d/m/Y',
                'finish'           => 'required|date_format:d/m/Y',
                'description'      => 'string',
                'hours'            => ''
            ],
            ValidatorInterface::RULE_UPDATE => [
                'project_id'       => 'required|integer|exists:projects,id',
                'user_id'          => 'required|integer|exists:users,id',
                'task_id'          => 'integer|exists:tasks,id',
                'group_company_id' => 'required|integer|exists:group_companies,id',
                'start'            => 'required|date_format:d/m/Y',
                'finish'           => 'required|date_format:d/m/Y',
                'description'      => 'string',
                'hours'            => ''
            ],
        ];
    }