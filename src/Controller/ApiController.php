<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\User;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/api", name="api")
 */
class ApiController extends Controller
{
    /**
     * @Route("/", name="api_index")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    /**
     * @Route("/login", name="api_login",  methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $mail = $request->get('Email');
        $psw = $request->get('Password');
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy([
            'Email' => $mail,
            'Password' => $psw
        ]);
        if (!$user) {
            return new JsonResponse(boolval(false));
        }
        return new JsonResponse($user->getToken());
    }

    /**
     * @Route("/refreshToken", name="api_refresh_token", methods={"POST"})
     *  return : token
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function refreshToken(Request $request)
    {
        $token = $request->get('Token');


        if ($this->token_exist($token)) {

            $token_new = $this->update_token($token);
            if (!$token) {
                throw $this->createNotFoundException(
                    "Perdu", 404
                );
            }
            return new JsonResponse($token_new);
        } else {
            throw $this->createNotFoundException(
                "Perdu", 404
            );
        }
    }

    /**
     * @Route("/getLocation", name="api_getLocation", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function getLocation(Request $request)
    {
        $token = $request->get('Token');

        $current_time = new DateTime();
        $current_time->format('Y-m-d H:i:s');

        dump($current_time);

   /*     if ($this->token_exist($token)) {
            return $this->current_location();

        }*/
        return new Response($token);
    }


    /**
     * @param $token
     * @return bool
     */
    private function token_exist($token)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy([
            'Token' => $token
        ]);

        if (!$user) {
            return false;
        }
        return true;
    }

    /**
     * @param $id
     * @param $token
     * @return bool
     * @throws \Exception
     */
    private function update_token($token)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy([
            'Token' => $token
        ]);
        if (!$user) {
            throw $this->createNotFoundException(
                'Not found'
            );
        }
        $rd = bin2hex(random_bytes(40));
        $user->setToken($rd);
        $entityManager->flush();
        return $rd;
    }

    /**
     * @return DateTime
     */
    private function current_location()
    {

        $current_time = new DateTime();
        $current_time->format('Y-m-d H:i:s');


        return $current_time;

        /*        $entityManager = $this->getDoctrine()->getManager();
                $user = $entityManager->getRepository(Event::class)->findOneBy([
                    'Token' => $token
                ]);*/


//        on return {
//   "date": "",
//   "location": "Salle 7"
//}
    }


}
