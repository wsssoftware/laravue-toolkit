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
    protected FlashTypes $type = FlashTypes::DEFAULT;

    protected FlashPositions $position = FlashPositions::TOP_RIGHT;

    protected string $faIcon = 'fa-circle-info';

    protected FontAwesomeTypes $faType = FontAwesomeTypes::SOLID;

    protected int|false $timeout = 5000;

    protected bool $closeOnClick = true;

    protected bool $closeOnDrag = true;

    protected bool $pauseOnHover = true;

    protected bool $pauseOnFocusLoss = true;

    protected bool $closeButton = true;

    protected bool $showCloseButtonOnlyOnHover = false;

    protected bool $hideProgressBar = false;

    protected bool $rtl = false;

    protected string|false $title;

    protected string $message;

    public function __construct(
        string $message,
        FlashTypes $type,
        ?string $faIcon,
        string|false $title = false
    ) {
        $this->message = $message;
        $this->type = $type;
        if (! empty($faIcon)) {
            $this->setFaIcon($faIcon);
        }
        $this->title = $title;
    }

    /**
     * @return \Laravue\Flash\FlashMessage
     */
    public function setPosition(FlashPositions $position): FlashMessage
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return \Laravue\Flash\FlashMessage
     */
    public function setFaIcon(string $faIcon): FlashMessage
    {
        $this->faIcon = str_starts_with($faIcon, 'fa-') ? $faIcon : 'fa-'.$faIcon;

        return $this;
    }

    /**
     * @return \Laravue\Flash\FlashMessage
     */
    public function setFaType(FontAwesomeTypes $faType): FlashMessage
    {
        $this->faType = $faType;

        return $this;
    }

    /**
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
     * @return \Laravue\Flash\FlashMessage
     */
    public function setCloseOnClick(bool $closeOnClick): FlashMessage
    {
        $this->closeOnClick = $closeOnClick;

        return $this;
    }

    /**
     * @return \Laravue\Flash\FlashMessage
     */
    public function setCloseOnDrag(bool $closeOnDrag): FlashMessage
    {
        $this->closeOnDrag = $closeOnDrag;

        return $this;
    }

    /**
     * @return \Laravue\Flash\FlashMessage
     */
    public function setPauseOnHover(bool $pauseOnHover): FlashMessage
    {
        $this->pauseOnHover = $pauseOnHover;

        return $this;
    }

    /**
     * @return \Laravue\Flash\FlashMessage
     */
    public function setPauseOnFocusLoss(bool $pauseOnFocusLoss): FlashMessage
    {
        $this->pauseOnFocusLoss = $pauseOnFocusLoss;

        return $this;
    }

    /**
     * @return \Laravue\Flash\FlashMessage
     */
    public function setCloseButton(bool $closeButton): FlashMessage
    {
        $this->closeButton = $closeButton;

        return $this;
    }

    /**
     * @return \Laravue\Flash\FlashMessage
     */
    public function setShowCloseButtonOnlyOnHover(bool $showCloseButtonOnlyOnHover): FlashMessage
    {
        $this->showCloseButtonOnlyOnHover = $showCloseButtonOnlyOnHover;

        return $this;
    }

    /**
     * @return \Laravue\Flash\FlashMessage
     */
    public function setHideProgressBar(bool $hideProgressBar): FlashMessage
    {
        $this->hideProgressBar = $hideProgressBar;

        return $this;
    }

    /**
     * @return \Laravue\Flash\FlashMessage
     */
    public function setRtl(bool $rtl): FlashMessage
    {
        $this->rtl = $rtl;

        return $this;
    }

    public function setTitle(string|false $title): FlashMessage
    {
        $this->title = $title;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => uniqid('message_', true),
            'type' => $this->type->value,
            'position' => $this->position->value,
            'title' => $this->title,
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
            'icon_array' => [
                'size' => '2x',
                'type' => $this->faType->getType(),
                'icon' => str($this->faIcon)->after('fa-')->toString(),
            ],
            'rtl' => $this->rtl,
        ];
    }
}
