<?php

namespace Laravue\Telegram\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * Class ChatInviteLink
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#chatinvitelink
 */
class ChatInviteLink
{
    /**
     * The invite link. If the link was created by another chat administrator, then the second part of the link will be
     * replaced with “…”.
     */
    protected string $invite_link;

    /**
     * Creator of the link
     */
    protected User $creator;

    /**
     * True, if users joining the chat via the link need to be approved by chat administrators
     */
    protected bool $creates_join_request;

    /**
     * True, if the link is primary
     */
    protected bool $is_primary;

    /**
     * True, if the link is revoked
     */
    protected bool $is_revoked;

    /**
     * Optional. Invite link name
     */
    protected ?string $name;

    /**
     * Optional. Point in time (Unix timestamp) when the link will expire or has been expired
     */
    protected ?Carbon $expire_date;

    /**
     * Optional. The maximum number of users that can be members of the chat simultaneously after joining the chat via
     * this invite link; 1-99999
     */
    protected ?int $member_limit;

    /**
     * Optional. Number of pending join requests created using this link
     */
    protected ?int $pending_join_request_count;

    public function __construct(array $payload)
    {
        $this->invite_link = Arr::get($payload, 'invite_link');
        $this->creator = new User(Arr::get($payload, 'creator'));
        $this->creates_join_request = (bool) Arr::get($payload, 'creates_join_request');
        $this->is_primary = (bool) Arr::get($payload, 'is_primary');
        $this->is_revoked = (bool) Arr::get($payload, 'is_revoked');
        $this->name = Arr::get($payload, 'name');
        $this->expire_date = Arr::exists($payload, 'expire_date') ? Carbon::createFromTimestamp(Arr::get($payload, 'expire_date')) : null;
        $this->member_limit = Arr::exists($payload, 'member_limit') ? (int) Arr::get($payload, 'member_limit') : null;
        $this->pending_join_request_count = Arr::exists($payload, 'pending_join_request_count') ? (int) Arr::get($payload, 'pending_join_request_count') : null;
    }

    public function getInviteLink(): string
    {
        return $this->invite_link;
    }

    public function getCreator(): User
    {
        return $this->creator;
    }

    public function isCreatesJoinRequest(): bool
    {
        return $this->creates_join_request;
    }

    public function isIsPrimary(): bool
    {
        return $this->is_primary;
    }

    public function isIsRevoked(): bool
    {
        return $this->is_revoked;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getExpireDate(): ?Carbon
    {
        return $this->expire_date;
    }

    public function getMemberLimit(): ?int
    {
        return $this->member_limit;
    }

    public function getPendingJoinRequestCount(): ?int
    {
        return $this->pending_join_request_count;
    }
}
