<?php
/**
 * Created by PhpStorm.
 * User: ziv
 * Date: 2018/7/23
 * Time: 15:18
 */
namespace Providers;

use Controller\ApiController;
use Controller\TestController;
use Controller\UserController;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\Collection;

class RouterProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di)
    {
        /** @var Micro $application */
        $application   = $di->getShared('application');
        /** @var Manager $eventsManager */
        $eventsManager = $di->getShared('eventsManager');

        $this->attachRoutes($application);
        $this->attachMiddleware($application, $eventsManager);

        $application->setEventsManager($eventsManager);
    }

    /**
     * Attaches the middleware to the application
     *
     * @param Micro   $application
     * @param Manager $eventsManager
     */
    private function attachMiddleware(Micro $application, Manager $eventsManager)
    {
        $middleware = $this->getMiddleware();

        /**
         * Get the events manager and attach the middleware to it
         */
        foreach ($middleware as $class => $function) {
            $eventsManager->attach('micro', new $class());
            $application->{$function}(new $class());
        }
    }

    /**
     * Returns the array for the middleware with the action to attach
     *
     * @return array
     */
    private function getMiddleware(): array
    {
        return [
        ];
    }

    /**
     * Attaches the routes to the application; lazy loaded
     *
     * @param Micro $application
     */
    private function attachRoutes(Micro $application)
    {
        $routes = $this->getRoutes();
        foreach ($routes as $route) {
            $collection = new Collection();
            $collection
                ->setHandler($route[0], true)
                ->setPrefix($route[1])
                ->{$route[2]}($route[3], $route[4]);
            $application->mount($collection);
        }
    }

    /**
     * Returns the array for the routes
     *
     * @return array
     */
    private function getRoutes(): array
    {
        /**
         * Class, prefix, Route, path, method
         */
        return array(
            array(TestController::class, '/test/test1',  'get', '', 'test1Action'),

            array(UserController::class, '/user/login',  'get', '/{mobile}', 'login'),
            array(UserController::class, '/user/geteatstatus',  'get', '/{mobile}', 'getEatStatus'),

            array(DiningController::class, '/dining/apply',  'post', '', 'applyAction'),
            array(DiningController::class, '/dining/info',  'get', '{uid}', 'infoAction'),
            array(DiningController::class, '/dining/deal',  'get', '{uid}/{dining_table_id}', 'dealAction'),

        );
    }
}