<?php
namespace Tanthammar\TallDataTable\Traits;

use Illuminate\Support\Facades\Cache;
use Tanthammar\TallDataTable\Traits\CacheKeyGenerator;

trait DbSearchable
{
    use CacheKeyGenerator;
    
    public function DB_searchable($query, $contains, $exact, $numeric, $dates = [])
    {
        $url = request()->url();
        $query_params = $this->params();

        if (filled($this->search)) {
            $query->where(function ($query) use ($contains, $exact, $numeric, $dates) {
                $this->db_search($query, $contains, $exact, $numeric, $dates);
            });
            return $query->orderByTranslation($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);
        } else {
            return Cache::remember($this->url_key($url, $query_params), now()->addDays(1), function () use ($query) {
                return $query->orderByTranslation($this->sortField, $this->sortDirection)
                    ->paginate($this->perPage);
            });
        }
    }

    public function db_search(
        $query,
        $column_contains = null,
        $column_equals = null,
        $numeric_column_equals = null,
        $date_column_equals = null
    ) {
        // debug($column_contains, $column_equals, $numeric_column_equals, $date_column_equals, $this->search);

        // have tested with orWhereJsonContains but it does not find what we want
        // also tried raw BINARY and UPPER to perform case insensitive search, but it does not work either
        // from googling it says we need another db coallation

        if (filled($column_contains)) {
            // debug('have contain');
            foreach ($column_contains as $field) {
                $query->orWhereLike($field, $this->search );
            }
        }

        if (filled($column_equals)) {
            // debug('have equals');
            foreach ($column_equals as $field) {
                $query->orWhere($field, $this->search);
            }
        }

        if (filled($numeric_column_equals) && is_numeric($this->search)) {
            foreach ($numeric_column_equals as $field) {
                $query->orWhere($field, $this->search);
            }
        }
        if (filled($date_column_equals)) {
            // debug('have dates');
            foreach ($date_column_equals as $field) {
                $query->orWhereDate($field, $this->search);
            }
        }
        // debug($query->toSql());
        return $query;
    }
}