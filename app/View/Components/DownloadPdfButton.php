<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DownloadPdfButton extends Component
{
    public $route;
    public $id;
    public $text;

    /**
     * Crear una nueva instancia del componente.
     */
    public function __construct($route, $id, $text = 'Descargar PDF')
    {

        $this->route = $route;
        $this->id = $id;
        $this->text = $text;
    }

    /**
     * Renderizar la vista del componente.
     */
    public function render()
    {
        return view('components.download-pdf-button');
    }
}
