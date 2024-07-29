<?php

namespace App\Module\Catalog\Infrastructure\Repository;

use App\Module\Catalog\Domain\Entity\Category;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 * @extends NestedTreeRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends NestedTreeRepository
{
}
