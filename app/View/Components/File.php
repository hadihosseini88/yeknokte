<?php

namespace App\View\Components;

use Illuminate\View\Component;

class File extends Component
{
    public $name;
    public $textSpan;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name,$textSpan)
    {
        //
        $this->name = $name;
        $this->textSpan = $textSpan;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.file');
    }
}
