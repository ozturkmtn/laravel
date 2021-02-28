<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Header extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $title;
    public $fname;
    public $leName;
    public function __construct($title, $name = null, $lastName = null)
    {
        //
        $this->title = $title;
        $this->fname = $name;
        $this->leName = $lastName;
    }

    public function robot()
    {
        return 'ROBOT!!!';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.header');
    }
}
