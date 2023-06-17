<?php

namespace App\Command;

use App\Entity\NewsCategory;
use App\Repository\NewsCategoryRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:add-categories',
    description: 'Adicionar categorias de notícias',
)]
class AddCategoriesCommand extends Command
{
    public function __construct(private NewsCategoryRepository $newsCategoryRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
                $io = new SymfonyStyle($input, $output);

                $allCategory = $this->newsCategoryRepository->findAll();
                //dump(sizeof($allCategory));

                if(sizeof($allCategory) > 0){
                    $io->warning('As categorias já existiam, não inseri nenhuma!!');
                    exit;

                }

                $newsCategory = new NewsCategory();
                $newsCategory->setTitle('Mundo');
                $this->newsCategoryRepository->save($newsCategory, true);
                $newsCategory = new NewsCategory();
                $newsCategory->setTitle('Brasil');
                $this->newsCategoryRepository->save($newsCategory, true);
                $newsCategory = new NewsCategory();
                $newsCategory->setTitle('Tecnologia');
                $this->newsCategoryRepository->save($newsCategory, true);
                $newsCategory = new NewsCategory();
                $newsCategory->setTitle('Design');
                $this->newsCategoryRepository->save($newsCategory, true);
                $newsCategory = new NewsCategory();
                $newsCategory->setTitle('Cultura');
                $this->newsCategoryRepository->save($newsCategory, true);
                $newsCategory = new NewsCategory();
                $newsCategory->setTitle('Negócios');
                $this->newsCategoryRepository->save($newsCategory, true);
                $newsCategory = new NewsCategory();
                $newsCategory->setTitle('Política');
                $this->newsCategoryRepository->save($newsCategory, true);
                $newsCategory = new NewsCategory();
                $newsCategory->setTitle('Opinião');
                $this->newsCategoryRepository->save($newsCategory, true);
                $newsCategory = new NewsCategory();
                $newsCategory->setTitle('Ciência');
                $this->newsCategoryRepository->save($newsCategory, true);
                $newsCategory = new NewsCategory();
                $newsCategory->setTitle('Saúde');
                $this->newsCategoryRepository->save($newsCategory, true);
                $newsCategory = new NewsCategory();
                $newsCategory->setTitle('Estilo');
                $this->newsCategoryRepository->save($newsCategory, true);
                $newsCategory = new NewsCategory();
                $newsCategory->setTitle('Viagens');
                $this->newsCategoryRepository->save($newsCategory, true);

        $io->success('Categorias criadas com sucesso');

        return Command::SUCCESS;
    }
}
