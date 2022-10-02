<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientsTest extends TestCase
{
    /**
     *
     *  ce test vérifie que la page client est renvoyée avec succès
     * @return void
     */
    public function test_return_client_page()
    {
        $response = $this->get('/download/csv');

        $response->assertStatus(200);
    }

    /**
     *
     *  ce test vérifie que la méthode de download n'accepte que les paramètres present dans tableau  $extension
     * @return void
     */
    public function test_if_file_extension_are_not_correct()
    {
        $response = $this->get('/download/vbs');

        //avec status 302, nous sommes sûrs que la redirection a été effectuée avec
        //succès, car si l'extension n'existe pas, le controller redirigera l'utilisateur avec l'erreur
        $response->assertStatus(302);
    }

    /**
     *
     *  ce test est chargée de s'assurer que seuls les paramètres présents dans le tableau $valid_params peuvent être acceptés
     * @return void
     */
    public function test_the_parameter_is_not_valid_in_the_get_by_params_method_fail()
    {

        //nous envoyons la requête avec les paramètres que nous voulons récupérer
        $response = $this->get(route(
            "get_by_param",
            [
                "params[1]" => "first_name",
                "params[2]" => "invalid_param",
            ]
        ));

        //avec status 302, nous sommes sûrs que la redirection a été effectuée avec
        //succès, car si le paramètre n'existe pas dans le tableau $valid_params,
        //le controller redirigera l'utilisateur avec l'erreur

        $response->assertStatus(302);
    }


    /**
     *
     *  ce test est chargée de s'assurer que le $parametre ne peut pas être vide
     * @return void
     */
    public function test_the_parameter_can_not_be_empty_in_the_get_by_params_method_work()
    {

        //nous envoyons la requête avec le paramètre que nous voulons récupérer
        $response = $this->get(route(
            "get_by_param",
            [
                "params[1]" => "",
            ]
        ));

        //avec status 302, nous sommes sûrs que la redirection a été effectuée avec
        //succès, ce qui signifie que la validation a été effectuée avec succès
        // car si le paramètre est vide, le controller redirigera l'utilisateur avec l'erreur

        $response->assertStatus(302);
    }



    /**
     *
     *  ce test est chargée de s'assurer que les $parametres(les dates entre lesquelles on veut chercher) ne peuvent pas être vides
     * @return void
     */
    public function test_the_parameters_dates_can_not_be_empty_in_where_birth_date_between_method()
    {
        //nous envoyons la requête avec les paramètres(les dates),
        // pour récupérer les clients nés entre ces paramètres (dates)
        $response = $this->get(route(
            "where_birth_date_between",
            [
                "date[1]" => "",
                "date[2]" => "2000-10-12"
            ]
        ));

        //avec status 302, nous sommes sûrs que la redirection a été effectuée avec
        //succès, ce qui signifie que la validation a été effectuée avec succès
        // car si un des paramètres ,ou les deux, sont vides, le controller redirigera l'utilisateur avec l'erreur

        $response->assertStatus(302);
    }


    /**
     *
     *  ce test est chargée de s'assurer que la validation du format de la date sera effectuée avec succès
     * @return void
     */
    public function test_the_date_validate_method()
    {
        $response = $this->get(route(
            "where_birth_date_between",
            [
                "date[0]=2000-10-103",
                "date[1]=2032-10-13"
            ]
        ));

        //avec status 302, nous sommes sûrs que la redirection a été effectuée avec
        //succès, ce qui signifie que la validation a été effectuée avec succès
        // car si un des paramètres ,ou les deux, ne respectent pas le format requis pour les dates,
        //le controller redirigera l'utilisateur avec l'erreur

        $response->assertStatus(302);
    }

    /**
     *
     *  ce test est chargée de s'assurer que la validation de l'existence de clients
     *  nés entre les dates passées comme paramétres dans la base de données
     * @return void
     */
    public function test_verify_that_no_client_was_born_in_that_year()
    {
        //nous envoyons la requête avec les paramètres(les dates),
        // pour récupérer les clients nés entre ces dates
        $response = $this->get(route(
            "where_birth_date_between",
            [
                "date[0]=2025-10-13",
                "date[1]=2032-10-13"
            ]
        ));

        //avec status 302, nous sommes sûrs que la redirection a été effectuée avec
        //succès, ce qui signifie que la validation a été effectuée avec succès
        // car s'il n'y a pas de clients nés entre ces dates,
        //le controller redirigera l'utilisateur avec l'erreur
        $response->assertStatus(302);
    }
}
