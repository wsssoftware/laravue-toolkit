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
    /**
     * @var array
     */
    protected array $htmlColumns = [];

    /**
     * @var array
     */
    protected array $valuesCallback = [];

    /**
     * @var array
     */
    protected array $valuesCallbackNewCast = [];

    /**
     * @var array<int, bool>
     */
    protected array $pageSizeOptions = [10 => false, 25 => true, 50 => false, 100 => false];

    /**
     * @var int
     */
    protected int $defaultPageSize = 25;

    /**
     * @var int
     */
    protected int $currentPageSize = 25;

    /**
     * @var string|null
     */
    protected ?string $tableSearch = null;

    /**
     * @var bool
     */
    protected bool $wasATableSearch = false;

    /**
     * @var array|null
     */
    protected ?array $tableSort = null;

    /**
     * @var int
     */
    protected int $tablePage = 1;

    /**
     * @var string
     */
    protected string $tableKey;

    /**
     * @return array
     */
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
     * @param  string  $column
     * @param  string|null  $label
     * @param  bool  $searchable
     * @param  bool  $orderable
     * @param  bool  $database
     * @return $this
     */
    public function setHtmlColumn(
        string $column,
        string $label = null,
        bool $searchable = true,
        bool $orderable = true,
        bool $database = true,
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
        ];

        return $this;
    }

    /**
     * @param  string  $column
     * @param  string|null  $newCast
     * @param  callable  $callback
     * @return $this
     */
    public function setHtmlValueCallback(string $column, ?string $newCast, callable $callback): self
    {
        $this->valuesCallback[$column] = $callback;
        $this->valuesCallbackNewCast[$column] = $newCast;

        return $this;
    }

    /**
     * @param  int[]  $pageSizeOptions
     * @param  int  $default
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
        $this->defaultPageSize = $default;

        return $this;
    }

    /**
     * @param  string  $key
     * @return array
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function getInertiaProps(string $key): array
    {
        $this->tableKey = $key;
        $data = request()->get("table-$key", []);
        $this->tableSearch = Arr::get($data, 'search', $this->tableSort);
        $this->tableSort = Arr::get($data, 'sort', $this->tableSort);
        $this->currentPageSize = intval(Arr::get($data, 'page_size', $this->defaultPageSize));
        $this->tablePage = intval(Arr::get($data, 'page', $this->tablePage));

        foreach ($this->valuesCallbackNewCast as $column => $cast) {
            if (empty($cast)) {
                continue;
            }
            $this->htmlColumns[$column]['cast'] = $cast;
        }

        if (Arr::exists($data, 'search')) {
            $this->wasATableSearch = true;
        }
        if (! empty($this->tableSort) && ! empty($this->htmlColumns[$this->tableSort['column']])) {
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
     * @param  array  $htmlColumns
     * @return void
     */
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

    /**
     * @return void
     */
    protected function doOrder(): void
    {
        if (! empty($this->tableSort)) {
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

    /**
     * @return array
     */
    protected function getPageData(): array
    {
        $htmlColumns = $this->getHtmlColumns();

        $this->setSelectAndRelationships($htmlColumns);

        $countTotal = $this->count();
        $this->doSearch($htmlColumns);

        $this->doOrder();

        $pageTag = "table-{$this->tableKey}.page";
        $page = $this->paginate($this->currentPageSize, ['*'], $pageTag);

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
     *
     * @return array
     */
    protected function getTrans(): array
    {
        return [
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

    /**
     * Get table options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            'search' => $this->tableSearch,
            'was_a_search' => $this->wasATableSearch,
            'sort' => $this->tableSort,
            'page_size_options' => $this->pageSizeOptions,
            'default_page_size' => $this->defaultPageSize,
            'current_page_size' => $this->currentPageSize,
            'page' => $this->tablePage,
        ];
    }

    /**
     * @param  array  $htmlColumns
     * @return void
     */
    protected function setSelectAndRelationships(array $htmlColumns): void
    {
        $relationships = [];
        $columns = [];
        foreach ($htmlColumns as $htmlColumn) {
            $columnName = $htmlColumn['name'];
            if ($htmlColumn['database'] === false) {
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

    /**
     * @param  array  $tableRows
     * @param  array  $htmlColumns
     * @return array
     */
    protected function formatTableRows(array $tableRows, array $htmlColumns): array
    {
        foreach ($tableRows as $index => $tableRow) {
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
            $tableRow['primary_key'] = $tableRow[$this->model->getKeyName()];
            $tableRows[$index] = $tableRow;
        }

        return $tableRows;
    }
}
