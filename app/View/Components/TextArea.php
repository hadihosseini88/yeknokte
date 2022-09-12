<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TextArea extends Component
{
    public $name;
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $placeholder)
    {
        //
        $this->name = $name;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.text-area');
    }
}
