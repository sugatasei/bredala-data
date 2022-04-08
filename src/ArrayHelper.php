<?php

namespace Bredala\Data;

class ArrayHelper
{
    public static function extract(array $data, array $keys): array
    {
        $out = [];
        foreach ($keys as $key) {
            $out[$key] = $data[$key] ?? null;
        }

        return $out;
    }

    /**
     * Renames keys from an array
     *
     * @param array $input
     * @param array $replace : ['oldName' => 'newName']
     * @return array
     */
    public static function renameKeys(array $input, array $replace): array
    {
        $output = [];

        foreach ($input as $key => $value) {
            if (isset($replace[$key])) {
                $key = $replace[$key];
            }
            $output[$key] = $value;
        }

        return $output;
    }

    /**
     * Ajoute un préfixe aux clés d'un tableau
     *
     * @param array $input
     * @param string $prefix
     * @return array
     */
    public static function addPrefix(array $input, string $prefix): array
    {
        foreach ($input as $key => $value) {
            $input[$prefix . $key] = $value;
            unset($input[$key]);
        }

        return $input;
    }

    /**
     * Supprime les préfixes des clés d'un tableau
     * Utilisation sur un tableau de tableau :
     *
     * @param array $input
     * @param string $prefix
     * @return array
     */
    public static function removePrefix(array $input, string $prefix): array
    {
        if (!$input || !$prefix) return [];

        $output = [];
        $len = mb_strlen($prefix);

        foreach ($input as $key => $value) {
            if (mb_strpos($key, $prefix) === 0) {
                $key = mb_substr($key, $len);
            }

            $output[$key] = $value;
        }

        return $output;
    }

    /**
     * Returns difference between two arrays
     *
     * @param array $new
     * @param array $old
     */
    public static function diff(array $new, array $old): array
    {
        $out = [];

        foreach ($new as $key => $value) {
            if (array_key_exists($key, $old)) {
                if ($value != $old[$key]) {
                    $out[$key] = $value;
                }
            } else {
                $out[$key] = $value;
            }
        }
        return $out;
    }

    /**
     * Returns recursive difference between two arrays
     *
     * @param array $new
     * @param array $old
     */
    public static function diffRecursive(array $new, array $old): array
    {
        $out = [];

        foreach ($new as $key => $value) {
            if (array_key_exists($key, $old)) {
                if (is_array($value)) {
                    if (($diff = self::diffRecursive($value, $old[$key]))) {
                        $out[$key] = $diff;
                    }
                } else {
                    if ($value != $old[$key]) {
                        $out[$key] = $value;
                    }
                }
            } else {
                $out[$key] = $value;
            }
        }
        return $out;
    }

    // -------------------------------------------------------------------------
}
