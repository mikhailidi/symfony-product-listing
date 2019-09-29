<?php

namespace App\Application\Controller\Api;

use App\Application\Controller\ApiController;
use App\Application\Service\ProductApplicationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ProductController
 * @package App\Application\Controller\Api
 */
class ProductController extends ApiController
{
    /**
     * @var ProductApplicationService
     */
    private $applicationService;

    /**
     * ProductController constructor.
     * @param ProductApplicationService $applicationService
     */
    public function __construct(ProductApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    /**
     * @Route("/api/products", methods={"POST"}, name="api.article.create")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $this->validateProductCreationRequest($request->request->all());

        $this->applicationService->createProduct($request->request->all());

        return $this->created();
    }

    /**
     * Request validation for product creation.
     *
     * @param array $data Request data
     * @return void
     */
    private function validateProductCreationRequest(array $data)
    {
        $validator = $this->createValidator();

        $groups = new Assert\GroupSequence(['Default', 'custom']);

        $validationRules = new Assert\Collection([
            'name' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string']),
            ],
            'description' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string']),
            ],
        ]);

        $validations = $validator->validate($data, $validationRules, $groups);

        $this->handleValidationErrors($validations);
    }
}
