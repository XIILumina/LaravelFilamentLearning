<?php

namespace App\Services;

class TextFilterService
{
    /**
     * List of inappropriate words and slurs to filter
     * In a production app, you might want to use a dedicated library
     * or load these from a database
     */
    private array $forbiddenWords = [
        // Slurs and offensive language (kept minimal for example)
        // Note: In production, use a proper word filter library
        'nword', 'n-word',
        // Add more as needed based on your community standards
    ];

    /**
     * Check if text contains inappropriate content
     * 
     * @param string $text
     * @return bool
     */
    public function containsInappropriateContent(string $text): bool
    {
        $text = strtolower($text);
        
        foreach ($this->forbiddenWords as $word) {
            // Match word with word boundaries to catch variations
            if (preg_match('/\b' . preg_quote($word, '/') . '\b/i', $text)) {
                return true;
            }
            
            // Also check with common character substitutions (l33tspeak)
            $variations = $this->generateVariations($word);
            foreach ($variations as $variation) {
                if (str_contains(strtolower($text), $variation)) {
                    return true;
                }
            }
        }
        
        return false;
    }

    /**
     * Generate common variations of a word (l33tspeak, spacing, etc.)
     * 
     * @param string $word
     * @return array
     */
    private function generateVariations(string $word): array
    {
        $variations = [$word];
        
        // Add variations with spacing
        $variations[] = implode(' ', str_split($word));
        
        // Add l33tspeak variations
        $l33tMap = [
            'a' => ['@', '4'],
            'e' => ['3'],
            'i' => ['1', '!'],
            'o' => ['0'],
            's' => ['5', '$'],
            't' => ['7'],
            'l' => ['1'],
            'g' => ['9'],
        ];
        
        foreach ($l33tMap as $letter => $replacements) {
            foreach ($replacements as $replacement) {
                $variations[] = str_replace($letter, $replacement, $word);
            }
        }
        
        return $variations;
    }

    /**
     * Sanitize text by replacing inappropriate content
     * 
     * @param string $text
     * @return string
     */
    public function sanitize(string $text): string
    {
        $text = strtolower($text);
        
        foreach ($this->forbiddenWords as $word) {
            $replacement = str_repeat('*', strlen($word));
            
            // Replace exact word matches
            $text = preg_replace('/\b' . preg_quote($word, '/') . '\b/i', $replacement, $text);
            
            // Replace variations
            $variations = $this->generateVariations($word);
            foreach ($variations as $variation) {
                $varReplacement = str_repeat('*', strlen($variation));
                $text = str_ireplace($variation, $varReplacement, $text);
            }
        }
        
        return $text;
    }

    /**
     * Get the forbidden words list
     * 
     * @return array
     */
    public function getForbiddenWords(): array
    {
        return $this->forbiddenWords;
    }

    /**
     * Add a word to the forbidden list
     * 
     * @param string $word
     * @return void
     */
    public function addForbiddenWord(string $word): void
    {
        if (!in_array(strtolower($word), $this->forbiddenWords)) {
            $this->forbiddenWords[] = strtolower($word);
        }
    }

    /**
     * Remove a word from the forbidden list
     * 
     * @param string $word
     * @return void
     */
    public function removeForbiddenWord(string $word): void
    {
        $this->forbiddenWords = array_filter(
            $this->forbiddenWords,
            fn($w) => strtolower($w) !== strtolower($word)
        );
    }
}
