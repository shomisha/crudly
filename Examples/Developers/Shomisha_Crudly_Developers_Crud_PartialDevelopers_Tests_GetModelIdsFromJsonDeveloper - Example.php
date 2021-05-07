<?php

$responsePostIds = collect($response->json('data'))->pluck('id');