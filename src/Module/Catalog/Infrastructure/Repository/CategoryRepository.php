<?php

namespace App\Module\Catalog\Infrastructure\Repository;

use App\Core\Infrastructure\Doctrine\UuidAwareEntityManager;
use App\Module\Catalog\Domain\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;

/**
 *  @see https://github.com/doctrine-extensions/DoctrineExtensions/issues/2216#issuecomment-926767989
 *
 * @extends NestedTreeRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends NestedTreeRepository
{
    public function __construct(EntityManagerInterface $em, ClassMetadata $class)
    {
        parent::__construct(new UuidAwareEntityManager($em), $class);
    }

    public function findConnected(): ?Category
    {
        return $this->findOneBy(['connected' => true, 'parent' => null]);
    }
}
