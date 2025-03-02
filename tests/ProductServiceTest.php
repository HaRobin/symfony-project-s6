<?php

namespace App\Tests\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductServiceTest extends TestCase
{
    /** @var MockObject&EntityManagerInterface */
    private MockObject|EntityManagerInterface $entityManager;
    /** @var MockObject&ProductRepository */
    private MockObject|ProductRepository $productRepository;
    private ProductService $productService;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->productService = new ProductService($this->entityManager, $this->productRepository);
    }

    public function testExportProductsToCsv()
    {
        $product1 = new Product();
        $product1->setName("Product 1");
        $product1->setDescription("Description 1");
        $product1->setPrice(10.5);

        $product2 = new Product();
        $product2->setName("Product 2");
        $product2->setDescription("Description 2");
        $product2->setPrice(20.0);

        $products = [$product1, $product2];

        $response = $this->productService->exportProductsToCsv($products);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('text/csv; charset=UTF-8', $response->headers->get('Content-Type'));
        $this->assertStringContainsString("Product 1", $response->getContent());
        $this->assertStringContainsString("Product 2", $response->getContent());
        $this->assertStringContainsString("\xEF\xBB\xBF", $response->getContent()); // Check UTF-8 BOM
    }

    public function testImportProducts()
    {
        $csvData = "name;description;price\nProduct A;Desc A;12.5\nProduct B;Desc B;15.0";

        $csvFilePath = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($csvFilePath, $csvData);

        $this->productRepository
            ->method('findOneBy')
            ->willReturn(null); // Simulate that no products exist already

        $this->entityManager
            ->expects($this->exactly(2))
            ->method('persist')
            ->with($this->isInstanceOf(Product::class));

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $this->productService->importProducts($csvFilePath);

        unlink($csvFilePath); // Clean up
    }

    public function testImportProductsWithMissingFile()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("The CSV file does not exist");

        $this->productService->importProducts('/invalid/path.csv');
    }

    public function testImportProductsWithInvalidColumns()
    {
        $csvData = "wrongColumn;price\nProduct A;12.5";

        $csvFilePath = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($csvFilePath, $csvData);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Incorrect columns in CSV file");

        $this->productService->importProducts($csvFilePath);

        unlink($csvFilePath);
    }

    public function testImportProductsSkipsExistingProduct()
    {
        $csvData = "name;description;price\nExisting Product;Some Desc;9.99";

        $csvFilePath = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($csvFilePath, $csvData);

        $existingProduct = new Product();
        $existingProduct->setName("Existing Product");

        $this->productRepository
            ->method('findOneBy')
            ->willReturn($existingProduct); // Simulate existing product

        $this->entityManager
            ->expects($this->never())
            ->method('persist'); // Should not persist because product already exists

        $this->entityManager
            ->expects($this->never())
            ->method('flush'); // Should not flush changes

        $this->productService->importProducts($csvFilePath);

        unlink($csvFilePath);
    }
}
