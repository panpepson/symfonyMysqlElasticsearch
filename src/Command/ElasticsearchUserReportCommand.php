<?php

namespace App\Command;

use App\Repository\ReportUserCommentRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ElasticsearchUserReportCommand extends Command
{
    protected static $defaultName = 'elasticsearch:user:report';
    private $reportUserCommentRepository;

    public function __construct(string $name = null, ReportUserCommentRepository $reportUserCommentRepository)
    {
        parent::__construct($name);
        $this->reportUserCommentRepository = $reportUserCommentRepository;
    }

    protected function configure()
    {
        $this->setDescription('Command to call mysql procedure that generate user report and send it into elasticsearch server');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->text('Starting to generate user report...');

        try {
            $this->reportUserCommentRepository->callUserCommentReportProcedure();
            $io->success('User report has been generated.');
        } catch (\Exception $exception) {
            $io->error('An error has occured while generating user report in database.');
            return 1;
        }

        try {
            $io->text('Sending report as document collection into elasticsearch server.');
            $command = $this->getApplication()->find('fos:elastica:populate');
            $arguments = [
                '--index' => 'user'
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
