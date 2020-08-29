<?php


namespace JobBundle\Service\Encryption;




class EncryptionService implements EncryptionServiceInterface
{

    public function hashPassword(string $password): string
    {

        return md5($password);

    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password,$hash);
    }
}