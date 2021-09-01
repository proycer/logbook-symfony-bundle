<?php

namespace Proycer\LogBook\Controller;

use Proycer\LogBook\Service\LogList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class LogListController extends AbstractController
{
	private LogList $logList;

	public function __construct(LogList $logList)
	{
		$this->logList = $logList;
	}

	/**
	 * @return Response
	 */
    public function __invoke(): Response
    {
		$logs = $this->logList->getLogList();

        return $this->render('@LogBook/listView.html.twig', [
            'logs' => $logs
        ]);
    }
}
