<?php

private function authorizeUser(User $user) : void
{
    throw IncompleteTestException::provideUserAuthorization();
}