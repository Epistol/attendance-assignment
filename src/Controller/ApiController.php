<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("login", name="api_login")
     */
    public function login($mail, $psd){
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy([
            'Email' => $mail,
            'Password' => hash(sha512, $psd, true),
        ]);

        if (!$user) {
            throw $this->createNotFoundException(
              "Perdu", 404
            );
        }
        return new JsonResponse($user->getToken());
    }

    /**
     * @Route("refreshToken", name="api_refresh_token")
     */
    public function refreshToken($token){
       if($id = $this->is_user_logged($token) != false){
            $this->update_token($id,$token);
       }
       else {
           return new JsonResponse("Error",404);
       }

    }

    private function is_user_logged($token){
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy([
            'token' => $token
        ]);

        if (!$user) {
            throw $this->createNotFoundException(
                false, 404
            );
        }
        return new JsonResponse($user);
    }

    private function update_token($id, $token){

        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy([
            'id' => $id,
            'token' => $token
        ]);
        if($user){
            try {
                $rd = bin2hex(random_bytes(40));
            } catch (\Exception $e) {
            }
            $user->setToken($rd);
            $user->flush();

            return new JsonResponse(true);
        }
            return new JsonResponse(false);





    }


}
