<?php


namespace JobBundle\Service\FurloughService;


use JobBundle\Entity\Furlough;
use JobBundle\Repository\FurloughRepository;

class FurloughService implements FurloughServiceInterface
{

    /**
     * @var FurloughRepository
     */
    private $furRepository;
    public function __construct(FurloughRepository $furlough)
    {
        $this->furRepository=$furlough;
    }

    public function findOne(int $id): ?Furlough
    {
        return
        $this->furRepository->findOneBy(['id'=>$id]);
    }

    public function findAll(): ?array
    {
  return
  $this->furRepository->findAll();
    }

    public function createNew(Furlough $furlough): Furlough
    {
        return $this->furRepository->createNew($furlough);
    }

    public function edit(): bool
    {
        // TODO: Implement edit() method.
    }

    public function delete(Furlough $furlough): bool
    {
        return
        $this->furRepository->delete($furlough);
    }
}