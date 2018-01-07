<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        date_default_timezone_set('Africa/Cairo');
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Crm\SandboxBundle\CrmSandboxBundle(),
            new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
            new Crm\BrookerInventoryBundle\CrmBrookerInventoryBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new Crm\MailingBundle\CrmMailingBundle(),
            new Crm\NotificationBundle\CrmNotificationBundle(),
            new JMS\TranslationBundle\JMSTranslationBundle(),
            new Comur\ImageBundle\ComurImageBundle(),
            new WebsiteBundle\WebsiteBundle(),
            new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new Crm\FosUserBundle\CrmFosUserBundle(),
            new SimpleThings\EntityAudit\SimpleThingsEntityAuditBundle(),
            new Crm\AuditingBundle\CrmAuditingBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
