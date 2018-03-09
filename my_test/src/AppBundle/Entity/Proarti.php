<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Proarti
 *
 * @ORM\Table(name="Proarti")
 * @ORM\Entity
 */
class Proarti
{
    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="string", length=255, nullable=true)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="project_name", type="string", length=255, nullable=true)
     */
    private $projectName;

    /**
     * @var string
     *
     * @ORM\Column(name="reward", type="string", length=255, nullable=true)
     */
    private $reward;

    /**
     * @var string
     *
     * @ORM\Column(name="reward_quantity", type="string", length=255, nullable=true)
     */
    private $rewardQuantity;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Proarti
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Proarti
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set amount
     *
     * @param string $amount
     *
     * @return Proarti
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set projectName
     *
     * @param string $projectName
     *
     * @return Proarti
     */
    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;

        return $this;
    }

    /**
     * Get projectName
     *
     * @return string
     */
    public function getProjectName()
    {
        return $this->projectName;
    }

    /**
     * Set reward
     *
     * @param string $reward
     *
     * @return Proarti
     */
    public function setReward($reward)
    {
        $this->reward = $reward;

        return $this;
    }

    /**
     * Get reward
     *
     * @return string
     */
    public function getReward()
    {
        return $this->reward;
    }

    /**
     * Set rewardQuantity
     *
     * @param string $rewardQuantity
     *
     * @return Proarti
     */
    public function setRewardQuantity($rewardQuantity)
    {
        $this->rewardQuantity = $rewardQuantity;

        return $this;
    }

    /**
     * Get rewardQuantity
     *
     * @return string
     */
    public function getRewardQuantity()
    {
        return $this->rewardQuantity;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
