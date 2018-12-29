<?php

namespace Kernel;

use Kernel\AWA_Interface\EventManagerInterface;
use Kernel\AWA_Interface\ModuleInterface;
use Kernel\Container\Factory_Container;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use const DS;
use const ROOT;
use function class_exists;
use function dirname;
use function get_class;
use function is_a;
use function is_array;
use function is_string;
use function str_replace;

abstract class Kernel
{

    protected $container;
    protected $despatcher;
    protected $router;
    protected $renderer;
    protected $modules = [];


    /**
     * phinix config
     * @var array string
     */
    protected $pathModules = [];

    protected function __construct(string $pathconfig)
    {

        $container = Factory_Container::getContainer($pathconfig);
        $this->container = $container;
        $this->despatcher = $container->get(RequestHandlerInterface::class);
        $this->router = $container->get(RouterInterface::class);
        $this->renderer = $container->get(RendererInterface::class);
    }

    function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function getModules(): array
    {
        return $this->modules;
    }

    /**
     * path model save
     * phinix ==>migrate
     * @return array string
     */
    public function getPathModules(): array
    {

        return $this->pathModules;
    }

    public function addModule($module, array $middlewares = [])
    {


        if (is_string($module) && class_exists($module)) {
            $module = new $module($this->container);
        }

        if (is_a($module, ModuleInterface::class)) {
            $module->addMiddlewares($middlewares);
            $this->modules[] = $module;

            // phinix config
            $this->pathModules[] = dirname(ROOT . str_replace("\\", DS, get_class($module)));
        }
    }

    function addMiddleware($Middlewares)
    {
        if (is_a($Middlewares, MiddlewareInterface::class)) {
            $this->despatcher->pipe($Middlewares);
        } elseif (is_array($Middlewares)) {
            foreach ($Middlewares as $Middleware) {
                $this->addMiddleware($Middleware);
            }
        }
    }

    function addEvent(string $event, callable $callback, int $priority = 0)
    {
        $eventManager = $this->container->get(EventManagerInterface::class);

        $eventManager->attach($event, $callback, $priority);
    }

    public function run(ServerRequestInterface $request)
    {

        //  $this->run_modules();
        $response = $this->despatcher->handle($request);
        return $response;
    }

    abstract public function run_modules();
}
