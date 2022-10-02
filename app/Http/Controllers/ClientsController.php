<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Repositories\Contracts\ClientsRepositoryInterface;

class ClientsController extends Controller
{
    public array $valid_extension;

    public function __construct(public ClientsRepositoryInterface $clients)
    {
        $this->valid_extension = ["csv", "xlsx"];
    }

    /**
     *
     *  cette méthode est chargée d'afficher la page de la liste des clients
     *
     */
    public function all()
    {
        //récupèrer tous les clients et les stocker dans la variable $clients.
        //en sachant que nous avons 50 000 enregistrements dans notre table,
        //il n'est pas possible de les obtenir tous au même temps, nous n'en obtenons donc que 20 par page
        $clients = $this->clients->paginate(20);

        //return notre view avec les clients
        return view("clients", compact("clients"));
    }

    /**
     *
     *  cette méthode est chargée de télécharger un fichier csv ou xlsx, permettant ainsi d'exporter les données des clients
     *
     */
    public function download($extension)
    {

        //nous prenons donc tous les clients
        $clients = $this->clients->get();

        //vérifions que l'extension demandée par l'utilisateur est valide ou non
        //les extensions valides se trouvent dans l'attribut $valid_extension
        //si l'extension demandée par l'utilisateur ne correspond à aucune des extensions présentes dans notre tableau,
        //nous redirigeons le client avec le message d'erreur
        if (!in_array($extension, $this->valid_extension)) {
            return redirect()->back()->withErrors("L'extension que vous souhaitez n'est pas disponible actuellement");
        }

        //une fois les validations effectuées avec succès, nous téléchargeons le fichier avec l'extension demandée par l'utilisateur
        return (new FastExcel($clients))->download("clients-" . date("d-m-YH:is") . ".$extension", function ($client) {
            return [
                'Nom' => $client->last_name,
                'Prénom' => $client->first_name,
                "Téléphone" => $client->phone_number,
                "Date de naissance" => date("d-m-Y", strtotime($client->birth_date))
            ];
        });
    }

    /**
     *
     *  cette méthode est chargée de télécharger un fichier d'export des données des clients,
     *  avec uniquement les paramètres que l'on veut exporter
     *
     */
    public function get_by_param()
    {
        //on met les champs exportables dans un tableau
        $valid_params = ["last_name", "first_name", "phone_number", "birth_date"];

        //on vérifie que les champs passés par la méthode GET ne sont pas vides
        //si les paramètres sont vides, on redirige le utilisateur avec le message d'erreur
        if (empty(request("params"))) {
            return redirect()->back()->withErrors("Vous devez sélectionner au moins un champ à récupérer");
        }

        //on indexe le tableau numériquement
        $params = array_values(request("params"));

        //on fait une boucle for qui va vérifier que chaque valeur du tableau est un champ exportable
        //si le champ n'est pas présent dans la liste des champs autorisés(tableau $valid), on redirige le client avec le message d'erreur
        for ($i = 0; $i < count($params); $i++) {
            if (!in_array($params[$i], $valid_params)) {
                return redirect()->back()->withErrors("un des champs sélectionnés n'est pas valide");
            }
        }

        //une fois que toutes les validations ont été faites avec succès

        //on récupère tous les clients, mais seulement les champs demandés par l'utilisateur
        $clients = $this->clients->get_param($params);

        //on télécharge le fichier
        return (new FastExcel($clients))->download("clients-" . date("d-m-YH:is") . ".csv");
    }

    /**
     *
     *  cette méthode se charge de ne renvoyer que les clients nés entre deux certaines dates, ou une précise
     *
     */
    public function where_birth_date_between()
    {
        //on vérifie que les dates passés par la méthode GET ne sont pas vides
        //si les dates sont vides, on redirige le utilisateur avec le message d'erreur
        if (empty(request("date"))) {
            return redirect()->back()->withErrors("Vous devez sélectionner une date de naissence");
        }

        //on indexe le tableau numériquement
        $date = array_values(request("date"));

        //nous vérifions que les dates sont bien au format souhaité
        //si les dates ne sont pas au bon format, on redirige le utilisateur avec le message d'erreur
        if (!$this->date_validate($date[0]) || !$this->date_validate($date[1])) {
            return redirect()->back()->withErrors("La date n'est pas au bon format.");
        };

        //on Trie le tableau par ordre croissant
        sort($date);

        //nous prenons les clients nés entre les dates
        $clients = $this->clients->whereBetween($date[0], $date[1]);

        //s'il n'y a pas de clients nés entre ces dates
        //on redirige le utilisateur avec le message d'erreur
        if (!count($clients)) {
            return redirect()->back()->withErrors("Aucun client n'est né entre " . date("d-m-Y", strtotime($date[0])) . " et " . date("d-m-Y", strtotime($date[1])));
        }

        //nous téléchargeons le fichier avec les données des clients nés entre ces dates
        return (new FastExcel($clients))->download("clients-" . date(now()) . ".xlsx", function ($user) {
            return [
                'Nom' => $user->last_name,
                'Prénom' => $user->first_name,
                "Téléphone" => $user->phone_number,
                "Date de naissance" => date("d-m-Y", strtotime($user->birth_date))
            ];
        });
    }


    /**
     *
     *  cette méthode se charge de s'assurer que les dates sont dans le bon format
     *
     */
    public function date_validate($date)
    {
        //pour le faire j'ai choisi d'utiliser les expressions régulières
        return preg_match("/^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $date);
    }
}
