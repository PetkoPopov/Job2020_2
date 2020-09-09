<?php


namespace JobBundle\Service\FurloughService;


use JobBundle\Entity\Furlough;
use JobBundle\Repository\FurloughRepository;

interface FurloughServiceInterface
{
public function findOne(int $id): ?Furlough;
public function findAll():?array;
public function createNew(Furlough $furlough): Furlough;
public function edit(): bool;
public function delete(Furlough $furlough): bool;


}