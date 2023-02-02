<?php

namespace Laravue\Flash;

use Laravue\Enums\FlashPositions;
use Laravue\Enums\FlashTypes;
use Laravue\Enums\FontAwesomeTypes;

/**
 * Class FlashMessage
 *
 * Created by allancarvalho in fevereiro 02, 2023
 */
class FlashMessage
{
    /**
     * @var \Laravue\Enums\FlashTypes
     */
    protected FlashTypes $type = FlashTypes::DEFAULT;

    /**
     * @var \Laravue\Enums\FlashPositions
     */
    protected FlashPositions $position = FlashPositions::TOP_RIGHT;

    /**
     * @var string
     */
    protected string $faIcon = 'fa-circle-info';

    /**
     * @var \Laravue\Enums\FontAwesomeTypes
     */
    protected FontAwesomeTypes $faType = FontAwesomeTypes::SOLID;

    /**
     * @var int|false
     */
    protected int|false $timeout = 5000;

    /**
     * @var bool
     */
    protected bool $closeOnClick = true;

    /**
     * @var bool
     */
    protected bool $closeOnDrag = true;

    /**
     * @var bool
     */
    protected bool $pauseOnHover = true;

    /**
     * @var bool
     */
    protected bool $pauseOnFocusLoss = true;

    /**
     * @var bool
     */
    protected bool $closeButton = true;

    /**
     * @var bool
     */
    protected bool $showCloseButtonOnlyOnHover = false;

    /**
     * @var bool
     */
    protected bool $hideProgressBar = false;

    /**
     * @var bool
     */
    protected bool $rtl = false;

    /**
     * @var string
     */
    protected string $message;

    /**
     * @param  string  $message
     * @param  \Laravue\Enums\FlashTypes  $type
     * @param  string|null  $faIcon
     */
    public function __construct(
        string $message,
        FlashTypes $type,
        ?string $faIcon,
    ) {
        $this->message = $message;
        $this->type = $type;
        if (! empty($faIcon)) {
            $this->setFaIcon($faIcon);
        }
    }

    /**
     * @param  \Laravue\Enums\FlashPositions  $position
     * @return \Laravue\Flash\FlashMessage
     */
    public function setPosition(FlashPositions $position): FlashMessage
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @param  string  $faIcon
     * @return \Laravue\Flash\FlashMessage
     */
    public function setFaIcon(string $faIcon): FlashMessage
    {
        $this->faIcon = str_starts_with($faIcon, 'fa-') ? $faIcon : 'fa-'.$faIcon;

        return $this;
    }

    /**
     * @param  \Laravue\Enums\FontAwesomeTypes  $faType
     * @return \Laravue\Flash\FlashMessage
     */
    public function setFaType(FontAwesomeTypes $faType): FlashMessage
    {
        $this->faType = $faType;

        return $this;
    }

    /**
     * @param  int|false  $timeout
     * @return \Laravue\Flash\FlashMessage
     */
    public function setTimeout(int|false $timeout): FlashMessage
    {
        if ($timeout !== false && $timeout < 1000) {
            $timeout = 1000;
        }
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * @param  bool  $closeOnClick
     * @return \Laravue\Flash\FlashMessage
     */
    public function setCloseOnClick(bool $closeOnClick): FlashMessage
    {
        $this->closeOnClick = $closeOnClick;

        return $this;
    }

    /**
     * @param  bool  $closeOnDrag
     * @return \Laravue\Flash\FlashMessage
     */
    public function setCloseOnDrag(bool $closeOnDrag): FlashMessage
    {
        $this->closeOnDrag = $closeOnDrag;

        return $this;
    }

    /**
     * @param  bool  $pauseOnHover
     * @return \Laravue\Flash\FlashMessage
     */
    public function setPauseOnHover(bool $pauseOnHover): FlashMessage
    {
        $this->pauseOnHover = $pauseOnHover;

        return $this;
    }

    /**
     * @param  bool  $pauseOnFocusLoss
     * @return \Laravue\Flash\FlashMessage
     */
    public function setPauseOnFocusLoss(bool $pauseOnFocusLoss): FlashMessage
    {
        $this->pauseOnFocusLoss = $pauseOnFocusLoss;

        return $this;
    }

    /**
     * @param  bool  $closeButton
     * @return \Laravue\Flash\FlashMessage
     */
    public function setCloseButton(bool $closeButton): FlashMessage
    {
        $this->closeButton = $closeButton;

        return $this;
    }

    /**
     * @param  bool  $showCloseButtonOnlyOnHover
     * @return \Laravue\Flash\FlashMessage
     */
    public function setShowCloseButtonOnlyOnHover(bool $showCloseButtonOnlyOnHover): FlashMessage
    {
        $this->showCloseButtonOnlyOnHover = $showCloseButtonOnlyOnHover;

        return $this;
    }

    /**
     * @param  bool  $hideProgressBar
     * @return \Laravue\Flash\FlashMessage
     */
    public function setHideProgressBar(bool $hideProgressBar): FlashMessage
    {
        $this->hideProgressBar = $hideProgressBar;

        return $this;
    }

    /**
     * @param  bool  $rtl
     * @return \Laravue\Flash\FlashMessage
     */
    public function setRtl(bool $rtl): FlashMessage
    {
        $this->rtl = $rtl;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => uniqid('message_', true),
            'type' => $this->type->value,
            'position' => $this->position->value,
            'message' => $this->message,
            'timeout' => $this->timeout,
            'closeOnClick' => $this->closeOnClick,
            'pauseOnFocusLoss' => $this->pauseOnFocusLoss,
            'pauseOnHover' => $this->pauseOnHover,
            'draggable' => $this->closeOnDrag,
            'showCloseButtonOnHover' => $this->showCloseButtonOnlyOnHover,
            'hideProgressBar' => $this->hideProgressBar,
            'closeButton' => $this->closeButton ? 'button' : false,
            'icon' => sprintf('fa-2x %s %s', $this->faType->value, $this->faIcon),
            'rtl' => $this->rtl,
        ];
    }
}
