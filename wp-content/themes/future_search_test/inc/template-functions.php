<?php

use FS\Theme;
use FS\Likes;

function likes() {
    return Likes::instance();
}
function theme() {
    return Theme::instance();
}