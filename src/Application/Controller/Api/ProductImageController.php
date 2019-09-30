<?php

namespace App\Application\Controller\Api;

use App\Application\Controller\ApiController;
use App\Application\Service\ProductImageService;
use App\Domain\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ProductImageController
 * @package App\Application\Controller\Api
 */
class ProductImageController extends ApiController
{
    /**
     * @var ProductImageService
     */
    private $service;

    /**
     * ProductImageController constructor.
     * @param ProductImageService $service
     */
    public function __construct(ProductImageService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/api/products/{id}/images", methods={"POST"}, name="api.product.upload_image")
     * @param Product $product
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function upload(Product $product, Request $request)
    {
        $data = $this->decodeJsonData($request->getContent());
        $this->validateUploadedImage($data);

        $temporaryFile = $this->service->prepareFileUpload(base64_decode($data['image']));

        $this->service->uploadProductImage($temporaryFile, $product);

        return $this->created();
    }

    /**
     * @param array $data
     * @return void
     */
    private function validateUploadedImage($data): void
    {
        $validator = $this->createValidator();

        $groups = new Assert\GroupSequence(['Default', 'custom']);

        $validationRules = new Assert\Collection([
            'image' => [
                new Assert\NotBlank(),
                new Assert\Type(['type' => 'string']),
            ],
        ]);

        $validations = $validator->validate($data, $validationRules, $groups);

        $this->handleValidationErrors($validations);
    }
}