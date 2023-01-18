<?php

namespace App\Controller\Dashboard;

use App\Constant\ParcelStatus;
use App\Constant\UserTypes;
use App\Entity\Parcel;
use App\Service\StatisticService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("dashboard")
 */
class HomeController extends AbstractController
{
    /** @var StatisticService */
    private $statisticService;

    /** @var Security */
    private $security;    

    public function __construct(StatisticService $statisticService, Security $security)
    {
        $this->statisticService = $statisticService;
        $this->security = $security;
    }
    
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $data = array();

        $user = $this->security->getUser();
     
        foreach(ParcelStatus::getParcelStatus() as $key => $status) {
            
            $criteria = ['status' => $key, $user->getTypeString() => $user];

            $data[$status] = $this->statisticService->getParcelsCount($criteria);
        }

        return $this->render('dashboard/home/index.html.twig',['title' => 'Home', 'data' => $data]);
    }    
    
}
