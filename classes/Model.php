<?php

abstract class Model {
    protected static $table = 'table';
    public $id;
    // COMMON METHODS - exactly the same code
    // save, remove, _execute_and_fetch, _execute_and_fetch_all, getById, getAll
    // REQUIRED METHODS - different code currently
    // __construct, _insert, _update, fill,
    // OPTIONAL METHODS - as needed by model
    // User::getByUsername, Location::getAllByUser, Booking::getAllByLocation, Booking::getAllByUser
};
