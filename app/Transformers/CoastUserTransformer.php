<?php

    namespace Delos\Dgp\Transformers;

    use League\Fractal\TransformerAbstract;
    use Delos\Dgp\Entities\CoastUser;

    /**
     * Class CoastUserTransformer.
     *
     * @package namespace Delos\Dgp\Transformers;
     */
    class CoastUserTransformer extends TransformerAbstract
    {
        /**
         * Transform the CoastUser entity.
         *
         * @param \Delos\Dgp\Entities\CoastUser $model
         *
         * @return array
         */
        public function transform(CoastUser $model)
        {
            return [
                'id'          => (int)$model->id,

                /* place your other model properties here */
                'user'        => $model->user,
                'month'       => $model->month,
                'description' => $model->description,
                'created_at'  => $model->created_at,
                'updated_at'  => $model->updated_at
            ];
        }
    }
