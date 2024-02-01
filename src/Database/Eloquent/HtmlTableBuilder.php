<?php

namespace Laravue\Database\Eloquent;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

/**
 * Class TableBuilder
 *
 * Created by allancarvalho in agosto 26, 2022
 */
class HtmlTableBuilder extends Builder
{
    protected array $additionalColumns = [];

    /**
     * @var callable[]
     */
    protected array $customColumns = [];

    protected array $htmlColumns = [];

    protected int $pageSize = 25;

    protected int $pageSizeDefault = 25;

    /**
     * @var array<int, bool>
     */
    protected array $pageSizeOptions = [10 => false, 25 => true, 50 => false, 100 => false];

    /**
     * @var ?bool
     */
    protected ?bool $searchFocus = null;

    protected array $tableFilters = [];

    protected ?string $tableFilter = null;

    protected string $tableFilterDefault = 'none';

    protected string $tableKey;

    protected int $tablePage = 1;

    protected ?string $tableSearch = null;

    protected ?array $tableSort = null;

    protected array $valuesCallback = [];

    protected array $valuesCallbackNewCast = [];

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getInertiaProps(string $key): array
    {
        $this->tableKey = $key;
        $data = request()->get("table-$key", []);
        $this->tableFilter = Arr::get($data, 'filter', $this->tableFilter ?? $this->tableFilterDefault);
        $this->tableSearch = Arr::get($data, 'search', $this->tableSearch);
        $this->searchFocus = Arr::get($data, 'search_focus', $this->searchFocus);
        $this->tableSort = Arr::get($data, 'sort', $this->tableSort);
        $this->pageSize = intval(Arr::get($data, 'page_size', $this->pageSizeDefault));
        $this->tablePage = intval(Arr::get($data, 'page', $this->tablePage));

        foreach ($this->valuesCallbackNewCast as $column => $cast) {
            if (empty($cast) || isset($this->additionalColumns[$column])) {
                continue;
            }
            $this->htmlColumns[$column]['cast'] = $cast;
        }

        if (Arr::exists($data, 'search')) {
            $this->searchFocus = true;
        }
        if (! empty($this->tableSort) && ! empty($this->htmlColumns[$this->tableSort['column']])) {
            foreach ($this->htmlColumns as $htmlColumn) {
                $this->htmlColumns[$htmlColumn['name']]['current_sort'] = null;
            }
            $this->htmlColumns[$this->tableSort['column']]['current_sort'] = $this->tableSort['direction'];
        }

        return [
            "$key.options" => fn () => $this->getOptions(),
            "$key.trans" => fn () => $this->getTrans(),
            "$key.columns" => fn () => $this->getHtmlColumns(),
            "$key.data" => Inertia::lazy(fn () => $this->getPageData()),
        ];
    }

    /**
     * @return $this
     */
    public function setAdditionalColumn(string $column): self
    {
        $this->additionalColumns[$column] = $column;

        return $this;
    }

    /**
     * @return $this
     */
    public function setCustomColumn(string $column, callable $closure): self
    {
        $this->customColumns[$column] = $closure;

        return $this;
    }

    /**
     * Add a new column for a html table
     *
     * @return $this
     */
    public function setHtmlColumn(
        string $column,
        ?string $label = null,
        bool $searchable = true,
        bool $orderable = true,
        bool $database = true,
        array $customAttributes = []
    ): self {
        $cast = $this->model->getCasts()[$column] ?? null;

        $this->htmlColumns[$column] = [
            'name' => $column,
            'label' => $label ?? Str::headline($column),
            'searchable' => $searchable,
            'orderable' => $orderable,
            'database' => $database,
            'current_sort' => null,
            'cast' => $cast,
            'custom_attributes' => $customAttributes,
        ];

        return $this;
    }

    /**
     * Add a new non-database column for a html table
     *
     * @return $this
     */
    public function setHtmlColumnNonDatabase(string $column, ?string $label = null, array $customAttributes = []): self
    {
        return $this->setHtmlColumn($column, $label, false, false, false, $customAttributes);
    }

    /**
     * @return $this
     */
    public function setHtmlValueCallback(string $column, ?string $newCast, callable $callback): self
    {
        $this->valuesCallback[$column] = $callback;
        $this->valuesCallbackNewCast[$column] = $newCast;

        return $this;
    }

    /**
     * @return $this
     *
     * @throws \Exception
     */
    public function setTableFilter(string $key, string $label, callable $callback): self
    {
        if ($key === 'none') {
            throw new Exception('Filter key \'none\' is a reserved key');
        }
        $this->tableFilters[$key] = [
            'key' => $key,
            'label' => $label,
            'callback' => $callback,
        ];

        return $this;
    }

    /**
     * @return $this
     */
    public function setDefaultFilter(string $key = 'none'): self
    {
        $this->tableFilterDefault = $key;

        return $this;
    }

