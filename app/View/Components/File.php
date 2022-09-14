<?php

namespace App\View\Components;

use Illuminate\View\Component;

class File extends Component
{
    public $name;
    public $textSpan;
    /**
     * @var null
     */
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $textSpan, $value = null)
    {
        //
        $this->name = $name;
        $this->textSpan = $textSpan;
        $this->value = $value;
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
