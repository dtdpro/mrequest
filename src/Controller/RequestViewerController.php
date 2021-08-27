<?php

namespace App\Controller;

use App\Entity\Bin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RequestViewerController extends AbstractController
{
    #[Route('/view/{id}', name: 'bin_view')]
    public function view($id): Response
    {
        $binRepo = $this->getDoctrine()->getRepository(Bin::class);
        $bin = $binRepo->findOneBy(['ExtId'=>$id]);

        return $this->render('request_viewer/view.html.twig', [
            'bin' => $bin
        ]);
    }
}
