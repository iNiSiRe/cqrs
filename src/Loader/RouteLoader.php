<?php


namespace inisire\RPC\Loader;


use Doctrine\Common\Annotations\AnnotationReader;
use inisire\RPC\Annotation\RPC;
use inisire\RPC\Controller\BusBridgeController;
use Symfony\Bundle\FrameworkBundle\Routing\RouteLoaderInterface;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteLoader extends Loader implements RouteLoaderInterface
{
    private ServiceLocator $container;
    private AnnotationReader $annotationReader;

    public function __construct(ServiceLocator $container, string $env = null)
    {
        parent::__construct($env);
        $this->container = $container;
        $this->annotationReader = new AnnotationReader();
    }

    public function __invoke()
    {
        return new RouteCollection();
    }

    public function load($resource, string $type = null): mixed
    {
        $collection = new RouteCollection();

        foreach ($this->container->getProvidedServices() as $id) {
            if (!$this->container->has($id)) {
                continue;
            }

            $instance = $this->container->get($id);

            $reflection = new \ReflectionClass($instance);

            $annotations = [];
            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $methods) {
                foreach ($this->annotationReader->getMethodAnnotations($methods) as $annotation) {
                    if ($annotation instanceof RPC) {
                        $annotations[] = $annotation;
                    }
                }
            }

            foreach ($annotations as $annotation) {
                if ($annotation instanceof RPC) {
                    $name = $annotation->name ?? $annotation->path;
                    $defaults = [
                        '_controller' => BusBridgeController::class,
                        '_schema'     => serialize($annotation)
                    ];
                    $methods = $annotation->methods;
                } else {
                    continue;
                }

                $collection->add($name, new Route($annotation->path, $defaults, [], [], null, [], $methods));
            }
        }

        return $collection;
    }

    public function supports($resource, string $type = null): bool
    {
        return $type === 'rpc';
    }
}