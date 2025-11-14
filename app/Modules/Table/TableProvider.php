<?php

namespace App\Modules\Table;

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Cell;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\TD;
use Illuminate\Support\Traits\Macroable;

class TableProvider extends ServiceProvider
{
    // Reordenar ✅
    // Imagem
    // Titulo
    // Switch
    // Actions ✅
    // Data ✅
    // Tags
    // Badge ✅

    public function boot()
    {
        $this->columns();
    }

    public function columns()
    {
        TD::macro('checkbox', function ($permissionSlug = '') {
            $this->align(TD::ALIGN_CENTER);
            $this->cantHide();
            $this->width('1%');
            $this->render(function ($model) {
                if(!$model->canDelete()){
                    return '';
                }
                return CheckBox::make('select-all[]')
                    ->class('form-check-input data-select-all-reports')
                    ->value($model->custom_id ?? $model->id)
                    ->checked(false);
            });
            if ($permissionSlug && !hasAuth("platform.$permissionSlug.delete")) {
                $this->canSee(false);
            }
            return $this;
        });
        
        TD::macro('sortable', function ($url, $permissionSlug = null) {
            $this->align(TD::ALIGN_CENTER);
            $this->cantHide();
            $this->width('1%');
            $this->render(function ($model) use ($url) {
                if ($model->orderColumn) {
                    return view('restrita.sortable', [
                        'order' => $model->order,
                        'id' => $model->id,
                        'url' => $url,
                    ]);
                }
            });
            if (!$permissionSlug) {
                $permissionSlug = $url;
            }
            if (!hasAuth("platform.$permissionSlug.edit")) {
                $this->canSee(false);
            }
            return $this;
        });

        TD::macro('toggleActive', function ($url, $permissionSlug = null) {
            $this->align(TD::ALIGN_CENTER);
            $this->cantHide();
            $this->width('1%');
            $this->render(function ($model) use ($url) {
                if ($model->activeColumn) {
                    return view('restrita.toggle-active', [
                        'checked' => $model->active,
                        'id' => $model->id,
                        'column' => $this->name,
                        'url' => $url,
                    ]);
                }
            });
            if (!$permissionSlug) {
                $permissionSlug = $url;
            }
            if (!hasAuth("platform.$permissionSlug.edit")) {
                $this->canSee(false);
            }
            return $this;
        });

        TD::macro('toggleActiveSection', function ($url, $permissionSlug = null) {
            $this->align(TD::ALIGN_CENTER);
            $this->cantHide();
            $this->width('1%');
            $this->render(function ($model) use ($url) {
                if ($model->activeColumn) {
                    return view('restrita.toggle-active', [
                        'checked' => $model->active_section,
                        'id' => $model->id,
                        'column' => $this->name,
                        'url' => $url,
                    ]);
                }
            });
            if (!$permissionSlug) {
                $permissionSlug = $url;
            }
            if (!hasAuth("platform.$permissionSlug.edit")) {
                $this->canSee(false);
            }
            return $this;
        });

        TD::macro('toggleFeatured', function ($url) {
            $this->align(TD::ALIGN_CENTER);
            $this->cantHide();
            $this->width('1%');
            $this->render(function ($model) use ($url) {
                if ($model->activeColumn) {
                    return view('restrita.toggle-active', [
                        'checked' => $model->featured,
                        'id' => $model->id,
                        'column' => $this->name,
                        'url' => $url,
                    ]);
                }
            });
            return $this;
        });

        TD::macro('boolean', function () {
            $column = $this->column;
            $this->align(TD::ALIGN_CENTER);
            $this->cantHide();
            $this->width("1%");
            $this->render(function ($model, $loop) use ($column) {
                $boolean = boolval($model->$column ?? false);
                return Link::make('')
                    ->icon($boolean ? "check" : "close")
                    ->class('pe-none d-inline-flex align-items-center fs-5 ' . ($boolean ? "text-success" : "text-danger"));
            });
            return $this;
        });

        TD::macro('badge', function ($color = "dark") {
            $column = $this->column;
            $this->align(TD::ALIGN_CENTER);
            $this->cantHide();
            $this->width("1%");
            $this->render(function ($model, $loop) use ($column, $color) {
                return '<div class="badge bg-' . $color . '">' . e($model->$column ?? false) . '</div>';
            });
            return $this;
        });

        TD::macro('relationsBadge', function ($color = "dark") {
            $column = $this->column;
            $this->width('400px');
            $this->cantHide();
            $this->render(function ($model, $loop) use ($column, $color) {
                if (method_exists($model, $column)) {
                    $relations = '';
                    foreach ($model->$column()->get() as $relation) {
                        $relations .= '<div class="badge bg-' . $color . ' small fw-normal">' . e($relation->name ?? false) . '</div>';
                    }
                    return '<div class="d-flex flex-wrap gap-1 align-content-center justify-content-start">' . $relations . '</div>';
                }
                return false;
            });
            return $this;
        });

        /*TD::macro('actions', function () {
            $this->align(TD::ALIGN_CENTER);
            $this->width('1%');
            $this->cantHide();
            $this->render(function ($model,  $loop) {
                if ($model->routeActions) {
                    $actions = [];
                    foreach ($model->routeActions as $action) {
                        $button = [];
                        switch ($action) {
                            case "edit":
                                $button = Link::make(__('Edit'))
                                    ->route("platform." . $model->routePrefix . ".$action", $model->id)
                                    ->icon('pencil');
                                array_push($actions, $button);
                                break;

                            case "delete":
                                $button = Button::make(__('Delete'))
                                    ->icon('trash')
                                    ->class('btn btn-link text-danger')
                                    ->confirm('Ao remover esse item, todas informações relacionadas à ele serão excluídas e não poderão ser recuperadas. Deseja continuar?')
                                    ->method('remove', [
                                        'id' => $model->id,
                                    ]);
                                array_push($actions, $button);
                                break;
                        }
                    }
                }
                return DropDown::make()
                    ->icon('options-vertical')
                    ->list($actions ?? []);
            });
            return $this;
        });*/

        TD::macro('date', function ($format = "d/m/Y") {
            $column = $this->column;
            $this->align(TD::ALIGN_CENTER);
            $this->cantHide();
            $this->render(function ($model, $loop) use ($column, $format) {
                return Carbon::parse($model->$column)->format($format);
            });
            return $this;
        });

        TD::macro('link', function (?string $route, int $max_width = 30) {
            $column = $this->column;
            $this->cantHide();
            $this->render(function ($model, $loop) use ($column, $max_width, $route) {
                $split = str_split($model->$column, $max_width);
                $string = $split[0];

                if (sizeof($split) > 1) {
                    $string .= "...";
                }

                if ($route) {
                    if (Route::has($route)) {
                        return Link::make($string)
                            ->route($route, [
                                'id' => $model->id
                            ]);
                    } else {
                        return '<div class="text-danger">Rota não encontrada</div>';
                    }
                }

                return $string;
            });
            return $this;
        });

        TD::macro('truncate', function (int $max_width = 30) {
            $column = $this->column;
            $this->cantHide();
            $this->render(function ($model, $loop) use ($column, $max_width) {
                $split = str_split($model->$column, $max_width);
                $string = $split[0];

                if (sizeof($split) > 1) {
                    $string .= "...";
                }

                return $string;
            });
            return $this;
        });
    }
}
