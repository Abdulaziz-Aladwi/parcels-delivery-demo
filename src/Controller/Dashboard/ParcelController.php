<?php

namespace App\Controller\Dashboard;

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
     * @Method({"GET"})
     */
    public function formAction(): Response
    {
        $form = $this->parcelService->createSenderParcelForm();
        return $this->render('dashboard/parcel/create.html.twig',['title' => 'Create Parcels', 'form' => $form->createView()]);
    }

    /**
     * @Route("/create", name="parcels_create")
     * @Method({"POST"})
     */
    public function create(Request $request)
    {
        $this->parcelService->create($request);
        $this->addFlash('success', 'Parcel Created Successfully!');
        return $this->redirectToRoute('parcels_home');
    }    
}
