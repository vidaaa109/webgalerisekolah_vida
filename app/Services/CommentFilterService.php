<?php

namespace App\Services;

class CommentFilterService
{
    protected array $badWords;

    public function __construct()
    {
        $words = config('badwords.words', []);
        $this->badWords = array_values(array_filter(array_map(static function ($word) {
            return trim($word ?? '');
        }, $words), static function ($word) {
            return $word !== '';
        }));
    }

    public function evaluate(string $text): array
    {
        $flaggedWords = [];
        $filteredText = $text;

        foreach ($this->badWords as $word) {
            $pattern = '/\b' . preg_quote($word, '/') . '\b/i';

            if (preg_match($pattern, $filteredText)) {
                $flaggedWords[] = $word;
                $filteredText = preg_replace_callback($pattern, function ($matches) {
                    return str_repeat('*', strlen($matches[0]));
                }, $filteredText);
            }
        }

        $status = empty($flaggedWords) ? 'visible' : 'draft';
        $moderationNote = empty($flaggedWords)
            ? null
            : 'Auto flagged words: ' . implode(', ', array_unique($flaggedWords));

        return [
            'body' => $filteredText,
            'status' => $status,
            'moderation_note' => $moderationNote,
            'flagged_words' => $flaggedWords,
        ];
    }
}

