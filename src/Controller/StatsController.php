<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\CigaretteRepository;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatsController extends AbstractController
{
    /**
     * @Route("/stats/{id}", name="stats_user")
     * @param User $user
     * @param CigaretteRepository $cigaretteRepository
     * @return Response
     */
    public function index(User $user, CigaretteRepository $cigaretteRepository)
    {
        $todayDate = new DateTime('now');
        $nbDaysQuiting = date_diff($user->getQuitSmokingDate(), $todayDate);

        $smokedCigarettesSinceBeggining = count($cigaretteRepository->findBy([
            'isSmoked' => true,
            'user' => $user->getId()
        ]));

        $nbCigarettesHypothetic = $user->getNbCigarettePerDay() * $nbDaysQuiting->d ;

        return $this->render('stats/stats.html.twig', [
            'user' => $user,
            'nbDaysQuiting' => $nbDaysQuiting,
            'smokedCigarettesSinceBeggining' => $smokedCigarettesSinceBeggining,
            'nbCigarettesHypothetic' => $nbCigarettesHypothetic

        ]);
    }

}