    /**
     * @param  int[]  $pageSizeOptions
     * @return $this
     *
     * @throws \Exception
     */
    public function setPageSizeOptions(array $pageSizeOptions, int $default): self
    {
        if (empty($pageSizeOptions)) {
            throw new Exception('The page size options cannot be empty.');
        }
        $this->pageSizeOptions = [];

        $pageSizeOptions[] = $default;
        $pageSizeOptions = array_unique($pageSizeOptions);
        sort($pageSizeOptions);
        foreach ($pageSizeOptions as $index => $pageSizeOption) {
            if (! is_int($pageSizeOption) || $pageSizeOption < 1) {
                throw new Exception('The page size options must be an array of integers greater than zero.');
            }
            $this->pageSizeOptions[$pageSizeOption] = $pageSizeOption === $default;
        }
        $this->pageSizeDefault = $default;

        return $this;
    }

    protected function doOrder(): void
    {
        if (! empty($this->tableSort)) {
            $this->query->orders = null;
            $column = $this->tableSort['column'];
            if (Str::contains($column, '.')) {
                $relationshipName = Str::before($column, '.');
                $relationshipColumn = Str::after($column, '.');
                $relationship = $this->model->{$relationshipName}();
                /** @var \Illuminate\Database\Eloquent\Model $relationshipModel */
                $relationshipModel = $relationship->getRelated();
                if ($relationship instanceof BelongsTo) {
                    $ids = $relationshipModel->query()
                        ->orderBy($relationshipColumn, $this->tableSort['direction'])
                        ->pluck($relationship->getOwnerKeyName())
                        ->toArray();
                    $idsList = implode(',', $ids);
                    $this->orderByRaw(DB::raw("FIELD({$relationship->getForeignKeyName()}, $idsList)"));
                }
            } elseif (! $this->model->isRelation($column)) {
                $this->orderBy($this->tableSort['column'], $this->tableSort['direction']);
            }
        }
    }

    protected function doSearch(array $htmlColumns): void
    {
        if (empty($this->tableSearch)) {
            return;
        }
        $this->where(function (Builder $query) use ($htmlColumns) {
            foreach ($htmlColumns as $htmlColumn) {
                $columnName = $htmlColumn['name'];
                if ($htmlColumn['searchable']) {
                    if (Str::contains($columnName, '.')) {
                        $relationship = Str::before($columnName, '.');
                        $relationshipColumn = Str::after($columnName, '.');
                        $query->orWhereHas($relationship, function ($query) use ($relationshipColumn) {
                            $query->where(DB::raw("CONVERT($relationshipColumn ,char)"), 'LIKE',
                                "%{$this->tableSearch}%");
                        });
                    } elseif (! $this->model->isRelation($columnName)) {
                        $query->orWhere(DB::raw("CONVERT($columnName ,char)"), 'LIKE', "%{$this->tableSearch}%");
                    }
                }
            }
        });
    }

    protected function doSelectAndRelationships(array $htmlColumns): void
    {
        $relationships = [];
        $columns = [];
        $columnNames = array_unique(array_merge(array_keys($htmlColumns), $this->additionalColumns));
        foreach ($columnNames as $columnName) {
            if (isset($htmlColumns[$columnName]) && $htmlColumns[$columnName]['database'] === false) {
                continue;
            }
            if (! Str::contains($columnName, '.') && ! $this->model->isRelation($columnName)) {
                $columns[$columnName] = $columnName;
            } elseif ($this->model->isRelation($columnName)) {
                $relationships[$columnName] = ['*'];
            } elseif (Str::contains($columnName, '.')) {
                $relationship = Str::before($columnName, '.');
                $columnName = Str::after($columnName, '.');
                if (empty($relationships[$relationship])) {
                    $relationships[$relationship] = [];
                }
                $relationships[$relationship][$columnName] = $columnName;
            }
        }
        if (! in_array($this->model->getKeyName(), $columns)) {
            $columns[$this->model->getKeyName()] = $this->model->getKeyName();
        }

        foreach ($relationships as $relationshipName => $relationshipColumns) {
            $relationship = $this->model->$relationshipName();
            $ownerKey = null;
            if ($relationship instanceof BelongsTo) {
                $columns[$relationship->getForeignKeyName()] = $relationship->getForeignKeyName();
                $ownerKey = $relationship->getOwnerKeyName();
            }
            if ($relationshipColumns === ['*']) {
                $this->with($relationshipName);
            } else {
                if (! empty($ownerKey)) {
                    $relationshipColumns[$ownerKey] = $ownerKey;
                }
                $this->with([
                    $relationshipName => function ($query) use ($relationshipColumns) {
                        return $query->select($relationshipColumns);
                    },
                ]);
            }
        }
        $this->select($columns);
    }

