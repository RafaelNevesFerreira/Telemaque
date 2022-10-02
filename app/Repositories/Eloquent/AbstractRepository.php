<?php

namespace App\Repositories\Eloquent;

class AbstractRepository
{
    /**
     *
     *  cette méthode est chargée de récupérer tous les enregistrements de la table
     *
     */
    public function get()
    {
        return $this->model::get();
    }

    /**
     *
     *  cette méthode est chargée de récupérer les enregistrements de la table, mais seulement un certain nombre par page
     *
     */
    public function paginate($per_page)
    {
        return $this->model::paginate($per_page);
    }


    /**
     *
     *  cette méthode est chargée de faire une recherche dans la table,
     *  elle reçoit en paramètre la colonne à consulter et la valeur que l'on veut obtenir
     */
    public function where($colum, $value)
    {
        return $this->model::where($colum, $value)->get();
    }
}
