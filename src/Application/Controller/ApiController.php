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
     * @param null|string $location
     * @return Response
     */
    protected function created(?string $location = null)
    {
        $response = new Response();
        $response->setStatusCode(Response::HTTP_CREATED);
        if ($location) {
            $response->headers->set('Location', $location);
        }

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

    /**
     * Transform request's json data into associated array.
     *
     * @param string $json Json string
     * @return array
     */
    protected function decodeJsonData(string $json): array
    {
        return json_decode($json, true);
    }
}
