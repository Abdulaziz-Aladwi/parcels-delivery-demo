<?php

namespace App\Controller\Dashboard;

use App\Constant\ParcelStatus;
use App\Entity\Parcel;
use App\Service\StatisticService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("dashboard")
 */
class HomeController extends AbstractController
{
    /** @var StatisticService */
    private $statisticService;

    public function __construct(StatisticService $statisticService)
    {
        $this->statisticService = $statisticService;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $data =array();
        foreach(ParcelStatus::getParcelStatus() as $key=>$status) {
            $criteria = ['status' => $key];
            $data[$status] = $this->statisticService->getParcelsCount($criteria);
        }
        
        return $this->render('dashboard/home/index.html.twig',['title' => 'Home', 'data' => $data]);
    }    
    
}
