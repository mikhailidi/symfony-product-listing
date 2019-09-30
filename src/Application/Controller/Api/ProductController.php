<?php

namespace App\Application\Controller\Api;

use App\Application\Controller\ApiController;
use App\Application\Service\ProductApplicationService;
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
     * @Route("/api/products", methods={"POST"}, name="api.product.create")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function create(Request $request)
    {
        $requestData = $this->decodeJsonData($request->getContent());
        $this->validateProductCreationRequest($requestData);

        $product = $this->applicationService->createProduct($requestData);


        return $this->created('/api/products/' . $product->getId());
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
            'description' => new Assert\Optional([
                new Assert\Optional(),
                new Assert\Type(['type' => 'string']),
            ]),
            'tags' => [
                new Assert\Type('array'),
                new Assert\Count(['min' => 1]),
            ],
        ]);

        $validations = $validator->validate($data, $validationRules, $groups);

        $this->handleValidationErrors($validations);
    }
}
