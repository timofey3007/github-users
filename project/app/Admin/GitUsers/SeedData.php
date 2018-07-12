<?php

namespace App\Admin\GitUsers;

/**
 * Class SeedData
 * @package App\Admin\GitUsers
 */
/**
 * Class SeedData
 * @package App\Admin\GitUsers
 */
class SeedData
{
    /**
     * @var int
     */
    private $since;

    /**
     * @var int
     */
    private $per_page = 100;

    /**
     * @var
     */
    private $max_seed_count = 1000;

    /**
     * SeedData constructor.
     *
     * @param int $page
     * @return $this
     */
    public function __construct($page = 1)
    {
        $this->since = $page;

        // Block creating new queue for seeding.
        resolve('helper')->modifySeedQueueStatus(true);

        return $this;
    }

    /**
     * @param int $since
     */
    public function setSince(int $since): void
    {
        $this->since = $since;
    }

    /**
     * @return int
     */
    public function getSince(): int
    {
        return $this->since > 0 ? $this->since : 1;
    }

    /**
     * Just incrementing seed count value.
     */
    public function incrementSince()
    {
        $this->setSince($this->getSince() + 1);
    }

    /**
     * @param mixed $max_seed_count
     */
    public function setMaxSeedCount($max_seed_count): void
    {
        $this->max_seed_count = $max_seed_count;
    }

    /**
     * @return mixed
     */
    public function getMaxSeedCount()
    {
        return $this->max_seed_count;
    }

    /**
     * @return mixed
     */
    public function getPerPage()
    {
        return $this->per_page;
    }

    /**
     * @param mixed $per_page
     */
    public function setPerPage($per_page): void
    {
        $this->per_page = $per_page;
    }

    /**
     * @return bool
     */
    public function canGoFurther()
    {
        return $this->getSince() <= $this->getMaxSeedCount();
    }
}