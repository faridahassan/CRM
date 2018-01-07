<?php

namespace Crm\BrookerInventoryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Crm\BrookerInventoryBundle\Entity\Property;

class LoadBrookerInventoryData extends AbstractFixture implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $property1 = new Property();
        $property1->setLocation('Maadi');
        $property1->setName('MA300B');
        $property1->setAquireDate(new \DateTime('2013-3-15'));
        $property1->setSellingType('Cash');

        $manager->persist($property1);

        $property2 = new Property();
        $property2->setLocation('Zamalek');
        $property2->setName('ZA201C');
        $property2->setAquireDate(new \DateTime('2014-1-12'));
        $property2->setSellingType('Card');

        $manager->persist($property2);

        $property3 = new Property();
        $property3->setLocation('Zamalek');
        $property3->setName('ZA100B');
        $this->setReference('property3', $property3);
        $property3->setAquireDate(new \DateTime('2014-3-15'));
        $property3->setSellingType('Instalments');

        $manager->persist($property3);

        $manager->flush();
    }
    public function getOrder() {
        return 2;
    }
}
