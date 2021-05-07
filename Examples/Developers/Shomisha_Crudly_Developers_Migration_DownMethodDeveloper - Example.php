<?php

public function down()
{
    Schema::dropIfExists('posts');
}