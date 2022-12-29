<?php

namespace App\DataFixtures;

use App\Entity\Social;
use App\Utils\SocialUtil;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommunityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 100; $i++) {
            $community = new Social();
            $community->setName('Community ' . $i);
            $community->setDescription('Community description Globally e-enable client-focused experiences via wireless innovation. Assertively revolutionize innovative best practices and transparent opportunities. Intrinsicly streamline mission-critical customer ' . $i);
            $community->setIsActive(true);
            $community->setType(SocialUtil::TYPE_COMMUNITY);

            $manager->persist($community);
        }

        $manager->flush();
    }
}
