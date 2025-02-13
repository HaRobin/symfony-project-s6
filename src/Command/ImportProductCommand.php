<?php

namespace App\Command;

use App\Service\ProductService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:product:import',
    description: 'Import products from a CSV file'
)]
class ImportProductCommand extends Command
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('filePath', InputArgument::REQUIRED, 'Path to the CSV file')
            ->addArgument('separator', InputArgument::OPTIONAL, 'CSV separator', ';');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $filePath = $input->getArgument('filePath');
        $separator = $input->getArgument('separator');

        $io->info("Starting CSV import: $filePath");

        try {
            $this->productService->importProducts($filePath, $separator);
            $io->success('Import completed successfully!');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Error during import: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
