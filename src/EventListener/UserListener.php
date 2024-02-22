<?php
namespace App\EventListener;

use App\Entity\User;
use Faker\Factory;

class UserListener{

    public function setEmail(User $user)
    {
        if (in_array("ROLE_COACH", $user->getRoles()))
        {
            $firstname = str_replace(" ","",$user->getFirstname());
            $lastname = str_replace(" ","",$user->getLastname());
    
            $user->setEmail(strtolower(\Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($firstname.".".$lastname."@ofit.com")));
        };
    }

    public function setPseudo(User $user)
    {   
        $role = $user->getRoles();
        if ($user->getPseudo()) {
        
            if (in_array("ROLE_COACH", $role)) {
                $pseudo = str_ireplace("coach", "", $user->getPseudo());
                $user->setPseudo("Coach " . $pseudo);
            };
        }
        else
        {
            if (in_array("ROLE_COACH", $role)) {
                $pseudo = str_ireplace("coach", "", $user->getFirstname());
                $user->setPseudo("Coach " . $pseudo);
            };
        };
    }

    public function capitalizeNameAndPseudo(User $user)
    {   
        $user->setLastname(ucfirst($user->getLastname()));
        $user->setFirstname(ucfirst($user->getFirstname()));
        if ($user->getPseudo()){
            $user->setPseudo(ucfirst($user->getPseudo()));
        };
    }

    public function deleteCoach(User $user)
    {
        $articles = $user->getArticles();
        $programs = $user->getWorkoutPrograms();

        foreach ($articles as $key => $article) {
            $article->setUser(null);
        };
        foreach ($programs as $key => $program) {
            $program->setUser(null);
        };
    }

    public function setVerified(User $user)
    {
        if (in_array("ROLE_COACH", $user->getRoles())) {
            $user->setIsVerified(true);
        };
    }

    public function setPicture(User $user)
    {
        if (!$user->getPicture())
        {
            $user->setPicture('https://images.pexels.com/photos/6551080/pexels-photo-6551080.jpeg?auto=compress&cs=tinysrgb&w=600');
        };
    }
}