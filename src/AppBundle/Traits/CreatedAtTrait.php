<?php
/*
 * This file is part of a Geniuses project.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace AppBundle\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait CreatedAtTrait
 */
trait CreatedAtTrait
{
    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetimetz")
     */
    private $createdAt;

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
