<?php

namespace App\Application\Service;

use App\Domain\Entity\Product;
use App\Domain\Factory\ProductImageFactory;
use App\Domain\Repository\ProductImageRepositoryInterface;
use Gedmo\Sluggable\Util\Urlizer;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class ProductImageService
 * @package App\Application\Service
 */
class ProductImageService
{
    /**
     * Folder name for uploads.
     *
     * @var string
     */
    const PRODUCT_IMAGE = 'product_images';

    /**
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * @var RequestStackContext
     */
    private $requestStackContext;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $publicAssetBaseUrl;

    /**
     * @var ProductImageRepositoryInterface
     */
    private $repository;

    /**
     * @var ProductImageFactory
     */
    private $productImageFactory;

    /**
     * ProductImageService constructor.
     * @param ProductImageRepositoryInterface $repository
     * @param ProductImageFactory $productImageFactory
     * @param FilesystemInterface $publicUploadsFilesystem
     * @param RequestStackContext $requestStackContext
     * @param LoggerInterface $logger
     */
    public function __construct(
        ProductImageRepositoryInterface $repository,
        ProductImageFactory $productImageFactory,
        FilesystemInterface $publicUploadsFilesystem,
        RequestStackContext $requestStackContext,
        LoggerInterface $logger
    )
    {
        $this->filesystem = $publicUploadsFilesystem;
        $this->requestStackContext = $requestStackContext;
        $this->logger = $logger;
        $this->publicAssetBaseUrl = '/public/uploads/';
        $this->repository = $repository;
        $this->productImageFactory = $productImageFactory;
    }

    /**
     * @param string $decodedData
     * @return File
     */
    public function prepareFileUpload(string $decodedData)
    {
        $tmpPath = sys_get_temp_dir() . '/sf-upload' . uniqid();
        file_put_contents($tmpPath, $decodedData);

        return new File($tmpPath);
    }

    /**
     * @param File $file
     * @param Product $product
     * @param null|string $existingFilename
     * @return void
     * @throws \Exception
     */
    public function uploadProductImage(File $file, Product $product, ?string $existingFilename = null): void
    {
        $originalFilename = $file->getFilename();

        $newFilename = Urlizer::urlize(pathinfo($originalFilename, PATHINFO_FILENAME)) . '.' . $file->guessExtension();
        $stream = fopen($file->getPathname(), 'r');

        try {
            $this->filesystem->writeStream(
                self::PRODUCT_IMAGE . '/' . $newFilename,
                $stream
            );
        } catch (\Exception $e) {
            throw new \Exception(sprintf('Could not write uploaded file "%s"', $newFilename));
        }

        if (is_resource($stream)) {
            fclose($stream);
        }

        if ($existingFilename) {
            try {
                $this->filesystem->delete(self::PRODUCT_IMAGE . '/' . $existingFilename);
            } catch (FileNotFoundException $e) {
                $this->logger->alert(sprintf('Old uploaded file "%s" was missing when trying to delete', $existingFilename));
            }
        }

        $this->saveUploadedImage($product, $file, $originalFilename);
    }

    /**
     * @param string $path
     * @return string
     */
    public function getPublicPath(string $path): string
    {
        return $this->requestStackContext
                ->getBasePath() . $this->publicAssetBaseUrl . '/' . $path;
    }

    /**
     * @param Product $product
     * @param File $file
     * @param string $originalFilename
     */
    public function saveUploadedImage(Product $product, File $file, string $originalFilename)
    {
        $productImage = $this->productImageFactory->createProductImage($product, $file, $originalFilename);

        $this->repository->save($productImage);
    }
}
