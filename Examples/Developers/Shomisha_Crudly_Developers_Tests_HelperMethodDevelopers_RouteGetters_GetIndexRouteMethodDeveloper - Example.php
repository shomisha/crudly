<?php

private function getIndexRoute() : string
{
    throw IncompleteTestException::missingRouteGetter('index');
}