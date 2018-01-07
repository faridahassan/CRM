<?php

namespace Crm\FosUserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CrmFosUserBundle extends Bundle
{
		public function getParent(){
		return 'FOSUserBundle';
	}
}
