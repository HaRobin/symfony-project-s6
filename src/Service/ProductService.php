<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\HttpFoundation\Response;

class ProductService
{

    private EntityManagerInterface $entityManager;
    private ProductRepository $productRepository;

    public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository)
    {
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
    }

    public function createProduct(Product $product): void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    /**
     * Génère un fichier CSV encodé en UTF-8 avec BOM
     *
     * @param array $products Liste des produits
     * @return Response
     */
    public function exportProductsToCsv(array $products): Response
    {
        $filename = "products_export_" . date("Y-m-d_H-i-s") . ".csv";

        // Ajout du BOM UTF-8 pour éviter les problèmes d'encodage avec Excel
        $csvContent = "\xEF\xBB\xBF";

        // Ajout des en-têtes de colonnes (sans guillemets, avec point-virgule comme séparateur)
        $csvContent .= "name;description;price\n";

        foreach ($products as $product) {
            $csvContent .= sprintf(
                "%s;%s;%.2f\n",
                $this->sanitizeCsvValue($product->getName()),
                $this->sanitizeCsvValue($product->getDescription()),
                $product->getPrice()
            );
        }

        // Création de la réponse HTTP avec le bon type MIME
        $response = new Response($csvContent);
        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }

    /**
     * Nettoie les valeurs pour éviter les problèmes CSV
     */
    private function sanitizeCsvValue(?string $value): string
    {
        if ($value === null) {
            return '';
        }
        return str_replace(["\r", "\n", ";"], ' ', trim($value)); // Supprime les retours à la ligne et remplace ";" pour éviter les conflits
    }

    /**
     * Import products from a CSV file.
     *
     * @param string $filePath  Path to the CSV file
     * @param string $separator CSV separator (default ";")
     * @throws \Exception
     */
    public function importProducts(string $filePath, string $separator = ';'): void
    {
        if (!file_exists($filePath)) {
            throw new \Exception("The CSV file does not exist: " . $filePath);
        }

        // Read the CSV file
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setDelimiter($separator);
        $csv->setHeaderOffset(0); // Set the first row as the header

        $hasNewProduct = false; // Track if we added any new products

        foreach ($csv as $record) {
            // Validate columns
            if (!isset($record['name'], $record['description'], $record['price'])) {
                throw new \Exception('Incorrect columns in CSV file.');
            }

            // Clean and validate data
            $name = trim($record['name']);
            $description = trim($record['description']);
            $price = (float) str_replace(',', '.', $record['price']); // Handle decimal comma

            if (empty($name) || !is_numeric($price)) {
                continue; // Skip invalid rows
            }

            // Check if the product already exists
            $existingProduct = $this->productRepository->findOneBy(['name' => $name]);
            if ($existingProduct) {
                continue; // Skip if product exists
            }

            // Create and persist new product
            $product = new Product();
            $product->setName($name);
            $product->setDescription($description);
            $product->setPrice($price);

            $this->entityManager->persist($product);
            $hasNewProduct = true; // We added a new product
        }

        // Save to database
        if ($hasNewProduct) {
            $this->entityManager->flush(); // Only flush if new products were added
        }
    }
}
