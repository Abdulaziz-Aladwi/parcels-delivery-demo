<?php

namespace App\Abstraction;

use Doctrine\ORM\QueryBuilder;

interface PaginationInterface
{
    function paginate(QueryBuilder $queryBuilderData, int $page, int $limit);
}