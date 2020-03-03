<?php
    /**
     * Created by PhpStorm.
     * User: allan
     * Date: 18/04/18
     * Time: 11:16
     */

    namespace Delos\Dgp\Transformers;

    use Delos\Dgp\Entities\Allocation;
    use League\Fractal\TransformerAbstract;

    /**
     * Class AllocationTransformer
     * @package Delos\Dgp\Transformers
     */
    class AllocationTransformer extends TransformerAbstract
    {
        /**
         * @param Allocation $allocation
         *
         * @return array
         */
        public function transform(Allocation $allocation)
        {
            return [
                'id'            => $allocation->id,
                'compiled_name' => $allocation->compiled_name,
                'project'       => $allocation->project->full_description,
                'user'          => $allocation->user->name,
                'task'          => $allocation->task->name,
                'start'         => $allocation->start->format('Y-m-d'),
                'finish'        => $allocation->finish->format('Y-m-d'),
                'description'   => $allocation->description
            ];
        }
    }