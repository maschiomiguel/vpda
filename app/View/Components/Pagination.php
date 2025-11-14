<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Pagination extends Component
{
	/**
	 * Create a new component instance.
	 *
	 * @return void
	 */
	public function __construct(
		protected LengthAwarePaginator $list,
	)
	{
		//
	}

	/**
	 * Get the view / contents that represent the component.
	 *
	 * @return \Illuminate\Contracts\View\View|\Closure|string
	 */
	public function render()
	{
		return $this->list->links('components.pagination');
	}
}
