<?php


namespace inisire\RPC\DependencyInjection;


use inisire\DataObject\Runtime\ObjectLoaderInterface;
use inisire\DataObject\Serializer\DataSerializerInterface;
use inisire\RPC\Entrypoint\EntrypointRootInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class RPCExtension extends \Symfony\Component\DependencyInjection\Extension\Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));
        $loader->import('*.yaml');

        $container->registerForAutoconfiguration(EntrypointRootInterface::class)
            ->addTag('rpc.root')
            ->setPublic(true)
        ;

        $container->registerForAutoconfiguration(ObjectLoaderInterface::class)
            ->addTag('data_object.object_reference_loader');
        
        $container->registerForAutoconfiguration(DataSerializerInterface::class)
            ->addTag('rpc.data_serializer');
    }
}