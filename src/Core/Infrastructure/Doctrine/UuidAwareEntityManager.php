<?php

namespace App\Core\Infrastructure\Doctrine;

use Doctrine\ORM\Decorator\EntityManagerDecorator;

/**
 * @see https://github.com/doctrine-extensions/DoctrineExtensions/issues/2216#issuecomment-926767989
 */
class UuidAwareEntityManager extends EntityManagerDecorator
{
    public function createQueryBuilder(): UuidAwareQueryBuilder
    {
        return new UuidAwareQueryBuilder($this);
    }
}
