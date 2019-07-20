<?php
if (!is_active_sidebar('sidebar')) {
    return;
}

dynamic_sidebar('sidebar');
