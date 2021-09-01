<?php

namespace Proycer\LogBook;

use Proycer\LogBook\DependencyInjection\LogBookExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LogBookBundle extends Bundle
{
	public function getContainerExtension()
	{
		if(null === $this->extension){
			$this->extension = new LogBookExtension();
		}

		return $this->extension;
	}

}