<?php
if (function_exists('resource')) {
    throw new Error('Resource Already Exist!');
} else {
    /**
     * Create a rest Resource route
     *
     * @param $router
     * @param $path
     * @param $controller
     * @param $name
     * @param array $exclude
     */
    function resource($router, $path, $controller, $name = null, $exclude = [])
    {
        if (!isset($name)) {
            $name = $path;
        }

        /**
         * get method items
         *
         * @param $method
         * @param $name
         * @param $pathExt
         * */
        function g($method, $name, $pathExt = '')
        {
            return ['method' => $method, 'name' => $name, 'pathExt' => $pathExt];
        }

        /**
         * Restful items.
         */
        $restfulMethods = [
            g('get', 'index'),
            g('get', 'show', '/{id:\d+}'),
            g('post', 'store'),
            g('put', 'update', '/{id:\d+}'),
            g('delete', 'destroy', '/{id:\d+}'),
        ];

        foreach ($restfulMethods as $restItem) {
            if (in_array($restItem['name'], $exclude)) {
                continue;
            }
            $router->{$restItem['method']}($path . $restItem['pathExt'], [
                'as' => $name . '.' . $restItem['name'],
                'uses' => $controller . '@' . $restItem['name'],
            ]);
        }
    }
}
