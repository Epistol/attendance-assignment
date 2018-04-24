<?php

namespace App\Controller;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @ORM\Entity
 * @ORM\Table(name="monster_controller")
 */
class MonsterController extends Controller
{

    public function index(MonsterController $monsterController): Response
    {
        return $this->render('monster/index.html.twig', ['monster' => $monsterController->findAll()]);
    }




}
