<?php

namespace App\Service;

use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;

class PaginatorService
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