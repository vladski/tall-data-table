<?php

namespace Tanthammar\TallDataTable\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait BuildQuery

{
    public function generate($query): Builder
    {
        foreach ($this->columns() as $c) {
            switch ($c->type) {
                case 'media':
                    if(filled($c->mediaCollection)) {
                        $query->with([
                            'media' => fn (MorphMany $q) => $q->where('collection_name', $c->mediaCollection)
                        ]);
                    } else {
                        $query->with('media');
                    }
                    break;
                case 'tags':
                    if (filled($c->tagType)) {
                        $query->with([
                            'tags' => fn (MorphToMany $q) => $q->where('type', $c->tagType)
                        ]);
                    } else {
                        $query->with('tags');
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }
        return $query;
    }
}
