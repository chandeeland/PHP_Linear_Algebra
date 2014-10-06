<?php
/**
 * Copyright 2014 David Chan dchan@sigilsoftware.com
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.*
 *
 */

namespace Chandeeland\LinearAlgebra;


/**
 * Vector
 *
 * @uses Matrix
 * @package 
 * @version $id$
 * @copyright 2014 Sigil Inc
 * @author David Chan <dchan@sigilsoftware.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Vector extends Matrix
{
    /**
     * Constructor
     *
     * @param array $data
     * @access protected
     */
    protected function __construct(array $data)
    {
        parent::__construct($data);
        if ($this->getColumns() != 1)
        {
            throw new Exception('multi column vector?');
        }
    }

    /**
     * dotProduct
     *
     * calculate the scalar product using
     * a · b = ax × bx + ay × by + ... + an x bn
     *
     * @param Vector $v1
     * @param Vector $v2
     * @static
     * @access public
     * @return numeric
     */
    public static function dotProduct(Vector $v1, Vector $v2)
    {
        if ($v1->getRows() != $v2->getRows())
        {
            throw new \Exception('Vectors must have matching dimensionality to dot product');
        }

        $v1t = $v1->transpose();
        $product = Matrix::multiply($v1t, $v2);
        return $product[0][0];
    }

    /**
     * crossProduct
     *
     * The Cross Product a × b of two vectors is another vector that is at right angles to both
     *
     * @param Vector $v1
     * @param Vector $v2
     * @static
     * @access public
     * @return Vector
     */
    public static function crossProduct(Vector $a, Vector $b)        
    {
        if (!($b->getRows() == $a->getRows() && $a->getRows() == 3))
        {
            throw new Exception('cross product undefined unless in 3D');
        }
        return Matrix::factory(array(
            array($a[1][0] * $b[2][0] - $a[2][0] * $b[1][0]),
            array($a[2][0] * $b[0][0] - $a[0][0] * $b[2][0]),
            array($a[0][0] * $b[1][0] - $a[1][0] * $b[0][0]),
        ));
    }

    // you can compute higher order "cross products" of n-1 (n dimensional)vectors
    // @TODO
    public static function wedgeProduct(array $vectors) {}

    /**
     * magnitude
     *
     * use pythagoras to calculate the length of vector
     *
     * @access public
     * @return void
     */
    public function magnitude()
    {
        $t = $this->transpose();
        $f = function($value) { return $value * $value; };

        return sqrt(array_sum(array_map($f, $t[0])));        
    }

    /**
     * angle
     *
     * find the angle between vectors using
     * a · b = |a| × |b| × cos(θ)
     * cos(θ) = a · b / |a| × |b| 
     *
     * @param Vector $v1
     * @param Vector $v2
     * @static
     * @access public
     * @return numeric angle in degrees
     */
    public static function angle(Vector $v1, Vector $v2)
    {
        $cosTheta = Vector::dotProduct($v1, $v2) / ($v1->magnitude() * $v2->magnitude());
        return rad2deg(acos($cosTheta));
    }


    /**
     * unitVector
     *
     * Every nonzero vector has a corresponding unit vector, which has the same direction as that vector but a magnitude of 1
     *
     * @access public
     * @return Vector
     */
    public function unitVector()
    {
        return Matrix::multiplication($this, (1/$this->magnitude()));
    }
}
