<?php

namespace Madtechservices\MadminCore\app\View\Components;

use Illuminate\View\Component;

class EmailButton extends Component
{
    public $href;

    public $text;

    public $background;

    public $textColor;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($href, $text, $background = '#0067f4', $textColor = '#fff')
    {
        $this->href = $href;
        $this->text = $text;
        $this->background = $background;
        $this->textColor = $textColor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('madmin-core::email.components.button');
    }
}
