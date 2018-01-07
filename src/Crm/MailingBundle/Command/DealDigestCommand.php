<?php

namespace Crm\MailingBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DealDigestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('deal:digest')
            ->setDescription('Sends Daily Deal Digest Emails to Admins, Sales, Sales Redpresentative users')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $this->getContainer()->get('crm.mailingBundle.mailingManager')->sendDealDigest();
        $output->writeln($message);
    }
}