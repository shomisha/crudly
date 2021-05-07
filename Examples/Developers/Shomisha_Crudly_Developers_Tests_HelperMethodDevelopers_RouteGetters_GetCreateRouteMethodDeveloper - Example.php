<?php

private function getCreateRoute() : string
{
    throw IncompleteTestException::missingRouteGetter('create');
}