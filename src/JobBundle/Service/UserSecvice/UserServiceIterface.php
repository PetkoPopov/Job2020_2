<?php


namespace JobBundle\Service\UserSecvice;


use JobBundle\Entity\User;

interface UserServiceIterface
{
public function create(User $user):bool;
public function edit():bool;
public function delete():bool;
public function show():bool;
public function findall(): ?array;
public function findOneById(int $id): ?User;
}