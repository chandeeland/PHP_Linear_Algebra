<?php

namespace Chandeeland\LinearAlgebra;

class IdentityMatrix extends SquareMatrix
{
    public static function factory($size)
    {
        if (!(is_scalar($size) && is_numeric($size) && ($size = floor($size)) && $size > 0))
        {
            throw new Exception ('bad size');
        }
        $array = array_chunk(array_fill(0, $size * $size, 0), $size);
        for($i = 0; $i < $size; $i++)
        {
            $array[$i][$i] = 1;
        }
        return new IdentityMatrix($array);
    }
}
