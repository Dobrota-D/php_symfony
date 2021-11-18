<?php

namespace App\Service;

use App\Entity\Token;
use App\Entity\Tricount;
use Doctrine\ORM\EntityManagerInterface;

class TokenService
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * Create a new TokenService instance.
     *
     * TokenService constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Generate a new token
     *
     * @throws \Exception
     * @return string
     */
    public function generateToken(): string
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }

    /**
     * Create a new token for a specific Tricount
     *
     * @param Tricount $tricount
     * @throws \Exception
     * @return void
     */
    public function createTricountToken(Tricount $tricount): void
    {
        $token = new Token();

        $token->setTricountId($tricount);
        $token->setToken($this->generateToken());

        $this->entityManager->getRepository(Token::class);
        $this->entityManager->persist($token);
        $this->entityManager->flush();
    }
}
