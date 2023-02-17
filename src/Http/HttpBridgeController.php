<?php


namespace inisire\RPC\Http;


use inisire\DataObject\DataObjectWizard;
use inisire\RPC\Entrypoint\EntrypointRegistry;
use inisire\RPC\Error\AccessDenied;
use inisire\RPC\Error\DebugServerError;
use inisire\RPC\Error\ErrorInterface;
use inisire\RPC\Error\NotFound;
use inisire\RPC\Error\ServerError;
use inisire\RPC\Error\ValidationError;
use inisire\RPC\Http\Context\RequestContext;
use inisire\RPC\Result\MutableOutputInterface;
use inisire\RPC\Result\Result;
use inisire\RPC\Result\ResultInterface;
use inisire\RPC\Security\Authorization;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class HttpBridgeController extends AbstractController
{
    public function __construct(
        private HttpBridge               $httpBridge,
        private DataObjectWizard         $wizard,
        private EntrypointRegistry       $entrypointRegistry,
        private ParameterBagInterface    $parameters,
        private EventDispatcherInterface $dispatcher,
        private HttpKernelInterface      $kernel
    )
    {
    }

    #[Route(
        path: '/{name}',
        methods: ['GET', 'POST']
    )]
    public function __invoke(Request $request, string $name)
    {
        $result = $this->execute($name, $request);

        return $this->httpBridge->createResponse($result);
    }

    private function execute(string $name, Request $request): ResultInterface
    {
        $entrypoint = $this->entrypointRegistry->getEntrypoint($name);

        if (!$entrypoint) {
            return new NotFound();
        }

        $parameter = null;
        if ($entrypoint->getInputSchema()) {
            $requestData = $this->httpBridge->extractRequestData($request);

            $errors = [];
            $parameter = $this->wizard->map($entrypoint->getInputSchema(), $requestData, $errors);

            if (!empty($errors)) {
                return new ValidationError($errors);
            }
        }

        try {
            $result = $entrypoint->execute($parameter, new RequestContext($request, $this->getUser()));
        } catch (\Exception|\Error $error) {
            $event = new ExceptionEvent($this->kernel, $request, HttpKernel::MAIN_REQUEST, $error);
            $this->dispatcher->dispatch($event, KernelEvents::EXCEPTION);

            if ($this->parameters->get('kernel.debug') === true) {
                $result = new DebugServerError($error);
            } else {
                $result = new ServerError($error);
            }
        }

        if ($result->getOutput() === null || $result instanceof ErrorInterface) {
            return $result;
        }

        if ($entrypoint->getOutputSchema() && $result->getOutput() instanceof MutableOutputInterface) {
            $output = $this->wizard->transform($entrypoint->getOutputSchema(), $result->getOutput());
            $result->setOutput($output);
        }

        return $result;
    }
}