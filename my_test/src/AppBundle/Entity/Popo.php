<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\ArrayAccess\ArrayAccess;


/**
 * Popo
 *
 * @ORM\Table(name="popo")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FilesRepository")
 */
class Popo
{
    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\File(mimeTypes={ "text/plain" })
     */
    protected $popo;

    public function getPopo()
    {
        return $this->popo;
    }

    public function setPopo($popo)
    {
        $this->popo = $popo;
        return $this;
    }
}
