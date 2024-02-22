<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CoachArticleVoter extends Voter
{
    public const ARTICLE_EDIT = 'ARTICLE_EDIT';
    public const ARTICLE_DELETE = 'ARTICLE_DELETE';

    private $security;

    public function __construct(Security $security){
        $this->security = $security;
    }
   
    protected function supports(string $attribute, $article): bool
    {
        
        return in_array($attribute, [self::ARTICLE_EDIT, self::ARTICLE_DELETE])
            && $article instanceof \App\Entity\Article;
    }

    protected function voteOnAttribute(string $attribute, $article, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if($this->security->isGranted("ROLE_ADMIN")) {
            return true;
        }
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::ARTICLE_EDIT:
            case self::ARTICLE_DELETE:

                if($this->security->isGranted("ROLE_COACH") && $user === $article->getUser()) {
                    return true;   
                }
                break; 
        }
        return false;
    }
}
