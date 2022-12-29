<?php

namespace App\Controller\Api;

use App\Service\TeamService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

#[Route('/api/v1', name: 'app_api_')]
class TeamController extends AbstractController
{
    #[Route('/teams/search', name: 'search_teams', methods: ['GET'])]
    public function searchTeam(
        Request $request,
        LoggerInterface $logger,
        TeamService $teamService
    ): Response {
        $logger->info('Start search_teams...');
        $data = [
            'data' => [],
            'status' => [
                'code' => Response::HTTP_OK,
                'message' => 'Success'
            ]
        ];

        try {
            $page = (int) $request->query->get('page', 1);
            $page = $page < 1 ? 1 : $page;
            $keyword = (string) $request->query->get('keyword', '');
            $pageSize = (int) $request->query->get('page_size', 1);
            $pageSize = $pageSize < 1 ? 1 : $pageSize;

            $data['data'] = $teamService->searchTeam($keyword, $page, $pageSize);
        } catch (\Exception $ex) {
            dump($ex) . die;
            $logger->error('Error on get_heal_teams. Code: ' . $ex->getCode() . ', message: ' . $ex->getMessage());
            $data['status']['code'] = Response::HTTP_BAD_REQUEST;
            $data['status']['message'] = 'Oops! A small glitch happened. Please contact Administrator for help';
        }

        $logger->info('Done search_teams');
        return $this->json($data);
    }

    #[Route('/heals/teams', name: 'get_health_teams', methods: ['GET'])]
    public function getHealthOnTeam(
        LoggerInterface $logger,
        TeamService $teamService
    ): Response {
        $logger->info('Start get_health_teams...');
        $data = [
            'data' => [],
            'status' => [
                'code' => Response::HTTP_OK,
                'message' => 'Success'
            ]
        ];

        try {
            $data['data'] = $teamService->getHealthOnTeam();
        } catch (\Exception $ex) {
            $logger->error('Error on get_health_teams. Code: ' . $ex->getCode() . ', message: ' . $ex->getMessage());
            $data['status']['code'] = Response::HTTP_BAD_REQUEST;
            $data['status']['message'] = 'Oops! A small glitch happened. Please contact Administrator for help';
        }

        $logger->info('Done get_health_teams');
        return $this->json($data);
    }
}