    protected function formatTableRows(array $tableRows, array $htmlColumns): array
    {
        foreach ($tableRows as $index => $tableRow) {
            $tableRowModel = $tableRow;
            $tableRow = $tableRow->toArray();
            foreach ($htmlColumns as $column => $columnData) {
                $value = $tableRow[$column] ?? null;
                if (Str::contains($column, '.')) {
                    $value = Arr::get($tableRow, $column);
                    $tableRow[$column] = $value;
                }
                if (isset($this->valuesCallback[$column])) {
                    $tableRow[$column] = call_user_func($this->valuesCallback[$column], $value, $tableRow);
                }
            }
            foreach ($this->additionalColumns as $additionalColumn) {
                if (isset($tableRow[$additionalColumn]) && isset($this->valuesCallback[$additionalColumn])) {
                    $tableRow[$additionalColumn] = call_user_func($this->valuesCallback[$additionalColumn], $tableRow[$additionalColumn], $tableRow);
                }
            }

            $tableRow['primary_key'] = $tableRow[$this->model->getKeyName()];

            foreach ($this->customColumns as $column => $closure) {
                $tableRow[$column] = call_user_func($closure, $tableRowModel);
            }

            $tableRows[$index] = $tableRow;
        }

        return $tableRows;
    }

    protected function getHtmlColumns(): array
    {
        if (empty($this->htmlColumns)) {
            $columns = $this->query->columns;
            if (empty($columns)) {
                $columns = DB::getSchemaBuilder()->getColumnListing($this->model->getTable());
                $hidden = $this->model->getHidden();
                $columns = Arr::where($columns, function ($value) use ($hidden) {
                    return ! in_array($value, $hidden);
                });
            }
            foreach ($columns as $column) {
                $this->setHtmlColumn($column);
            }
        }

        return $this->htmlColumns;
    }

    /**
     * Get table options
     */
    protected function getOptions(): array
    {
        $filters = [];
        if (! empty($this->tableFilters)) {
            if ($this->tableFilterDefault === 'none') {
                $filters = [
                    ['key' => 'none', 'label' => __('laravue::table.filter_none')],
                ];
            }
            foreach ($this->tableFilters as $tableFilter) {
                $filters[] = [
                    'key' => $tableFilter['key'],
                    'label' => $tableFilter['label'],
                ];
            }
        }

        return [
            'filters' => $filters,
            'filter' => $this->tableFilter,
            'search' => $this->tableSearch,
            'search_focus' => $this->searchFocus,
            'sort' => $this->tableSort,
            'page_size_options' => $this->pageSizeOptions,
            'default_page_size' => $this->pageSizeDefault,
            'current_page_size' => $this->pageSize,
            'page' => $this->tablePage,
        ];
    }

    /**
     * @throws \Exception
     */
    protected function getPageData(): array
    {
        if ($this->tableFilter !== 'none') {
            if (empty($this->tableFilters[$this->tableFilter])) {
                throw new \Exception(sprintf('Filter %s not found', $this->tableFilter));
            }
            $this->tableFilters[$this->tableFilter]['callback']($this);
        }

        $htmlColumns = $this->getHtmlColumns();

        $this->doSelectAndRelationships($htmlColumns);

        $countTotal = $this->count();
        $this->doSearch($htmlColumns);

        $this->doOrder();

        $pageTag = "table-{$this->tableKey}.page";
        $page = $this->paginate($this->pageSize, ['*'], $pageTag);

        $tableRows = $this->formatTableRows($page->items(), $htmlColumns);

        $from = ($page->currentPage() * $page->perPage()) - $page->perPage() + 1;
        $to = $from + $page->perPage() - 1;

        return [
            'info' => [
                'from' => $page->total() === 0 ? 0 : $from,
                'to' => $page->total() < $to ? $page->total() : $to,
                'total' => $countTotal,
                'filtered_total' => $page->total(),
                'page' => $page->currentPage(),
                'last_page' => $page->lastPage(),
            ],
            'rows' => $tableRows,
        ];
    }

    /**
     * Get the translations for the table.
     */
    protected function getTrans(): array
    {
        return [
            'filters' => __('laravue::table.filters'),
            'loading_data' => __('laravue::table.loading_data'),
            'not_found' => __('laravue::table.not_found'),
            'header' => [
                'search_label' => __('laravue::table.search_label'),
                'search_placeholder' => __('laravue::table.search_placeholder'),
                'page_size_label' => __('laravue::table.page_size_label'),
            ],
            'footer' => [
                'info' => __('laravue::table.info'),
                'info_filtered' => __('laravue::table.info_filtered'),
            ],
            'paginator' => [
                'first' => __('laravue::table.first'),
                'previous' => __('laravue::table.previous'),
                'next' => __('laravue::table.next'),
                'last' => __('laravue::table.last'),
            ],
        ];
    }
}
