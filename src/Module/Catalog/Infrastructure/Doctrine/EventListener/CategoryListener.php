<?php

namespace App\Module\Catalog\Infrastructure\Doctrine\EventListener;

use App\Module\Catalog\Domain\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::postPersist)]
#[AsDoctrineListener(event: Events::postUpdate)]
#[AsDoctrineListener(event: Events::preFlush)]
#[AsDoctrineListener(event: Events::postFlush)]
final class CategoryListener
{
    /**
     * @var Category[]
     */
    private array $categoryQueue;

    public function postPersist(PostPersistEventArgs $event): void
    {
        $this->addToCategoryQueue($event->getObject());
    }

    public function postUpdate(PostUpdateEventArgs $event): void
    {
        $this->addToCategoryQueue($event->getObject());
    }

    public function preFlush(): void
    {
        $this->resetCategoryQueue();
    }

    public function postFlush(PostFlushEventArgs $eventArgs): void
    {
        foreach ($this->categoryQueue as $category) {
            if ($category instanceof Category) {
                $this->updateIndentedName($category, $eventArgs->getObjectManager());
            }
        }

        $this->resetCategoryQueue();
    }

    private function resetCategoryQueue(): void
    {
        $this->categoryQueue = [];
    }

    private function addToCategoryQueue(object $object): void
    {
        if ($object instanceof Category) {
            $this->categoryQueue[] = $object;
        }
    }

    private function updateIndentedName(Category $category, EntityManagerInterface $em): void
    {
        $category->updateIndentedName();
        $em->persist($category);
        $em->flush();
    }
}
