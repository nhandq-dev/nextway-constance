<?php

namespace App\Service;

use App\Repository\SocialRepository;
use App\Utils\DatetimeUtil;
use App\Utils\HealthUtil;
use App\Utils\SocialUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Log\LoggerInterface;

class ActivityService
{
  private $logger;
  private $socialRepository;

  public function __construct(LoggerInterface $logger, SocialRepository $socialRepository)
  {
    $this->logger = $logger;
    $this->socialRepository = $socialRepository;
  }

  public function searchTeam(?string $keyword, ?int $page, ?int $pageSize = 10)
  {
    $this->logger->info('Start searchTeam...');
    $teamWithPagination = [
      'teams' => [],
      'page_info' => [
        'page_number' => $page,
        'page_size' => $pageSize,
        'total' => 0,
      ],
    ];
    $teams = $this->socialRepository->getManyAndCount(SocialUtil::TYPE_TEAM, $page, $pageSize, $keyword);
    if (count($teams) === 0) {
      return $teamWithPagination;
    }

    $teamWithPagination['page_info']['total'] = $teams[0]['total'];
    foreach ($teams as $team) {
      $teamWithPagination['teams'][] = [
        'id' => $team['id'],
        'name' => $team['name'],
        'description' => $team['description'],
        'created_at' => $team['createdAt'],
      ];
    }

    $this->logger->info('Done searchTeam');
    return $teamWithPagination;
  }

  public function getHealthOnTeam(): array
  {
    $healthResponse = new ArrayCollection();
    $healths = $this->socialRepository->getHealth();
    if (count($healths) === 0) {
      return [];
    }
    $totalResponse = $healths[0]['total_answer'];

    foreach ($healths as $health) {
      $healthTitle = HealthUtil::HEALTH_STATUS_MAPPING[$health['point']];
      $timeStamp = DatetimeUtil::getTimeStampFromDatetime($health['created_at'], DatetimeUtil::YMD_TIME_FORMAT, true);

      if (!$healthResponse->containsKey($healthTitle)) {
        $healthResponse->set($healthTitle, [
          'title' => $healthTitle,
          'data' => new ArrayCollection(),
        ]);
      }
      if (!$healthResponse[$healthTitle]['data']->containsKey($timeStamp)) {
        $healthResponse[$healthTitle]['data']->set($timeStamp, 0);
      }

      $healthResponse[$healthTitle]['data'][$timeStamp] += $health['id'];
    }

    return $healthResponse->toArray();
  }
}
