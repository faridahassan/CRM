<?php

namespace Crm\SandboxBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Crm\SandboxBundle\Entity\User;
use Crm\SandboxBundle\Entity\Contact;
use Crm\SandboxBundle\Entity\Lead;
use Crm\SandboxBundle\Entity\Channel;
use Crm\SandboxBundle\Entity\SubChannel;
use Crm\SandboxBundle\Entity\Call;
use Crm\SandboxBundle\Entity\Database;
use Crm\SandboxBundle\Entity\Deal;

class LoadSandboxData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user1= new User();
        $user1->setName('george');
        $user1->setUsername('george');
        $user1->setPlainPassword('qwe');
        $user1->setEmail('george@gmail.com');
        $user1->setEnabled(true);
        $user1->addRole('admin');

        $manager->persist($user1);


        $user2= new User();
        $user2->setName('seif');
        $user2->setUsername('seif');
        $user2->setPlainPassword('qwe');
        $user2->setEmail('seif@gmail.com');
        $user2->setEnabled(true);
        $user2->addRole('SALES_REPRESENTITIVE');

        $manager->persist($user2);

        $user3= new User();
        $user3->setName('omar');
        $user3->setUsername('omar');
        $user3->setPlainPassword('qwe');
        $user3->setEmail('omar@gmail.com');
        $user3->setEnabled(true);
        $user3->addRole('CALL_CENTER');

        $manager->persist($user3);

         //Channels and SubChannels
        $channel1 = new Channel();
        $channel1->setType('Digital');

        $manager->persist($channel1);

        $subchannel1 = new SubChannel();
        $subchannel1->setName('Facebook');
        $subchannel1->setStartDate(new \DateTime('2013-3-28'));
        $subchannel1->setChannel($channel1);

        $subchannel2 = new SubChannel();
        $subchannel2->setName('Twitter');
        $subchannel2->setStartDate(new \DateTime('2014-7-18'));
        $subchannel2->setChannel($channel1);

        $subchannel3 = new SubChannel();
        $subchannel3->setName('Instagram');
        $subchannel3->setStartDate(new \DateTime('2014-3-18'));
        $subchannel3->setChannel($channel1);

        $manager->persist($subchannel3);
        
        $channel2 = new Channel();
        $channel2->setType('Newspaper');

        $manager->persist($channel2);

        $subchannel4 = new SubChannel();
        $subchannel4->setName('Waseet');
        $subchannel4->setStartDate(new \DateTime('2010-3-18'));
        $subchannel4->setChannel($channel1);

        $manager->persist($subchannel4);

        $lead1 = new Lead();

        $lead1->setAssignedSalesRep($user2);
        $lead1->setSubChannel($subchannel2);
        $lead1->setInfo('lead info');
        $lead1->setStatus('lead status');
        $lead1->setEvaluation('lead Evaluation');
        $lead1->setDescription('lead description');
        $lead1->setBudget(2000000);
        $lead1->setIsLead(true);

        $manager->persist($lead1);
        
        $lead2 = new Lead();
        $lead2->setAssignedSalesRep($user2);
        $lead2->setSubChannel($subchannel2);
        $lead2->setInfo('lead info');
        $lead2->setStatus('lead status');
        $lead2->setEvaluation('lead Evaluation');
        $lead2->setDescription('lead description');
        $lead2->setBudget(2000000);
        $lead2->setIsLead(true);
        //info
        //status
        //evaluation
        //description
        //opportunity
        //budget
        //is_lead

        $manager->persist($lead2);

        $database1 = new Database();

        $database1->setName('Database 101');

        $manager->persist($database1);

        $database2 = new Database();

        $database2->setName('Database 202');

        $manager->persist($database2);

        $contact1 = new Contact();
        $contact1->setName('omar');
        $contact1->setEmail('omar@yahoo.com');
        $contact1->setMobile('01114436743');
        $contact1->setDatabase($database1);
        $contact1->setLead($lead1);


        $manager->persist($contact1);

        $contact2 = new Contact();
        $contact2->setName('yehia');
        $contact2->setEmail('yehia@yahoo.com');
        $contact2->setMobile('01114826743');
        $contact2->setDatabase($database1);
        $contact2->setLead($lead2);

        $manager->persist($contact2);

        $contact3 = new Contact();
        $contact3->setName('ahmed');
        $contact3->setEmail('ahmed@yahoo.com');
        $contact3->setMobile('01114826743');
        $contact3->setDatabase($database1);

        $manager->persist($contact3);

        $contact4 = new Contact();
        $contact4->setName('mohamed');
        $contact4->setEmail('mohamed@yahoo.com');
        $contact4->setMobile('01114826743');
        $contact4->setDatabase($database2);

        $manager->persist($contact4);

        $contact5 = new Contact();
        $contact5->setName('ali');
        $contact5->setEmail('ali@yahoo.com');
        $contact5->setMobile('01114826743');
        $contact5->setDatabase($database2);

        $manager->persist($contact5);
        

        $call1 = new Call();
        $call1->setLead($lead1);
        $call1->setUser($user3);
        $call1->setOutcome('Interesting call');
        $call1->setOrientation('inbound');
        $call1->setObjective('An objective');
        $call1->setDate(new \DateTime('2015-10-28'));
        $call1->setIsCall(true);

        $manager->persist($call1);

        $call2 = new Call();
        $call2->setLead($lead1);
        $call2->setUser($user3);
        $call2->setOutcome('Not as interesting as previous');
        $call2->setOrientation('outbound');
        $call2->setObjective('An objective');
        $call2->setDate(new \DateTime('2015-10-29'));
        $call2->setIsCall(true);

        $manager->persist($call2);

        $visit1 = new Call();
        $visit1->setLead($lead1);
        $visit1->setUser($user2);
        $visit1->setOutcome('Interesting call');
        $visit1->setObjective('An objective');
        $visit1->setDate(new \DateTime('2015-10-28'));
        $visit1->setIsCall(false);
        $property3 = $this->getReference('property3');
        $visit1->setProperty($property3);
        

        $manager->persist($visit1);

        $visit2 = new Call();
        $visit2->setLead($lead1);
        $visit2->setUser($user2);
        $visit2->setOutcome('Interesting call');
        $visit2->setObjective('An objective');
        $visit2->setDate(new \DateTime('2015-8-18'));
        $visit2->setIsCall(false);
        //$property3 = $this->getReference('property3');
        $visit2->setProperty($property3);
        

        $manager->persist($visit2);

        $deal1 = new Deal();

        $deal1->setUser($user2);
        $deal1->setLead($lead2);
        $deal1->setUnit('P90');
        $deal1->setClosed(true);
        $deal1->setPrice(100000);
        $deal1->setDeposit(5000);
        $deal1->setinstalmentValue(5000);
        $deal1->setInstalments(19);
        $deal1->setPaidInstalment(4);
        $deal1->setCommission('2');
        $deal1->setApproved(false);
        $deal1->setDate(new \DateTime('2015-10-31'));

        $manager->persist($deal1);

        $deal2 = new Deal();

        $deal2->setUser($user2);
        $deal2->setLead($lead1);
        $deal2->setUnit('A20');
        $deal2->setClosed(true);
        $deal2->setPrice(200000);
        $deal2->setDeposit(10000);
        $deal2->setinstalmentValue(10000);
        $deal2->setInstalments(19);
        $deal2->setPaidInstalment(8);
        $deal2->setCommission('2');
        $deal2->setApproved(true);
        $deal2->setDate(new \DateTime('2015-10-31'));

        $manager->persist($deal2);

        $manager->flush();
    }
    public function getOrder() {
        return 1;
    }
}
