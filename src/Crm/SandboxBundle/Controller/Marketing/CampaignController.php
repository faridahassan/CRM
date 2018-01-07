<?php

namespace Crm\SandboxBundle\Controller\Marketing;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Crm\SandboxBundle\Entity\Channel;
use Crm\SandboxBundle\Form\ChannelType;
use Crm\SandboxBundle\Entity\SubChannel;
use Crm\SandboxBundle\Form\SubChannelType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CampaignController extends Controller
{

    public function reportChannelsAction()
    {
        return $this->render('CrmSandboxBundle:Marketing/Campaign:channels_report.html.twig', array('channs' => $result));      
    }

    /**
     * @ParamConverter("channel", class="CrmSandboxBundle:Channel")
     */
    public function leadsByChannelAction(Channel $channel)
    {
        //you're working here
        $results = [];
        foreach ($variable as $key => $value) {
            # code...
        }
        return $this->render('CrmSandboxBundle:Marketing/Campaign:leads_by_channel.html.twig', array(
                'leads' => $results
            ));
    }

    /**
     * @ParamConverter("channel", class="CrmSandboxBundle:Channel")
     */
    public function reportSubChannelsAction(Channel $channel)
    {
        //$em = $this->getDoctrine()->getManager();

        $chans = $channel->getSubChannels();

        $result = array();

        foreach ($chans as $chan) {
            //$curRes = array();

            //name
            $id = $chan->getId();
            $name = $chan->getName();
            //# leads
            $numberOfLeads = 0;
            //closed deals
            $numberClosedDeals = 0;

            $listOfLeads = $chan->getLeads();

            foreach ($listOfLeads as $lead) {

                $numberOfLeads++;
                $deals = $lead->getDeals();

                foreach ($deals as $deal) {
                    if($deal->getClosed()){
                        $numberClosedDeals++;
                    }
                }
                
            }

            $result[] = array(
                    'id'=>$id,
                    'name' => $name,
                    'numberOfLeads' => $numberOfLeads,
                    'costOfSubChannel' => $chan->getCost(),
                    'numberClosedDeals' => $numberClosedDeals
                );

        }



        return $this->render('CrmSandboxBundle:Marketing/Campaign:report.html.twig', array('channs' => $result));      
    }

    public function manageCampaignAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $chans = $em->getRepository('CrmSandboxBundle:Channel')->findAll();

        $result = array();

        foreach ($chans as $chan) {
            if ($chan->getHide()) {
                continue;
            }
            //$curRes = array();

            //name
            $name = $chan->getType();
            //# leads
            $numberOfLeads = 0;
            //closed deals
            $numberClosedDeals = 0;

            $costOfChannel = 0;

            $listOfSubChannels = $chan->getSubChannels();

            foreach ($listOfSubChannels as $subChannel) {

                $numberOfLeads+= count($subChannel->getLeads());
                $costOfChannel+= $subChannel->getCost();
                // $leads = $subChannel->getLeads();
                // $deals = $lead->getDeals();

                foreach ($subChannel->getLeads() as $lead) {
                    foreach ($lead->getDeals() as $deal) {
                        # code...
                        if($deal->getClosed()){
                        $numberClosedDeals++;
                    }
                    }
                }
                
            }

            $result[] = array(
                    'id' => $chan->getId(),
                    'name' => $name,
                    'numberOfLeads' => $numberOfLeads,
                    'costOfChannel' => $costOfChannel,
                    'numberClosedDeals' => $numberClosedDeals
                );

        }

        $chans = $em->getRepository('CrmSandboxBundle:SubChannel')->findAll();
        
        $resultSubChannel = array();

        foreach ($chans as $chan) {
            //$curRes = array();
            if ($chan->getHide()) {
                continue;
            }
            //name
            $id = $chan->getId();
            if(!is_null($chan->getChannel()))
                $name = $chan->getChannel()->getType() . ' - ' . $chan->getName();
            else {
                $name = $chan->getName();
            }
            //# leads
            $numberOfLeads = 0;
            //closed deals
            $numberClosedDeals = 0;

            $listOfLeads = $chan->getLeads();

            foreach ($listOfLeads as $lead) {

                $numberOfLeads++;
                $deals = $lead->getDeals();

                foreach ($deals as $deal) {
                    if($deal->getClosed()){
                        $numberClosedDeals++;
                    }
                }
                
            }

            $resultSubChannel[] = array(
                    'id' => $id,
                    'name' => $name,
                    'numberOfLeads' => $numberOfLeads,
                    'costOfSubChannel' => $chan->getCost(),
                    'numberClosedDeals' => $numberClosedDeals,
                    'startDate' => $chan->getStartDate(),
                    'endDate' => $chan->getEndDate(),
                );

        }

    	//Generating form for channel
    	$channel = new Channel();
    	$channelForm = $this->createChannelCreateForm($channel);

    	$subChannel = new SubChannel();
    	$subChannelForm = $this->createSubChannelCreateForm($subChannel);

    	// if($channelForm->isValid()) {
    		
    	// }

    	

        // $channels = $em->getRepository('CrmSandboxBundle:Channel')->findAll();
        
    	return $this->render('CrmSandboxBundle:Marketing/Campaign:manage.html.twig', array('channels' => $result, 'subChannels' => $resultSubChannel, 'channelForm' => $channelForm->createView(), 'subChannelForm' => $subChannelForm->createView()));
    }

    /**
     * Creates a form to create a Channel entity.
     *
     * @param Channel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createChannelCreateForm(Channel $entity)
    {
        $form = $this->createForm(new ChannelType(), $entity, array(
            'action' => $this->generateUrl('channel_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
    /**
     * Creates a form to create a SubChannel entity.
     *
     * @param SubChannel $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createSubChannelCreateForm(SubChannel $entity)
    {
        $form = $this->createForm(new SubChannelType(), $entity, array(
            'action' => $this->generateUrl('subchannel_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }
}
