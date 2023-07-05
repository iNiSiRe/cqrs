<?php

namespace inisire\RPC\Entrypoint;

use inisire\RPC\Context\CallContext;
use inisire\RPC\Error\AccessDenied;
use inisire\RPC\Error\Unauthorized;
use inisire\RPC\Error\ValidationError;
use inisire\RPC\Result\Result;
use inisire\RPC\Result\ResultInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Runner
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly Security           $security,
    )
    {
    }

    public function run(Entrypoint $entrypoint, mixed $parameter, ?CallContext $context): ResultInterface
    {
        if ($this->validator && $entrypoint->getInputSchema() !== null) {
            $violations = $this->validator->validate($parameter);
            if ($violations->count() > 0) {
                return ValidationError::createByViolations($violations);
            }
        }

        if ($entrypoint->getAuthorization()) {
            if (!$this->security) {
                throw new \RuntimeException('Security not exists');
            } elseif ($this->security->getUser() === null) {
                return new Unauthorized();
            } elseif ($this->security->isGranted($entrypoint->getAuthorization()->getRole()) === false) {
                return new AccessDenied();
            }
        }

        $arguments = [];
        foreach ([$parameter, $context] as $argument) {
            if ($argument === null) {
                continue;
            }
            $arguments[] = $argument;
        }

        $result = call_user_func_array($entrypoint->getCallable(), $arguments);

        if (!$result instanceof ResultInterface) {
            $result = new Result($result);
        }

        return $result;
    }
}