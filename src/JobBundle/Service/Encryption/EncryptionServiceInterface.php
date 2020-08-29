<?php


namespace JobBundle\Service\Encryption;


interface EncryptionServiceInterface
{
    public function hashPassword(string $password): string;
    public function verifyPassword(string $password,string $hash):bool;

}