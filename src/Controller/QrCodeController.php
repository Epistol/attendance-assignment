<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Endroid\QrCode\QrCode;


class QrCodeController extends Controller
{
    /**
     * @Route("/qr/code", name="qr_code")
     */
    public function index()
    {
        $message =  'HETIC 2018';

        return $this->render('qr_code/index.html.twig', [
            'controller_name' => 'QrCodeController', 'message' => $message
        ]);
    }

    /**
     * @Route("/qr/code/{slug}", name="qr_code_show")
     */
    public function show($slug)
    {

        return $this->render('qr_code/index.html.twig', [
            'controller_name' => 'QrCodeController', 'message' => $slug
        ]);
    }

}
