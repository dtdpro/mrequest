<?php

namespace App\Controller;


use App\Entity\Bin;
use App\Entity\BinEntry;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RequestRecorderController extends AbstractController
{
    #[Route('/r/{id}', name: 'request_bin_record')]
    public function record($id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $binRepo = $this->getDoctrine()->getRepository(Bin::class);
        $bin = $binRepo->findOneBy(['ExtId'=>$id]);

        $headers = $request->headers->all();
        $body = $request->getContent();
        $method = $request->getMethod();

        $newEntry = new BinEntry();

        $newEntry->setBin($bin);
        $newEntry->setEntryHeaders($headers);
        $newEntry->setEntryBody($body);
        $newEntry->setEntryMethod($method);

        $entityManager->persist($newEntry);
        $entityManager->flush();

        return $this->json([]);
    }

    #[Route('/c', name: 'request_bin_create')]
    public function create(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $bin = new Bin();
        $bin->setExtId(Uuid::uuid4());

        $entityManager->persist($bin);
        $entityManager->flush();

        return $this->json([
            'id' => $bin->getId(),
            'extId' => $bin->getExtId(),
            'url' => $this->generateUrl('request_bin_record', ['id' => $bin->getExtId()], UrlGeneratorInterface::ABSOLUTE_URL)
        ]);
    }

    #[Route('/v/{id}', name: 'request_bin_view')]
    public function view($id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $binRepo = $this->getDoctrine()->getRepository(Bin::class);
        $bin = $binRepo->findOneBy(['ExtId'=>$id]);

        $entries = [];
        foreach ($bin->getBinEntries() as $entry) {
            $entries[] = $entry;
        }

        return $this->json($entries);
    }
}
