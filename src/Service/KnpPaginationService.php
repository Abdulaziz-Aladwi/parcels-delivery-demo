<?php

namespace App\Service;

use App\Abstraction\PaginationInterface;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;

class KnpPaginationService implements PaginationInterface
{
    /** @var PaginatorInterface */
    private $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    public function paginate(QueryBuilder $queryBuilder, int $page = 1, int $limit)
    {
        return $this->paginator->paginate($queryBuilder, $page, $limit);
    }
}