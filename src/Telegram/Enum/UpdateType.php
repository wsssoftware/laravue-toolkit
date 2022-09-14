<?php

namespace Laravue\Telegram\Enum;

/**
 * Class ChatType
 *
 * Created by allancarvalho in setembro 14, 2022
 *
 * @link https://core.telegram.org/bots/api#chat
 */
enum UpdateType: int
{
    case MESSAGE = 0;
    case EDITED_MESSAGE = 1;
    case CHANNEL_POST = 2;
    case EDITED_CHANNEL_POST = 3;
    case INLINE_QUERY = 4;
    case CHOSEN_INLINE_RESULT = 5;
    case CALLBACK_QUERY = 6;
    case SHIPPING_QUERY = 7;
    case PRE_CHECKOUT_QUERY = 8;
    case POLL = 9;
    case POLL_ANSWER = 10;
    case MY_CHAT_MEMBER = 11;
    case CHAT_MEMBER = 12;
    case CHAT_JOIN_REQUEST = 13;
}
