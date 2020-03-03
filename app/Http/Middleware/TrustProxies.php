<?php
    /**
     * Created by PhpStorm.
     * User: allan
     * Date: 28/09/18
     * Time: 15:40
     */

    namespace Delos\Dgp\Http\Middleware;
    use Illuminate\Http\Request;
    use Fideloper\Proxy\TrustProxies as Middleware;

    class TrustProxies extends Middleware
    {
        /**
         * The trusted proxies for this application.
         *
         * @var array
         */
        protected $proxies;

        /**
         * The headers that should be used to detect proxies.
         *
         * @var int
         */
        protected $headers = Request::HEADER_X_FORWARDED_ALL;
    }