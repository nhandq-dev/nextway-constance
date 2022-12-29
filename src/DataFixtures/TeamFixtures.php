<?php

namespace App\DataFixtures;

use App\Entity\Social;
use App\Utils\SocialUtil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeamFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++) {
            $team = new Social();
            $team->setName('team ' . $i);
            $team->setDescription('team description Globally e-enable client-focused experiences via wireless innovation. Assertively revolutionize innovative best practices and transparent opportunities. Intrinsicly streamline mission-critical customer ' . $i);
            $team->setIsActive(true);
            $team->setType(SocialUtil::TYPE_TEAM);

            $manager->persist($team);
        }

        $manager->flush();
    }
}
