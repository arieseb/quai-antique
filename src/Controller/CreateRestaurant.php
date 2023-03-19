<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CreateRestaurant extends AbstractController
{
    //#[Route(path: '/create', name: 'app_create')]
    public function new(Connection $connection) :void
    {

        $sql = '
            INSERT INTO restaurant 
            (name, max_guests, business_days, opening_hour, closing_hour, current_guests)
            VALUES ("Le Quai Antique", 32, "a:5:{i:0;s:5:"Mardi";i:1;s:8:"Mercredi";i:2;s:5:"Jeudi";i:3;s:8:"Vendredi";i:4;s:6:"Samedi";}", "12:00", "15:00", 0)
            ';
        $stmt = $connection->prepare($sql);
        $stmt->executeQuery();

    }
}