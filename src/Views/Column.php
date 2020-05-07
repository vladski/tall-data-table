<?php

namespace Tanthammar\TallDataTable\Views;

use Illuminate\Support\Str;
use Tanthammar\TallDataTable\Traits\CanBeHidden;
use Tanthammar\TallDataTable\Traits\HasComponents;

/**
 * Class Column.
 */
class Column
{
    use HasComponents, CanBeHidden;

    protected $type = 'default';
    protected $text;
    protected $attribute;
    protected $key;

    protected $group = 1;
    protected $colspan = 1;
    protected $colClass = null;
    protected $labelClass = 'pr-2 text-xs text-gray-400 text-left';
    protected $labelWidth = 'w-15';

    protected $align = 'text-left';
    protected $visibility = null;
    protected $hideValue = false;

    protected $mediaCollection = null;
    protected $mediaClass = 'rounded';
    protected $tagType = null;
    protected $tagClass = null;

    protected $relation = null;
    protected $relationAttribute = null;

    protected $iconBefore = false;
    protected $iconBeforeColor = null;
    protected $iconAfter = false;
    protected $iconAfterColor = null;
    protected $iconEmptyWarningColor = null;

    protected $tooltip = false;

    protected $orderBy = null;
    protected $displayAttribute = null;

    protected $searchable = false;
    protected $searchCallback = null;

    protected $sortable = false;
    protected $sortCallback;

    protected $callField = null;
    protected $bladeString = null;

    /**
     * @var
     */
    protected $view;

    /**
     * Column constructor.
     *
     * @param $text
     * @param $attribute
     */
    public function __construct($text, $attribute = false)
    {
        $this->text = $text;
        $this->attribute = $attribute ?? Str::snake(Str::lower($text));
    }

    /**
     * @param $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * @param  string  $text
     * @param  string  $attribute
     * @param  string  $key
     *
     * @return static
     */
    public static function make($text = null, $attribute = null)
    {
        return new static($text, $attribute);
    }

    /**
     * @param  callable|null  $callable
     *
     * @return $this
     */
    public function searchable(callable $callable = null): self
    {
        if ($this->hasComponents()) {
            return $this;
        }
        $this->searchCallback = $callable;
        $this->searchable = true;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSearchable(): bool
    {
        return $this->searchable;
    }

    /**
     * @return $this
     */
    public function media($collectionName, $mediaClass = null): self
    {
        $this->type = 'media';
        $this->mediaCollection = $collectionName;
        $this->mediaClass = $mediaClass ?? 'rounded';
        return $this;
    }

    /**
     * @return $this
     */
    public function tags($tagType = null, $tagClass = null): self
    {
        $this->type = 'tags';
        $this->tagType = $tagType;
        $this->tagClass = $tagClass;
        return $this;
    }

    /**
     * @param  callable|null  $callable
     *
     * @return $this
     */
    public function sortable(callable $callable = null): self
    {
        if ($this->hasComponents()) {
            return $this;
        }
        $this->sortCallback = $callable;
        $this->sortable = true;
        return $this;
    }

    public function orderBy($field): self
    {
        $this->orderBy = $field;
        return $this;
    }

    /**
     * @param  callable|null  $callable
     *
     * @return $this
     */
    public function displayUsing(callable $callable = null): self
    {
        if ($this->hasComponents()) {
            return $this;
        }
        $this->displayAttribute = $callable;
        $this->type = 'display-attribute';
        return $this;
    }

    /**
     * @return bool
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * @return $this
     */
    public function class($class): self
    {
        $this->colClass = $class;
        return $this;
    }

    /**
     * @return $this
     */
    public function labelClass($class): self
    {
        $this->labelClass = $class;
        return $this;
    }

    /**
     * @return $this
     */
    public function labelWidth($class): self
    {
        $this->labelWidth = $class;
        return $this;
    }

    /**
     * @return $this
     */
    public function unescaped(): self
    {
        if ($this->hasComponents()) {
            return $this;
        }
        $this->type = 'unescaped';
        return $this;
    }

    /**
     * make a click to call href, optional field
     */
    public function clickCall($field = null): self
    {
        $this->type = 'click-call';
        $this->callfield = $field ?? null;
        return $this;
    }

    /**
     * Parse blade string
     */
    public function blade($string): self
    {
        $this->type = 'blade';
        $this->bladeString = $string;
        return $this;
    }

    /**
     * Create column group
     */
    public function group($num): self
    {
        $this->group = $num ?? 1;
        return $this;
    }

    public function hideOnMobile(): self
    {
        $this->visibility = 'tablet:hidden';
        return $this;
    }

    public function hideOnDesktop(): self
    {
        $this->visibility = 'md:hidden';
        return $this;
    }

    public function hideValue(): self
    {
        $this->hideValue = true;
        return $this;
    }

    /**
     * Cell alignment
     */
    public function align($class): self
    {
        $this->align = $class ?? 'text-left';
        return $this;
    }

    /**
     * Body colspan
     */
    public function colspan($num): self
    {
        $this->colspan = $num ?? 1;
        return $this;
    }

    /**
     * @return $this
     */
    public function html(): self
    {
        if ($this->hasComponents()) {
            return $this;
        }
        $this->type = 'html';
        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function keyVal($key): self
    {
        $this->key = $key;
        $this->type = 'key-val';
        return $this;
    }

    /**
     * @param string $relation
     * @param string $relationAttribute
     * @return $this
     */
    public function related($relation, $relationAttribute): self
    {
        $this->relation = $relation;
        $this->relationAttribute = $relationAttribute;
        $this->type = 'related';
        return $this;
    }


    public function emptyWarning($tooltip = false, $color = null): self
    {
        $this->type = 'empty-warning';
        $this->tooltip = $tooltip ?? false;
        $this->iconEmptyWarningColor = $color ?? null;
        return $this;
    }

    /**
     * @param string $icon
     * @param string $color
     */
    public function iconBefore($icon, $color = null): self
    {
        $this->iconBefore = $icon;
        $this->iconBeforeColor = $color ?? null;
        return $this;
    }

    /**
     * @param string $icon
     * @param string $color
     */
    public function iconAfter($icon, $color = null): self
    {
        $this->iconAfter = $icon;
        $this->iconAfterColor = $color ?? null;
        return $this;
    }


    /**
     * @param $view
     * @return $this
     */
    public function view($view): self
    {
        if ($this->hasComponents()) {
            return $this;
        }
        $this->view = $view;
        return $this;
    }

    /**
     * @return bool
     */
    public function isView(): bool
    {
        return view()->exists($this->view);
    }
}
