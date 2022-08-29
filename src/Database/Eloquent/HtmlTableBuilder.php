<?php

namespace Laravue\Database\Eloquent;

use Illuminate\Database\Eloquent\Builder;
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
     * @param  string  $column
     * @param  string|null  $label
     * @param  bool  $searchable
     * @param  bool  $orderable
     * @return $this
     */
    public function setHtmlColumn(string $column, string $label = null, bool $searchable = true, bool $orderable = true): self
    {
        $this->htmlColumns[$column] = [
            'name' => $column,
            'label' => $label ?? Str::headline($column),
            'searchable' => $label ?? Str::headline($column),
            'orderable' => $label ?? Str::headline($column),
        ];

        return $this;
    }

    protected function getHtmlColumns(array $columns): array
    {
        if (empty($this->htmlColumns)) {
            $columns = $columns === ['*'] ? $this->query->columns : $columns;
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
        $columns = [];
        foreach ($this->htmlColumns as $htmlColumn) {
            $columns[] = $htmlColumn['name'];
        }
        $primaryKey = $this->model->getKeyName();
        if (! in_array($primaryKey, $columns)) {
            $columns[] = $primaryKey;
        }
        $this->select($columns);

        return $this->htmlColumns;
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

    public function setInertia(string $key): void
    {
        Inertia::share($key, fn() => $this->get());
    }

    /**
     * {@inheritdoc}
     */
    public function get($columns = ['*'])
    {
        $htmlColumns = $this->getHtmlColumns($columns);

        $casts = [];
        foreach ($htmlColumns as $htmlColumn) {
            $casts[$htmlColumn['name']] = $this->model->getCasts()[$htmlColumn['name']] ?? null;
            if (! empty($this->valuesCallbackNewCast[$htmlColumn['name']])) {
                $casts[$htmlColumn['name']] = $this->valuesCallbackNewCast[$htmlColumn['name']];
            }
        }



        return [
            'casts' => $casts,
            'columns' => $htmlColumns,
            'rows' => Inertia::lazy(function () use ($columns) {
                $tableItems = parent::get($columns)->toArray();
                foreach ($tableItems as $index => $tableItem) {
                    foreach ($tableItem as $column => $value) {
                        if (isset($this->valuesCallback[$column])) {
                            $tableItems[$index][$column] = call_user_func($this->valuesCallback[$column], $value);
                        }
                    }
                    $tableItems[$index]['primary_key'] = $tableItem[$this->model->getKeyName()];
                }
            }),
        ];
    }
}
