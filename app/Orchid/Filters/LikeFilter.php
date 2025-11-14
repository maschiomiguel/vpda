<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;

/**
 * Necessário esse filtro pois o filtro padrão do Orchid não funciona com números
 */
class LikeFilter extends Filter
{
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
            $builder = $builder->where($this->column, 'like', "%$post%");
        }
        
        return $builder;
    }
}
