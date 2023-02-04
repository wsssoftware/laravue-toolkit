<?php

namespace Laravue\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Laravue\Facades\Enum;
use UnitEnum;

/**
 * Class SelectResource
 *
 * Created by allancarvalho in fevereiro 04, 2023
 */
class SelectResource extends JsonResource
{
    /**
     * @var bool
     */
    public static bool $simpleEnumOnNext = false;

    /**
     * @param  array  $resource
     * @return array
     */
    protected static function normalizeEnumItems(array $resource): array
    {
        $data = [];
        foreach ($resource as $key => $value) {
            if ($value instanceof UnitEnum) {
                if (self::$simpleEnumOnNext) {
                    $value = $value->value;
                } else {
                    $key = $value->value;
                    if (method_exists($value, 'getLabel')) {
                        $value = $value->getLabel();
                    } elseif (method_exists($value, 'getName')) {
                        $value = $value->getName();
                    } else {
                        $value = $value->value;
                    }
                }
            }
            $data[$key] = $value;
        }
        if (self::$simpleEnumOnNext) {
            self::$simpleEnumOnNext = false;
        }

        return $data;
    }

    /**
     * @param $resource
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collectionWithSimpleEnum($resource): AnonymousResourceCollection
    {
        self::$simpleEnumOnNext = true;

        return self::collection($resource);
    }

    /**
     * {@inheritdoc}
     */
    public static function collection($resource): AnonymousResourceCollection
    {
        if (is_string($resource) && enum_exists($resource)) {
            $resource = Enum::pluck($resource);
        }
        if ($resource instanceof Collection) {
            $resource = $resource->toArray();
        }
        $resource = static::normalizeEnumItems($resource);

        $data = [];
        foreach ($resource as $key => $value) {
            if (! is_string($value) && ! is_numeric($value)) {
                throw new InvalidArgumentException('The value must be a string');
            }
            $data[] = ['keyField' => $key, 'valueField' => $value];
        }

        return parent::collection($data);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray(Request $request): array|Arrayable|\JsonSerializable
    {
        static::withoutWrapping();

        return parent::toArray($request);
    }
}
