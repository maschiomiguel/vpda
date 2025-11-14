<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;

class RelationFilter extends Filter
{
    public $field = 'id';

    /**
     * @var string
     */
    protected $column;

    /**
     * @param string $column
     */
    public function __construct(string $column)
    {
        parent::__construct();
        $this->column = $column;
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        $post = $this->request->input('filter.' . $this->column);
        
        if ($post) {
            $builder = $builder->whereHas(
                $this->column,
                fn (Builder $query) => is_array($post)
                    ? $query->whereIn($this->field, $post)
                    : $query->where($this->field, $post)
            );
        }

        return $builder;
    }
}
