<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\TestUsers;
use App\Repository\TestUsersRepository;

class TestUsersController extends AbstractController
{
    private $testUsersRepository;

    public function __construct(TestUsersRepository $testUsersRepository)
    {
        $this->testUsersRepository = $testUsersRepository;
    }


    /**
     * @Route("/test/users", name="search", methods={"GET"})
     */
    public function search(Request $request): JsonResponse
    {
        //get params form request query
        $isActive = $request->query->get('is_active', null);
        $isMember = $request->query->get('is_member', null);
        $lastLoginFrom = $request->query->get('last_login_from', null);
        $lastLoginTo = $request->query->get('last_login_to', null);
        $userTypes = $request->query->get('user_types', "");
        $userTypes = ($userTypes)?explode(",", $userTypes):$userTypes; //$userTypes is string in query, which has multiple values combine with comma

        //get all users  by is_active, is_member, last_login_at (range), and user_type (multiple values combine with comma)
        $users = $this->testUsersRepository->findAllBySearchFields($isActive, $isMember, $lastLoginFrom, $lastLoginTo, $userTypes);

        //return result with json format
        return $this->json($users, $status = 200, $headers = [], $context = []);
    }

}
