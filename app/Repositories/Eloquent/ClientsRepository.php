<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\ClientsRepositoryInterface;
use App\Models\Clients;

class ClientsRepository extends AbstractRepository implements ClientsRepositoryInterface
{
    public function __construct(public Clients $model)
    {
    }

    /**
     *
     *  cette méthode est chargée de retourner que les paramètres passés dans la variable $param
     *
     */
    public function get_param($param)
    {
        return $this->model::get($param);
    }

    /**
     *
     *  cette méthode est chargée de faire une recherche spécifiquement dans la colonne
     *  bith_date, entre les dates passées en paramètre
     *
     */
    public function whereBetween($start, $end)
    {
        return $this->model::whereBetween("birth_date", [date("Y-m-d", strtotime($start)), date("Y-m-d", strtotime($end))])->get();
    }
}
