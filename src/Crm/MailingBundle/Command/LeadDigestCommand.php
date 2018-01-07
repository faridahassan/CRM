<?php

namespace Crm\MailingBundle\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class LeadDigestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('lead:digest')
            ->setDescription('Sends Daily Inventory Digest Emails to Admins, Sales, Sales Redpresentative users')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $this->getContainer()->get('crm.mailingBundle.mailingManager')->sendLeadDigest();
        $output->writeln($message);
    }
}