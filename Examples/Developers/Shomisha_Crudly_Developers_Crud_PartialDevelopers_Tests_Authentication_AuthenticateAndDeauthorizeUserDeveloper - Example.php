<?php

$user = $this->createAndAuthenticateUser();
$this->deauthorizeUser($user);