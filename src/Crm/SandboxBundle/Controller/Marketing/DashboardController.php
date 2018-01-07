<?php

namespace Crm\SandboxBundle\Controller\Marketing;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Crm\SandboxBundle\Entity\Channel;
use Crm\SandboxBundle\Form\ChannelType;
use Crm\SandboxBundle\Entity\SubChannel;
use Crm\SandboxBundle\Form\SubChannelType;

class DashboardController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $beginDate= new \DateTime('00-00-0000');
        $endDate= new \DateTime('now');
        $currentMonth = $endDate->format('m');
        $currentYear = $endDate->format('Y');
        $currentBeginDate = new \DateTime('1-'.$currentMonth.'-'.$currentYear);
        $currentEndDate = new \DateTime('31-'.$currentMonth.'-'.$currentYear);

        $channelsBreakdown = $this->get('crm.sandboxbundle.leadsManager')->getCaseByOrigin($beginDate,$endDate);
        $leadsByChannel = $this->get('crm.sandboxbundle.leadsManager')->getLeadsByChannel($beginDate,$endDate);

        $leadsByDate  = $em->getRepository('CrmSandboxBundle:Lead')->getLeadsByDate($currentBeginDate,$currentEndDate);
        
        
        return $this->render('CrmSandboxBundle:Marketing/Dashboard:index.html.twig', array(
            'channelsBreakdown' => $channelsBreakdown,
            'leadsByChannel' => $leadsByChannel,
            'leadsByDate'=>$leadsByDate

        ));
    }

    public function updateChannelBreakdownAction(Request $request)
    {
        $dates = $this->getDates($request);

        $currentBeginDate = new \DateTime($dates['beginDate'].'-'.$dates['smonth'].'-'.$dates['syear']);
        $currentEndDate   = new \DateTime($dates['endDate'].'-'.$dates['emonth'].'-'.$dates['eyear']);
        
        $channelsBreakdown = $this->get('crm.sandboxbundle.leadsManager')->getCaseByOrigin($currentBeginDate,$currentEndDate);

        return $this->render('CrmSandboxBundle:Marketing/Dashboard/AjaxTemplates:casebyorigin.html.twig', array(
            'channelsBreakdown' => $channelsBreakdown,
        ));
    }

    public function updateLeadsByChannelAction(Request $request)
    {
        $dates = $this->getDates($request);

        $currentBeginDate = new \DateTime($dates['beginDate'].'-'.$dates['smonth'].'-'.$dates['syear']);
        $currentEndDate   = new \DateTime($dates['endDate'].'-'.$dates['emonth'].'-'.$dates['eyear']);

        $leadsByChannel = $this->get('crm.sandboxbundle.leadsManager')->getLeadsByChannel($currentBeginDate,$currentEndDate); 

        return $this->render('CrmSandboxBundle:Marketing/Dashboard/AjaxTemplates:leadsbycampaign.html.twig', array(
            'leadsByChannel' => $leadsByChannel,

        ));
    }

    public function updateChartAction(Request $request)
    {
        $em    = $this->getDoctrine()->getManager();
        $dates = $this->getDates($request);

        $currentBeginDate = new \DateTime($dates['beginDate'].'-'.$dates['smonth'].'-'.$dates['syear']);
        $currentEndDate   = new \DateTime($dates['endDate'].'-'.$dates['emonth'].'-'.$dates['eyear']);

        $leadsByDate  = $em->getRepository('CrmSandboxBundle:Lead')->getLeadsByDate($currentBeginDate,$currentEndDate);

        return $this->render('CrmSandboxBundle:Marketing/Dashboard/AjaxTemplates:chart.html.twig', array(
            'leadsByDate'=>$leadsByDate
        ));
    }

    private function getDates(Request $request)
    {
        $result = [];
        $result['beginDate'] = $request->get('beginDate');
        $result['endDate']   = $request->get('endDate');
        $result['smonth']    = $request->get('smonth');
        $result['emonth']    = $request->get('emonth');
        $result['syear']     = $request->get('syear');
        $result['eyear']     = $request->get('eyear');

        return $result;
    }
}
