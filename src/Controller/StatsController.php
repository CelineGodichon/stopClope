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

    const PRICE_PER_CIGARETTE = 0.40;

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

        $virtualSmokedCigarettes = $cigaretteRepository->findBy([
            'isSmoked' => false,
            'user' => $user->getId()
        ]);

        $smokedCigarettes = $cigaretteRepository->findBy([
            'isSmoked' => true,
            'user' => $user->getId()
        ]);

        $hypotheticPrice = $user->getNbHypotheticCigarettePerDay() * $nbDaysQuiting->d * self::PRICE_PER_CIGARETTE;
        $realPrice = 0;
        foreach ($smokedCigarettes as $smokedCigarette) {
            $realPrice += $smokedCigarette->getPrice();
        }

        $economy = $hypotheticPrice - $realPrice;
        $nbCigarettesHypothetic = $user->getNbHypotheticCigarettePerDay() * $nbDaysQuiting->d;

        return $this->render('stats/stats.html.twig', [
            'user' => $user,
            'economy' => $economy,
            'nbDaysQuiting' => $nbDaysQuiting->d,
            'nbCigarettesHypothetic' => $nbCigarettesHypothetic,
            'smokedCigarettes' => count($smokedCigarettes),
            'virtualSmokedCigarettes' => count($virtualSmokedCigarettes)

        ]);
    }

}
