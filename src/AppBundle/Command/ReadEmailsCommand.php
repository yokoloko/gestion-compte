<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use PhpImap\Mailbox;

class ReadEmailsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:emails:read')
            ->setDescription('Read emails')
            ->setHelp('This command read emails');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<fg=green;>read emails command</>');


        $output->writeln($mail->textHtml);
    }

}