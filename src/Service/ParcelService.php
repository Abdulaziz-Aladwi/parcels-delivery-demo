<?php

namespace App\Service;

use App\Entity\Parcel;
use App\Form\SenderParcelFormType;
use App\Repository\ParcelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;

class ParcelService
{
    /** @var ParcelRepository */
    private $parcelRepository;

    /** @var PaginatorInterface */
    private $paginator;    

    /** @var PaginatorInterface */
    private $formFactory;    

    /** @var EntityManagerInterface */
    private $entityManager;    

    /** @var Security */
    private $security; 
    
    /** @var UrlGeneratorInterface */
    private $urlGenerator;     
        
    public function __construct(
        ParcelRepository $parcelRepository,
        PaginatorInterface $paginator, 
        FormFactoryInterface $formFactory,
        EntityManagerInterface $entityManager,
        Security $security,
        UrlGeneratorInterface $urlGenerator
        )
    {
        $this->parcelRepository = $parcelRepository;
        $this->paginator = $paginator;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    public function list(): QueryBuilder
    {
        return $this->parcelRepository->get();
    }

    public function paginate(QueryBuilder $queryBuilder,int $page,int $maxRecordsPerPage)
    {
        return $this->paginator->paginate($queryBuilder, $page,$maxRecordsPerPage);
    }

    public function create(Request $request): bool
    {
        $parcel = new Parcel();
        $form = $this->formFactory->create(SenderParcelFormType::class, $parcel);
        $parcel = $this->prepareObjectPreSave($parcel);
        $form->handleRequest($request);
        $dataSaved = false;

        if ($form->isValid()) {
            $this->entityManager->persist($parcel);
            $this->entityManager->flush();
            $dataSaved = true;
        }

        return $dataSaved;

    }

    public function createSenderParcelForm(): Form
    {
        return $this->formFactory->create(SenderParcelFormType::class, null, [
            'action' => $this->urlGenerator->generate('parcels_create'),
            'method' => 'POST',
        ]);
    }

    public function prepareObjectPreSave(Parcel $parcel): Parcel
    {
        $parcel->setSender($this->security->getUser());
        $parcel->setCreatedAt();
        return $parcel;
    }
}