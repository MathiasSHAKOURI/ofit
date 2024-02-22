<?php
namespace App\EventListener;

use App\Entity\Exercice;
use Symfony\Component\String\Slugger\SluggerInterface;

class ExerciceListener{

    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function slugifyTitle(Exercice $exercice)
    {
        $exercice->setSlug(strtolower($this->slugger->slug($exercice->getTitle())));
    }
}