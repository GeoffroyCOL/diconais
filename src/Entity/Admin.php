<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
class Admin extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected int $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->roles = ['ROLE_ADMIN'];
    }
}
