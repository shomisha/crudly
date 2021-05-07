<?php

public function definition()
{
    return array('title' => $this->faker->unique()->text(255), 'body' => $this->faker->text(63000), 'published_at' => $this->faker->dateTime());
}