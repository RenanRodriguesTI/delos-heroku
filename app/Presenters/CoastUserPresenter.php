<?php

    namespace Delos\Dgp\Presenters;

    use Delos\Dgp\Transformers\CoastUserTransformer;
    use Prettus\Repository\Presenter\FractalPresenter;

    /**
     * Class CoastUserPresenter.
     *
     * @package namespace Delos\Dgp\Presenters;
     */
    class CoastUserPresenter extends FractalPresenter
    {
        /**
         * Transformer
         *
         * @return \League\Fractal\TransformerAbstract
         */
        public function getTransformer()
        {
            return new CoastUserTransformer();
        }
    }
