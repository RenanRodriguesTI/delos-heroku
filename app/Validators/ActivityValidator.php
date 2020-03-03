<?php

    namespace Delos\Dgp\Validators;

    use Prettus\Validator\Contracts\ValidatorInterface;
    use Prettus\Validator\LaravelValidator;

    class ActivityValidator extends LaravelValidator
    {
        protected $rules = [
            ValidatorInterface::RULE_CREATE => [
                'project_id' => 'required|integer|exists:projects,id',
                'user_id.*' => 'required|integer|exists:users,id',
                'start_date' => 'required|date_format:d/m/Y',
                'finish_date' => 'required|date_format:d/m/Y|before:tomorrow|after_or_equal:start_date',
                'hours' => 'required|integer|min:1|max:24',
                'task_id' => 'required|integer|exists:tasks,id',
                'place_id' => 'required|integer|exists:places,id',
                'note' => 'min:2|max:255',
            ],
            ValidatorInterface::RULE_UPDATE => [
                'project_id' => 'required|integer|exists:projects,id',
                'user_id.*' => 'required|integer|exists:users,id',
                'start_date' => 'required|date_format:d/m/Y',
                'finish_date' => 'required|date_format:d/m/Y|before:tomorrow|after_or_equal:start_date',
                'hours' => 'required|integer|min:1|max:24',
                'task_id' => 'required|integer|exists:tasks,id',
                'place_id' => 'required|integer|exists:places,id',
                'note' => 'min:2|max:255',
            ],
        ];
    }
