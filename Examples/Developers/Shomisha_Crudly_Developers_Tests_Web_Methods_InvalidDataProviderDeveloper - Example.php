<?php

public function invalidPostDataProvider()
{
    return array('Title is not a string' => array('title', false), 'Title is missing' => array('title', null), 'Body is not a string' => array('body', 124), 'Body is missing' => array('body', null), 'Published at is not a date' => array('published_at', 'not a date'), 'Published at is in invalid format' => array('published_at', '21.12.2012. at 21:12'), 'Published at is missing' => array('published_at', null));
}