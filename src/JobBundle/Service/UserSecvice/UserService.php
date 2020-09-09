<?php


namespace JobBundle\Service\UserSecvice;


use JobBundle\Repository\UserRepository;
use JobBundle\Entity\User;

class UserService implements UserServiceIterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        $this->userRepository->create($user);
        return true;
    }

    public function edit(): bool
    {
        // TODO: Implement edit() method.
    }

    public function delete(): bool
    {
        // TODO: Implement delete() method.
    }

    public function show(): bool
    {
        // TODO: Implement show() method.
    }



    public function findall(): ?array
    {
    return $this->userRepository->findAll();
    }

    public function findOneById(int $id): ?User
    {
    return $this->userRepository->findOneBy(['id'=>$id]);
    }
}