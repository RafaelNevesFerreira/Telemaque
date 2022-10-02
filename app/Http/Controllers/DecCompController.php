<?php

namespace App\Http\Controllers;

use App\Http\Requests\DecCompRequest;

class DecCompController extends Controller
{
    /**
     *
     *  cette méthode est chargée d'afficher la page avec les inputs pour l'insertion des entrées
     *
     */
    public function decomp_comp()
    {
        return view("decom_comp");
    }

    /**
     *
     *  cette méthode est chargée faire de la compression de la string
     */

    public function compression($subject)
    {
        return preg_replace_callback('/(.)\1{1,}/', function (array $match) {
            return $match[0][0] . strlen($match[0]);
        }, trim($subject));
    }

    /**
     *
     *  cette méthode est chargée returner la compression du suject à la view
     */

    public function return_compression(DecCompRequest $request)
    {
        $value = $this->compression($request->subject);

        return redirect()->back()->with("message", "vous avez choisi de faire la compression de $request->subject donc le résultat est $value");
    }

    /**
     *
     *  cette méthode est chargée faire de la decompression de la string
     */
    public function decompression($subject)
    {
        return preg_replace_callback('/(\D)(\d+)/', function (array $match) {
            return str_repeat($match[1], (int) $match[2]);
        }, trim($subject));
    }

    /**
     *
     *  cette méthode est chargée returner la compression du suject à la view
     */

    public function return_decompression(DecCompRequest $request)
    {
        $value = $this->decompression($request->subject);

        return redirect()->back()->with("message", "vous avez choisi de faire la decompression de $request->subject donc le résultat est $value");
    }
}
