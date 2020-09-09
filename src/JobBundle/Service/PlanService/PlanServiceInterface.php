<?php


namespace JobBundle\Service\PlanService;


use JobBundle\Entity\Plan;
use Symfony\Component\Config\Definition\Exception\Exception;

interface PlanServiceInterface
{
public function findOne(int $id): ?Plan;
public function findAll():?array;
public function edit(int $id): bool;
public function create(): bool;
public function delete(int $id): bool;
}