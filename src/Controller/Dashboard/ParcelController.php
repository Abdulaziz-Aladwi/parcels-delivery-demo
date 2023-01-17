<?php

namespace App\Controller\Dashboard;

use App\Entity\Parcel;
use App\Form\ParcelFormType;
use App\Form\SenderParcelFormType;
use App\Service\ParcelService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * @Route("dashboard/parcels")
 */
class ParcelController extends AbstractController
{
    const MAX_RECORDS_PER_PAGE = 10;
    const FIRST_PAGE = 1;

    /** @var ParcelService */
    private $parcelService;

    public function __construct(ParcelService $parcelService)
    {
        $this->parcelService = $parcelService;   
    }

    /**
     * @Route("/", name="parcels_home")
     */
    public function index(Request $request): Response
    {

        $parcelsQueryBuilder = $this->parcelService->list();

        $parcels = $this->parcelService->paginate(
            $parcelsQueryBuilder,
            $request->query->getInt('page', self::FIRST_PAGE),
            self::MAX_RECORDS_PER_PAGE
        );

        return $this->render('dashboard/parcel/index.html.twig',['title' => 'Parcels', 'parcels' => $parcels]);
    }    
    
    /**
     * @Route("/create/form", name="parcels_create_form")
     * @IsGranted("ROLE_SENDER")
     * @Method({"GET"})
     */
    public function createFormAction(): Response
    {
        $form = $this->parcelService->createSenderParcelForm();
        return $this->render('dashboard/parcel/create.html.twig',['title' => 'Create Parcels', 'form' => $form->createView()]);
    }

    /**
     * @Route("/create", name="parcels_create")
     * @IsGranted("ROLE_SENDER")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        $this->parcelService->create($request);
        $this->addFlash('success', 'Parcel Created Successfully!');
        return $this->redirectToRoute('parcels_home');
    } 
    
    /**
     * @Route("/update/{id}/form", name="parcels_update_form")
     * @IsGranted("ROLE_BIKER")
     * @Method({"GET"})
     */
    public function pickUpFormAction(Parcel $parcel): Response
    {
        $this->parcelService->validateParcelStatus($parcel);
        $form = $this->parcelService->createBikerParcelForm($parcel);
        return $this->render('dashboard/parcel/pickup.html.twig',['title' => 'Pick Up Parcels', 'form' => $form->createView()]);
    }

    /**
     * @Route("/update/{id}", name="parcels_update")
     * @IsGranted("ROLE_BIKER")
     * @Method({"POST"})
     */
    public function updateAction(Request $request, Parcel $parcel)
    {
        $this->parcelService->update($request, $parcel);
        $this->addFlash('success', 'Parcel Created Successfully!');
        return $this->redirectToRoute('parcels_home');
    }      
}
