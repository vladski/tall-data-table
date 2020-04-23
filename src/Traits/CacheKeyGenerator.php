<?php
namespace Tanthammar\TallDataTable\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

trait CacheKeyGenerator
{
    protected function params()
    {
        return [
            'page' => $this->page,
            'search' => $this->search,
            'perpage' => $this->perPage,
            'sortfield' => $this->sortField,
            'order' => $this->sortDirection,
        ];
    }

    public function url_key($url, $query_params)
    {
        $key = $this->sort_url_params($url, $query_params);
        $combined = $key . Auth::user()->id;
        $hashed = sha1($combined); // hash it for easier lookup in db
        return $combined;
    }

    /**
     * Generate cache key to store the builder without search param
     * src: https://laravel-news.com/cache-query-params.
     */
    public function sort_url_params($url, $query_params)
    {

        if (filled($this->search)) { //store the builder without search param
            $query_params = Arr::except($query_params, 'search');
        }
        ksort($query_params); // sort the array to recognize the same query even if user shuffles the order of the params
        $query_string = http_build_query($query_params); // make it valid query string again
        $sorted_url = "{$url}?{$query_string}";

        return $sorted_url;
    }
}