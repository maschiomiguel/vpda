<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class PlatformScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'metrics' => screens()->metricsQuery(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return config('app.name');
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Logado como ' . auth()->user()->name;
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Acessar o site')
                ->type(Color::SUCCESS())
                ->icon('link')
                ->target('blank')
                ->route('home')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        $metrics = screens()->metricsLayout();

        $max_row = 5;

        $metrics_array = array_map(
            fn ($arr) => Layout::metrics($arr),
            array_chunk($metrics, $max_row, true)
        );

        return $metrics_array;
    }
}
