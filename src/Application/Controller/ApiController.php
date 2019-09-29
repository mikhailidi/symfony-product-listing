<?php

namespace App\Application\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class ApiController
 * @package App\Application\Controller
 */
class ApiController
{
    /**
     * @return Response
     */
    protected function created()
    {
        $response = new Response();
        $response->setStatusCode(Response::HTTP_CREATED);

        return $response;
    }

    /**
     * @return ValidatorInterface
     */
    protected function createValidator(): ValidatorInterface
    {
        return Validation::createValidator();
    }

    /**
     * Build error response WHATEVER
     *
     * @param ConstraintViolationListInterface $validations
     * @return void
     * @throws BadRequestHttpException
     */
    protected function handleValidationErrors(ConstraintViolationListInterface $validations): void
    {
        $errors = [];
        foreach ($validations as /** @var ConstraintViolation $validation */ $validation) {
            $errors['errors'][$validation->getPropertyPath()][] = $validation->getMessage();
        }

        if (count($errors)) {
            throw new BadRequestHttpException(json_encode($errors));
        }
    }
}
