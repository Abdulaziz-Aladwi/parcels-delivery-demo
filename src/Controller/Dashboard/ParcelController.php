<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @Route("dashboard/parcels")
 */
class ParcelController extends AbstractController
{
    /**
     * @Route("/", name="parcels_home")
     */
    public function index(): Response
    {
        return $this->render('dashboard/parcel/index.html.twig',['title' => 'Parcels']);
    }    
    
}
