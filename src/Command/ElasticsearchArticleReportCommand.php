<?php

namespace App\Command;

use App\Repository\ReportArticleCommentRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ElasticsearchArticleReportCommand extends Command
{
    protected static $defaultName = 'elasticsearch:article:report';
    private $reportArticleCommentRepository;

    public function __construct(string $name = null, ReportArticleCommentRepository $reportArticleCommentRepository)
    {
        parent::__construct($name);
        $this->reportArticleCommentRepository = $reportArticleCommentRepository;
    }

    protected function configure()
    {
        $this->setDescription('Command to call mysql procedure that generate article report and send it into elasticsearch server');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Starting to generate article report...');

        try {
            $this->reportArticleCommentRepository->callArticleCommentReportProcedure();
            $io->success('Article report has been generated.');
        } catch (\Exception $exception) {
            $io->error('An error has occured while generating article report in database.');
            return 1;
        }

        try {
            $io->text('Sending report as document collection into elasticsearch server.');
            $command = $this->getApplication()->find('fos:elastica:populate');
            $arguments = [
                '--index' => 'article'
            ];
            $greetInput = new ArrayInput($arguments);
            $returnCode = $command->run($greetInput, $output);
            $io->success('Data has been saved on elasticsearch server.');
            return 0;
        } catch (\Exception $exception) {
            $io->error('An error has occured while sending document collection into elasticsearch server');
            return 1;
        }
    }
}
