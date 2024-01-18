<?php

namespace Madtechservices\MadminCore\app\View\Components;

use Illuminate\View\Component;

class EmailNotification extends Component
{
    public $background;

    public $type;

    public $title;

    public $message;

    public $text_color;

    public $button_href;

    public $button_text;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $background = '#FFC402',
        $type = 'WARNING',
        $title = '',
        $message = '',
        $textColor = '#7A5200',
        $buttonHref = '',
        $buttonText = '',
    ) {
        $this->background = $background;
        $this->type = $type;
        $this->title = $title ?? '';
        $this->message = $message ?? '';
        $this->text_color = $textColor;
        $this->button_href = $buttonHref;
        $this->button_text = $buttonText;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('madmin-core::email.components.notification');
    }
}
