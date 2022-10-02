<?php

namespace Tests\Feature;

use App\Http\Controllers\DecCompController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DecCompTest extends TestCase
{
    /**
     * ce test est chargée de s'assurer que la méthode compression functionne.
     *
     * @return void
     */
    public function test_method_compression_dont_fail()
    {
        $response = new DecCompController;


        $this->assertEquals($response->compression("abbcccffaaz"), "ab2c3f2a2z");
    }

    /**
     * ce test est chargée de s'assurer que la méthode decompression functionne.
     *
     * @return void
     */
    public function test_method_decompression_dont_fail()
    {
        $response = new DecCompController;

        $this->assertEquals($response->decompression("ab2c3f2a2z"), "abbcccffaaz");
    }

    /**
     * ce test est chargée de s'assurer que la validation de la request functionne.
     *
     * @return void
     */
    public function test_subject_can_not_be_null()
    {
        $response = $this->post(route(
            "compression",
            [
                "subject" => ""
            ]
        ));

        $response->assertSessionHasErrors();
    }

    /**
     * ce test est chargée de s'assurer que la compression est renvoyée .
     *
     * @return void
     */
    public function test_return_the_compression_message_to_my_view()
    {
        $response = $this->post(route(
            "compression",
            [
                "subject" => "abbcccffaaz"
            ]
        ));

        //status 302 car par defaut le method redirect de laravel retourne le status code 302
        $response->assertStatus(302);
    }

    /**
     * ce test est chargée de s'assurer que la décompression est renvoyée .
     *
     * @return void
     */
    public function test_return_the_decompression_message_to_my_view()
    {
        $response = $this->post(route(
            "decompression",
            [
                "subject" => "ab2c3f2a2z"
            ]
        ));

        //status 302 car par defaut le method redirect de laravel retourne le status code 302
        $response->assertStatus(302);
    }
}
