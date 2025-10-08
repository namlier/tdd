<?php

declare(strict_types=1);

namespace Namlier\TDD;

final class Greeter
{
    private array $profaneWordsNouns = [
        'crap' => false, 'darn' => false, 'lousy' => false, 'fool' => false, 'idiot' => false, 'loser' => false,
        'junk' => false, 'moron' => false
    ];

    private array $profaneWordsVerbs = [
        'die' => false, 'vanish' => false, 'rot' => false, 'crumble' => false, 'decay' => false,
        'perish' => false, 'break' => false, 'burn' => false, 'choke' => false
    ];

    private array $profaneWordsList;

    public function greet(?string $greetWord = null): string
    {
        $this->ensureWordLength($greetWord);
        $this->ensureItIsNotProfaneWord($greetWord);

        $greetWord = $greetWord ?? 'World';

        return "Hello {$greetWord}!";
    }

    private function ensureWordLength(?string $greetWord = null): void
    {
        if (isset($greetWord) && mb_strlen($greetWord) > 16) {
            throw new \Exception('Greet word is too long!');
        }
    }

    private function ensureItIsNotProfaneWord(?string $greetWord)
    {
        $profaneWordsList = $this->getProfaneWordsList();

        if (isset($profaneWordsList[$greetWord])) {
            throw new \Exception('Profane words are forbidden!');
        }
    }

    private function getProfaneWordsList(): array
    {
        if (!isset($this->profaneWordsList)) {
            $this->profaneWordsList = array_merge($this->profaneWordsVerbs, $this->profaneWordsNouns);
        }

        return $this->profaneWordsList;
    }
}
