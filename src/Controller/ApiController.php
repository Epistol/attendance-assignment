<?php

namespace App\Controller;

use App\Entity\User;
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
    public function login(Request $request){
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
     */
    public function refreshToken(Request $request){
        $token = $request->get('Token');


        if($id = $this->is_user_logged($token) != false){
            $token = $this->update_token($id,$token);
            if(!$token){
                throw $this->createNotFoundException(
                    "Perdu", 404
                );
            }
            return new JsonResponse($token);
        }
        else {
            throw $this->createNotFoundException(
                "Perdu", 404
            );
        }


    }

    /**
     * @param $token
     * return JsonResponse
     */
    private function is_user_logged($token){
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy([
            'Token' => $token
        ]);

        if (!$user) {
            return new JsonResponse(false);
        }
        return new JsonResponse($user);
    }

    /**
     * @param $id
     * @param $token
     * return JsonResponse
     */
    private function update_token($id, $token){

        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy([
            'id' => $id,
            'Token' => $token
        ]);
        if($user){
            try {
                $rd = bin2hex(random_bytes(40));
            } catch (\Exception $e) {
            }
            $user->setToken($rd);

            return new JsonResponse(true);
        }
            return new JsonResponse(false);

    }

    public function getLocation($token){
        if($this->is_user_logged($token)){
            
        }
    }


}
