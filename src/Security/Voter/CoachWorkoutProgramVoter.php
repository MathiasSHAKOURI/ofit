<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CoachWorkoutProgramVoter extends Voter
{
    public const WORKOUT_PROGRAM_EDIT = 'WORKOUT_PROGRAM_EDIT';
    public const WORKOUT_PROGRAM_DELETE = 'WORKOUT_PROGRAM_DELETE';

    private $security;

    public function __construct(Security $security){
        $this->security = $security;
    }

    protected function supports(string $attribute, $workoutProgram): bool
    {
        
        return in_array($attribute, [self::WORKOUT_PROGRAM_EDIT, self::WORKOUT_PROGRAM_DELETE])
            && $workoutProgram instanceof \App\Entity\WorkoutProgram;
    }

    protected function voteOnAttribute(string $attribute, $workoutProgram, TokenInterface $token): bool
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
            case self::WORKOUT_PROGRAM_EDIT:
            case self::WORKOUT_PROGRAM_DELETE:

                if($this->security->isGranted("ROLE_COACH") && $user === $workoutProgram->getUser()) {
                    return true;   
                }
                break; 
            }
        return false;
        }
    }
