<?php

namespace Laravue\Telegram\Models;

use Illuminate\Support\Arr;
use Laravue\Telegram\Enum\PointType;

/**
 * Class WebAppData
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#maskposition
 */
class MaskPosition
{

    /**
     * The part of the face relative to which the mask should be placed. One of “forehead”, “eyes”, “mouth”, or “chin”.
     *
     * @var PointType
     */
    protected PointType $point;

    /**
     * Shift by X-axis measured in widths of the mask scaled to the face size, from left to right. For example, choosing
     * -1.0 will place mask just to the left of the default mask position.
     *
     * @var float
     */
    protected float $x_shift;

    /**
     * Shift by Y-axis measured in heights of the mask scaled to the face size, from top to bottom. For example, 1.0
     * will place the mask just below the default mask position.
     *
     * @var float
     */
    protected float $y_shift;

    /**
     * number	Mask scaling coefficient. For example, 2.0 means double size.
     *
     * @var float
     */
    protected float $scale;

    /**
     * @param  array  $payload
     */
    public function __construct(array $payload)
    {
        $this->point = PointType::from(Arr::get($payload, 'point'));
        $this->x_shift = (float) Arr::get($payload, 'x_shift');
        $this->y_shift = (float) Arr::get($payload, 'y_shift');
        $this->scale = (float) Arr::get($payload, 'scale');
    }

    /**
     * @return PointType
     */
    public function getPoint(): PointType
    {
        return $this->point;
    }

    /**
     * @return float
     */
    public function getXShift(): float
    {
        return $this->x_shift;
    }

    /**
     * @return float
     */
    public function getYShift(): float
    {
        return $this->y_shift;
    }

    /**
     * @return float
     */
    public function getScale(): float
    {
        return $this->scale;
    }
}
