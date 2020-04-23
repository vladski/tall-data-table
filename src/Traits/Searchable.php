<?php

namespace Tanthammar\TallDataTable\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Tanthammar\TallDataTable\Traits\CacheKeyGenerator;

trait Searchable
{
    use CacheKeyGenerator;
    
    public function searchable($query)
    {
        $url = request()->url();
        $query_params = $this->params();

        if (filled($this->search)) {
            return $query->whereLike('search', $this->search)
                ->orderByTranslation($this->sortField, $this->sortDirection)
                ->paginate($this->perPage);
        } else {
            return Cache::remember($this->url_key($url, $query_params), now()->addDays(1), function () use ($query) {
                return $query->orderByTranslation($this->sortField, $this->sortDirection)
                    ->paginate($this->perPage);
            });
        }
    }
}
