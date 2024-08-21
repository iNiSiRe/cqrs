<?php

namespace inisire\RPC\Routing;

use inisire\RPC\Http\HttpBridgeController;
use Symfony\Bundle\FrameworkBundle\Routing\RouteLoaderInterface;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteLoader extends Loader implements RouteLoaderInterface
{
    public function __construct(
        string $env = null
    )
    {
        if (method_exists(Loader::class, '__construct')) {
            parent::__construct($env);
        }
    }

    public function __invoke()
    {
        return new RouteCollection();
    }

    public function load($resource, $type = null)
    {
        $collection = new RouteCollection();

        $defaults = [
            '_controller' => HttpBridgeController::class,
        ];

        $collection->add('rpc.root', new Route('/{name}', $defaults, [], [], null, [], ['GET', 'POST']));

        return $collection;
    }

    public function supports($resource, $type = null)
    {
        return $type === 'rpc';
    }
}
