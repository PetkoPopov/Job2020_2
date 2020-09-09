<?php


namespace JobBundle\Service\PlanService;


use JobBundle\Entity\Plan;
use JobBundle\Repository\PlanRepository;

class PlanService implements PlanServiceInterface
{
    /**
     * @var PlanRepository
     */
    private $repository;
    public function __construct(PlanRepository $repository)
    {
        $this->repository=$repository;
    }

    public function findOne(int $id): ?Plan
    {
        return $this->repository->findOneBy($id);
    }

    public function findAll(): ?array
    {
        return $this->repository->findAll();
    }

    public function edit(int $id): bool
    {

    }

    public function create(): bool
    {
        //to do
    }

    public function delete(int $id): bool
    {
        // TODO: Implement delete() method.
    }

}