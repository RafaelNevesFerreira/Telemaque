<?php

namespace App\Repositories\Contracts;


interface ClientsRepositoryInterface
{
    public function get();
    public function paginate($per_page);
    public function get_param($param);
    public function whereBetween($start, $end);
    public function where($colum, $value);
}
