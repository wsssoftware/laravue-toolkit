<?php
/*
 * Copyright (c) Alô Cozinha 2022. All right reserved.
 */

namespace Laravue\Utility\Documents;

/**
 * Class DocumentBase
 *
 * Created by allancarvalho in outubro 11, 2022
 */
abstract class DocumentBase
{
    abstract protected function validate(string $document): bool;

    abstract protected function random(): string;

    /**
     * Authenticate a document
     */
    protected function authenticate(string $document, int $limit, array $digitOne, array $digitTwo): bool
    {
        $document = $this->sanitize($document);
        $myDoc = $this->mountArray($document, $limit);
        $authDoc = $this->verify($document, $limit, $digitOne, $digitTwo);

        return $myDoc == $authDoc && ! $this->isAllValueEqual($myDoc);
    }

    protected function sanitize(string $document): string
    {
        return preg_replace('/[^0-9]/', '', $document);
    }

    protected function mountArray(string $document, int $limit): array
    {
        return strlen($document) == $limit && is_numeric($document) ? str_split($document) : [];
    }

    protected function verify(string $document, int $limit, array $digitOne, array $digitTwo): array
    {
        $myDoc = $this->mountArray($document, $limit);
        $i = count($myDoc) - 2;
        $y = count($myDoc) - 1;
        $myDoc[$i] = $this->computerOne($document, $limit, $digitOne);
        $myDoc[$y] = $this->computerTwo($document, $limit, $digitOne, $digitTwo);

        return $myDoc;
    }

    /**
     * Calculate first digit
     */
    protected function computerOne(string $document, int $limit, array $digitOne): int
    {
        $total = 0;
        $result = 0;
        $docAux = $this->mountArray($document, $limit); // montar array
        if (! empty($docAux)) {
            for ($i = 0; $i < count($digitOne); $i++) {
                $result += ($docAux[$i] * $digitOne[$i]);
            }
            $resto = ($result % 11);
            $check = $resto < 2 ? 0 : $resto;
            if ($check == 0) {
                return $check;
            }
            $total = abs(11 - $resto);
        }

        return $total;
    }

    /**
     * Calculate seconds digit
     */
    protected function computerTwo(string $document, int $limit, array $digitOne, array $digitTwo): int
    {
        $total = 0;
        $result = 0;
        $docAux = $this->mountArray($document, $limit);
        if (! empty($docAux)) {
            $position = count($docAux) - 2;
            $docAux[$position] = $this->computerOne($document, $limit, $digitOne);
            for ($i = 0; $i < count($digitTwo); $i++) {
                $result += ($docAux[$i] * $digitTwo[$i]);
            }
            $resto = ($result % 11);
            $check = $resto < 2 ? 0 : $resto;
            if ($check == 0) {
                return $check;
            }
            $total = abs(11 - $resto);
        }

        return $total;
    }

    protected function isAllValueEqual(array $data): bool
    {
        $value = count(array_unique($data));

        return $value <= 1;
    }

    protected function make(int $limit, array $digitOne, array $digitTwo): string
    {
        $document = '';
        for ($i = 0; $i < $limit; $i++) {
            $document .= rand(0, 9);
        }
        $newDoc = $this->verify($document, $limit, $digitOne, $digitTwo);

        return ! $this->isAllValueEqual($newDoc) ? implode($newDoc) : 'Algo deu errado';
    }
}
