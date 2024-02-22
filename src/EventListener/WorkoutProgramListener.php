<?php
namespace App\EventListener;

use App\Entity\WorkoutProgram;
use Symfony\Component\String\Slugger\SluggerInterface;

class WorkoutProgramListener{

    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function slugifyTitle(WorkoutProgram $workoutProgram)
    {
        $workoutProgram->setSlug(strtolower($this->slugger->slug($workoutProgram->getTitle())));
    }

    public function setCreatedAt(WorkoutProgram $workoutProgram)
    {
        $workoutProgram->setCreatedAt(new \DateTimeImmutable("now"));
    }

    public function setUpdatedAt(WorkoutProgram $workoutProgram)
    {
        $workoutProgram->setUpdatedAt(new \DateTimeImmutable("now"));
    }

    public function setDuration(WorkoutProgram $workoutProgram)
    {
        if ($workoutProgram->getWorkoutParameters()->isEmpty())
        {
            return;
        };

        $workoutExercices = $workoutProgram->getWorkoutParameters();
        
        $totalRestBetween = (count($workoutExercices) -1) * $workoutProgram->getRestBetween();
        $durationCount = 0;

        foreach ($workoutExercices as $exercice)
        {
            if ($exercice->getReps()) {
                $exerciceDuration = $exercice->getReps() * 3;
            } else if ($exercice->getDuration()){
                $exerciceDuration = $exercice->getDuration();
            };

            $sets = $exercice->getSets();
            $restsDuration = ($sets - 1) * $exercice->getRest();
            $durationCount += ($exerciceDuration * $sets) + $restsDuration;
        };

        $total = ($durationCount + $totalRestBetween) / 60;
        $workoutProgram->setDuration(intval(round($total)));
    }

    public function setPicture(WorkoutProgram $workoutProgram)
    {
        if (!$workoutProgram->getPicture())
        {
            $workoutProgram->setPicture('https://images.pexels.com/photos/1552242/pexels-photo-1552242.jpeg?auto=compress&cs=tinysrgb&w=600');
        };
    }
}