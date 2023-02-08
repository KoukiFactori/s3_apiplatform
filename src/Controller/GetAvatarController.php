<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetAvatarController extends AbstractController
{
    public function __invoke(User $data): Response
    {
        $avatarStream = $data->getAvatar();
        $userAvatar = stream_get_contents($avatarStream, null, 0);

        return new Response($userAvatar, Response::HTTP_OK, ['Content-Type' => 'image/png']);
    }
}
