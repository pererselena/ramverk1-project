<?php

namespace Elpr\Filter;

use Michelf\MarkdownExtra;

/**
 * Filter and format text content.
 */
class TextFilter
{
    /**
     * Format text according to Markdown syntax.
     *
     * @param string $text The text that should be formatted.
     *
     * @return string as the formatted html text.
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function markdown($text)
    {
        return MarkdownExtra::defaultTransform($text);
    }
}
