<?php

namespace App\Controller;

use App\Entity\Bin;
use http\Cookie;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RequestViewerController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function home(): Response
    {
        return $this->render('request_viewer/home.html.twig', []);
    }

    #[Route('/create', name: 'bin_create')]
    public function create(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $bin = new Bin();
        $bin->setExtId(Uuid::uuid4());

        $entityManager->persist($bin);
        $entityManager->flush();

        return $this->redirectToRoute('bin_view', ['id' => $bin->getExtId()]);
    }

    #[Route('/view/{id}', name: 'bin_view')]
    public function view($id): Response
    {
        $binRepo = $this->getDoctrine()->getRepository(Bin::class);
        $bin = $binRepo->findOneBy(['ExtId'=>$id]);

        $viewUrl = $this->generateUrl('request_bin_record', ['id' => $bin->getExtId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return $this->render('request_viewer/view.html.twig', [
            'bin' => $bin,
            'viewUrl' => $viewUrl
        ]);
    }
}
