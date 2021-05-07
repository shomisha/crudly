<?php

public function createAndAuthenticateUser() : User
{
    $user = User::factory()->create();
    $this->be($user);
    return $user;
}