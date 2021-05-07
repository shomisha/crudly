<?php

$response = $this->from(route('posts.index'))->post(route('posts.store'), $data);