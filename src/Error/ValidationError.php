<?php

namespace inisire\RPC\Error;

use inisire\DataObject\Error\Error;
use inisire\DataObject\Error\ErrorMessage;
use inisire\DataObject\Error\PropertyError;
use inisire\RPC\Http\HttpResultInterface;
use inisire\RPC\Result\ResultInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ValidationError implements ErrorInterface, ResultInterface, HttpResultInterface
{
    /**
     * @var PropertyError[]
     */
    private array $errors;

    /**
     * @param array<PropertyError> $errors
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }

    public function getCode(): string
    {
        return '1ec03458-6c52-6b02-aa2b-89e62bbf88ef';
    }

    public function getMessage(): ErrorMessage
    {
        return new ErrorMessage('Validation error');
    }

    /**
     * @return PropertyError[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array<ConstraintViolationInterface> $violations
     */
    public static function createByViolations(iterable $violations): self
    {
        $errors = [];
        foreach ($violations as $violation) {
            $errors[] = new PropertyError(
                $violation->getPropertyPath(),
                [new Error(new ErrorMessage($violation->getMessage()), $violation->getCode())]
            );
        }

        return new self($errors);
    }

    public function getHttpHeaders(): array
    {
        return [];
    }

    public function getHttpCode(): int
    {
        return 400;
    }

    public function getOutput(): mixed
    {
        return null;
    }
}