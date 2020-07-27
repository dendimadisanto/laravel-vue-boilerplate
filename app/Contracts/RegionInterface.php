<?php

namespace App\Contracts;


interface RegionInterface
{
    public function get($request);

    public function save($request);

    public function delete($request);

    public function find($id);
}