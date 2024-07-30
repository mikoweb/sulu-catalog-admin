<?php

namespace App\Module\Catalog\Application\Security\Voter;

use App\Module\Catalog\Domain\Entity\Category;
use App\Module\Catalog\Infrastructure\Repository\CategoryRepositoryService;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CategoryVoter extends Voter
{
    public const string CATALOG_CATEGORY_SECURE_DELETE = 'catalog_category_secure_delete';

    public function __construct(
        private readonly CategoryRepositoryService $categoryRepositoryService,
    ) {
    }

    public function supports(string $attribute, $subject): bool
    {
        return $subject instanceof Category && $attribute == self::CATALOG_CATEGORY_SECURE_DELETE;
    }

    /**
     * @param Category $subject
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if (!$token->getUser() instanceof UserInterface) {
            return false;
        }

        return match ($attribute) {
            self::CATALOG_CATEGORY_SECURE_DELETE => $this->isNotConnectedRoot($subject),
            default => false,
        };
    }

    private function isNotConnectedRoot(Category $category): bool
    {
        return $category->getId() !== $this->categoryRepositoryService->getRepository()->findConnected()?->getId();
    }
}
