<?php

namespace Tanthammar\TallDataTable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Livewire\WithPagination;
use Tanthammar\TallDataTable\Traits\Checkboxes;
use Tanthammar\TallDataTable\Traits\Loading;
use Tanthammar\TallDataTable\Traits\Offline;
use Tanthammar\TallDataTable\Traits\Pagination;
use Tanthammar\TallDataTable\Traits\Search;
use Tanthammar\TallDataTable\Traits\Sorting;
use Tanthammar\TallDataTable\Traits\Table;
use Tanthammar\TallDataTable\Traits\Yajra;

/**
 * Class TableComponent.
 */
trait TableComponent
{
    use Checkboxes,
        Loading,
        Offline,
        Pagination,
        Search,
        Sorting,
        Table,
        WithPagination,
        Yajra;


    /**
     * Whether or not to refresh the table at a certain interval
     * false is off
     * If it's an integer it will be treated as milliseconds (2000 = refresh every 2 seconds)
     * If it's a string it will call that function every 5 seconds.
     *
     * @var bool|string
     */
    public $refresh = false;

    /**
     * Constructor.
     */
    public function setupTable()
    {
        $this->setTranslationStrings();
        $this->setTableProperties();
        $this->setPaginationProperties();
        //$this->groups = $this->groupColumns();
    }

    /**
     * Sets the initial translations of these items.
     */
    public function setTranslationStrings()
    {
        $this->loadingMessage = trans('global.loading');
        $this->offlineMessage = trans('offline_warning');
        $this->noResultsMessage = trans('messages.not_found');
        $this->perPageLabel = trans('pagination.per_page');
        $this->searchLabel = trans('global.search');
    }

    public $selectedID = null;
    public function selectModel($uuid)
    {
        //if we click again on the same uuid, close panel
        $this->selectedID = $this->selectedID == $uuid ? '' : $uuid;
    }

    /**
     * @return mixed
     */
    abstract public function query(): Builder;

    /**
     * @return mixed
     */
    abstract public function columns(): array;


    public function groups(): array
    {
        foreach ($this->columns() as $column) {
            $groups[$column->group][] = $column;
        }
        if (count($groups) > 1) { //only sort if there are groups
            foreach($groups as $group) {
                $group = \Arr::sortRecursive($group);
            }
        }
        return $groups;
    }

    public function searchTooltip()
    {
        $tooltip = $this->searchLabel . ': ';

        foreach ($this->columns() as $column) {
            if ($column->isSearchable()) {
                $tooltip .= $column->text . '. ';
            }
        }
        return $tooltip;
    }

    public function translatedTooltip($array)
    {
        $tooltip = $this->searchLabel . ': ';
        foreach ($array as $field) {
            $trans[] = trans('fields.' . $field);
        }
        return $tooltip . implode(", ", $trans);
    }

    /**
     * @return string
     */
    public function view(): string
    {
        return 'tall-data-table::table-component';
    }

    public function render()
    {
        return $this->tableView();
    }

    /**
     * @return mixed
     */
    public function tableView(): View
    {
        return view($this->view(), [
            'groups' => $this->groups(),
            'models' => $this->models_whereLike(),
        ]);
    }

    protected function models_whereLike()
    {
        return $this->paginationEnabled ? $this->models()->paginate($this->perPage) : $this->models()->get();
    }

    /**
     * @return Builder|LengthAwarePaginator
     */
    public function models()
    {
        $models = $this->query();

        if ($this->searchEnabled && trim($this->search) !== '') {
            $models->where(function (Builder $query) {
                foreach ($this->columns() as $column) {
                    if ($column->searchable) {
                        if (is_callable($column->searchCallback)) {
                            $query = app()->call($column->searchCallback, ['builder' => $query, 'term' => $this->search]);
                        } elseif (Str::contains($column->attribute, '.')) {
                            $relationship = Yajra::relationship($column->attribute);

                            $query->orWhereHas($relationship->name, function (Builder $query) use ($relationship) {
                                $query->where($relationship->attribute, 'like', '%' . $this->search . '%');
                            });
                        } else {
                            $query->orWhere($query->getModel()->getTable() . '.' . $column->attribute, 'like', '%' . $this->search . '%');
                        }
                    }
                }
            });
        }

        if (Str::contains($this->sortField, '.')) {
            $relationship = Yajra::relationship($this->sortField);
            $sortField = Yajra::attribute($models, $relationship->name, $relationship->attribute);
        } else {
            $sortField = $this->sortField;
        }

        if (($column = Yajra::getColumnByAttribute($this->columns(), $this->sortField)) !== null && is_callable($column->sortCallback)) {
            return app()->call($column->sortCallback, ['models' => $models, 'sortField' => $sortField, 'sortDirection' => $this->sortDirection]);
        }

        return $models->orderByTranslation($sortField, $this->sortDirection);
    }
}
