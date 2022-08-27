<?php

namespace Laravue\Utility;

class Text
{
    /**
     * Creates a comma separated list where the last two items are joined with 'and', forming natural language.
     *
     * @param  string[]  $list The list to be joined.
     * @param  array  $options The options to be used.
     *      - string and: The word used to join the last and second last items together with. Defaults to 'e'
     *      - string separator: The separator to be used between each item. Defaults to ', '
     *      - string involve: Involve each item with a char. Defaults to false
     * @return string The glued together string.
     *
     * @link https://book.cakephp.org/3/en/core-libraries/text.html#converting-an-array-to-sentence-form
     */
    public function toList(array $list, array $options = []): string
    {
        $options += [
            'and' => __('e'),
            'separator' => ', ',
            'involve' => false,
        ];
        if ($options['involve'] !== false) {
            foreach ($list as $index => $item) {
                $list[$index] = $options['involve'].$item.$options['involve'];
            }
        }
        if (count($list) > 1) {
            return implode($options['separator'], array_slice($list, 0, -1)).' '.$options['and'].' '.array_pop($list);
        }

        return (string) array_pop($list);
    }
}
