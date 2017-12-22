<?php
function current_db_driver()
{
    $connection = config('database.default');
    return config("database.connections.{$connection}.driver");
}