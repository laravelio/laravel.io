<?php

namespace Tests;

use Faker\Factory;

trait FakesData
{
    /**
     * @var \Faker\Generator
     */
    public $faker;

    /**
     * @before
     */
    public function setupFaker()
    {
        $this->faker = Factory::create();
    }

    /**
     * @after
     */
    public function unsetFaker()
    {
        $this->faker = null;
    }
}
