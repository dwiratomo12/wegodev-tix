<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Menu extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $active;

    public function __construct($active)
    {
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.menu', [
            'active' => $this->active
        ]);
    }

    public function list()
    {
        return [
            [
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'icon'  => 'fas fa-tachometer-alt'
            ],
            [
                'label' => 'Room',
                'route' => 'dashboard.rooms',
                'icon'  => 'fas fa-door-closed'
            ],
            [
                'label' => 'Transaction',
                'route' => 'dashboard.transactions',
                'icon'  => 'fas fa-hands-helping'
            ],
            [
                'label' => 'History',
                'route' => 'dashboard.histori.admin',
                'icon'  => 'fas fa-history'
            ],
            [
                'label' => 'Users',
                'route' => 'dashboard.mahasiswa',
                'icon'  => 'fas fa-users'
            ],
        ];
    }

    public function mahasiswa()
    {
        return [
            [
                'label' => 'Dashboard',
                'route' => 'dashboard',
                'icon'  => 'fas fa-tachometer-alt'
            ],
            [
                'label' => 'Transaction',
                'route' => 'dashboard.transactions',
                'icon'  => 'fas fa-hands-helping'
            ],
        ];
    }

    public function isActive($label)
    {
        return $label === $this->active;
    }
}