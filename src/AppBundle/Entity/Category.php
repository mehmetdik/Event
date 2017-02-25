<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryName", type="string", length=255)
     */
    private $categoryName;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserCategory", mappedBy="Category")
     */
    private $userCategory;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set categoryName
     *
     * @param string $categoryName
     *
     * @return Category
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * Get categoryName
     *
     * @return string
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }







    /**
     * Add userCategory
     *
     * @param \AppBundle\Entity\UserCategory $userCategory
     * @return Category
     */
    public function addUserCategory(\AppBundle\Entity\UserCategory $userCategory)
    {
        $this->userCategory[] = $userCategory;

        return $this;
    }

    /**
     * Remove userCategory
     *
     * @param \AppBundle\Entity\UserCategory $userCategory
     */
    public function removeUserCategory(\AppBundle\Entity\UserCategory $userCategory)
    {
        $this->userCategory->removeElement($userCategory);
    }

    /**
     * Get userCategory
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserCategory()
    {
        return $this->userCategory;
    }
}

