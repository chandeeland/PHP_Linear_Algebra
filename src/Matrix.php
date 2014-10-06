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
 * Matrix
 *
 * @uses ArrayAccess
 * @package 
 * @version $id$
 * @copyright 2014 Sigil Inc
 * @author David Chan <dchan@sigilsoftware.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class Matrix implements \ArrayAccess
{
    /**
     * rows 
     *
     * @var int
     * @access private
     */
    private $rows;

    /**
     * columns 
     *
     * @var int
     * @access private
     */
    private $columns;

    /**
     * data 
     *
     * @var array
     * @access protected
     */
    protected $data = array();

    /**
     * Constructor
     *
     * enforces use of factory
     *
     * @param array $data
     * @access protected
     */
    protected function __construct(array $data)
    {
        $this->data = array_map('array_values',$data);
        $this->rows = count($this->data);
        $this->columns = count(end($this->data));
    }

    /**
     * factory
     *
     * differentiate between matrix types
     *
     * @param array $data
     * @static
     * @access public
     * @return Matrix Object
     */
    public static function factory(array $data)
    {
        $data = array_values($data);

        if(!($rows = count($data)))
        {
            throw new \Exception('zero row matrix?');
        }
        
        if (!($columns = count(current($data))))
        {
            throw new \Exception('zero column matrix?');
        }

        if (array_map('count', $data) !== array_fill(0, $rows, $columns))
        {
            throw new \Exception('matrix columns are inconsistent');
        }
        
        if ($columns == 1)
        {
            return new Vector($data);
        }
        else if ($rows == $columns)
        {
            return new SquareMatrix($data);
        }
        else
        {
            return new Matrix($data);
        }
    }

    /**
     * offsetSet
     *
     * required to implement ArrayAccess
     *
     * @see ArrayAccess    
     *
     * @param mixed $offset
     * @param mixed $value
     * @access public
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        throw new \Exception('You cant do that');
    }

    /**
     * offsetGet
     *
     * required to implement ArrayAccess
     *
     * @see ArrayAccess    
     *
     * @param mixed $offset
     * @access public
     * @return array
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * offsetExists
     *
     * required to implement ArrayAccess
     *
     * @see ArrayAccess    
     * @param mixed $offset
     * @access public
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    /**
     * offsetUnset
     *
     * required to implement ArrayAccess
     *
     * @see ArrayAccess
     * @param mixed $offset
     * @access public
     * @return void
     */
    public function offsetUnset($offset)
    {
        throw new \Exception('You cant do that');        
    }

    /**
     * getColumns
     *
     * @access public
     * @return int
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * getRows
     *
     * @access public
     * @return int
     */
    public function getRows()
    {
        return $this->rows;
    }


    /**
     * transpose
     *
     * get transpose of myself
     *
     * @access public
     * @return Matrix Object
     */
    public function transpose()
    {
        $array = $this->data;
        array_unshift($array, null);
        return Matrix::factory(call_user_func_array('array_map', $array));
    }

    /**
     * all
     *
     * @param Callable $f
     * @access protected
     * @return Matrix Object
     */
    protected function all(Callable $f)
    {
        $curr = $this->data;
        $output = array();
        foreach ($curr as $i => $rows)
        {
            $output[$i] = array_map($f, $rows);
        }
        return Matrix::factory($output);
    }

    /**
     * add
     *
     * sum of two compatible matrixes
     *
     * @param Matrix $a
     * @param Matrix $b
     * @static
     * @access public
     * @return Matrix Object
     */
    public static function add(Matrix $a, Matrix $b)
    {
        if ($a->getRows() != $b->getRows() || $a->getColumns() != $b->getColumns())
        {
            throw new \Exception('Incompatable matrix addition');
        }
    
        $c = array();
        for ($i = 0; $i < $a->getRows(); $i++)
        {
            $c[$i] = array();
            for ($j = 0; $j < $a->getColumns(); $j++)
            {
                $c[$i][$j] = $a[$i][$j] + $b[$i][$j];
            }
        }
        return Matrix::factory($c);
    }


    /**
     * multiply
     *
     * product of two compatable matrixes or matrix and scalar
     *
     * @param mixed $a
     * @param mixed $b
     * @static
     * @access public
     * @return void
     */
    public static function multiply($a, $b)
    {
        if (is_scalar($a) && $b instanceof Matrix) 
        {
            return Matrix::multiply($b, $a);
        } 
        else if (is_scalar($b) && $a instanceof Matrix)
        {
            $callback = function($value) use ($b) { return $value * $b ; };
            return $a->all($callback);
        }
        else if ($a instanceof Matrix && $b instanceof Matrix)
        {
            if ($a->getColumns() != $b->getRows())
            {
                throw new \Exception(sprintf('incompatable multiplicands, expects nxm * mxp = nxp, but got %dx%d * %dx%d where %d != %d'
                        ,$a->getRows(), $a->getColumns()
                        ,$b->getRows(), $b->getColumns()
                        ,$a->getColumns(), $b->getRows()
                    ));
            }

            $ab = array();
            $t = $b->transpose();

            $f = function($v1, $v2) { return $v1 * $v2; } ;
            
            for ($i = 0; $i < $a->getRows(); $i++)
            {
                $ab[$i] = array();
                for ($j = 0; $j < $b->getColumns(); $j++)
                {
                    $ab[$i][$j] = array_sum(array_map($f, $a[$i], $t[$j]));
                }
            }
            return Matrix::factory($ab);
        }
    }

    /**
     * sparsity
     *
     * @access public
     * @return numeric
     */
    public function sparsity()
    {
        $total_elements = $this->getRows() * $this->getColumns();
        $zeros = 0;

        foreach ($this->data as $row)
        {
            foreach ($row as $item)
            {
                if ($item == 0 )
                {
                    $zeros++;
                }
            }
        }
        return $zeros/$total_elements;
    }

    /**
     * density
     *
     * @access public
     * @return numeric
     */
    public function density()
    {
        return 1 - $this->sparsity();
    }

    /**
     * display
     *
     * useful for cli and debugging
     *
     * @access public
     * @return void
     */
    public function display()
    {
        $maxf = function($row) { return max(array_map('strlen', $row)); };
        $max = 1 + max(array_map($maxf, $this->data));
        
        $spacerf = function($me) use ($max) {
            return sprintf("%s%s", implode(' ', array_fill(0,$max - strlen($me) + 1,'')), $me);
        };

        foreach ($this->data as $row)
        {
            printf("\n%s", implode('', array_map($spacerf, $row)));
        }
    }

    public function export($print = false)
    {
        return var_export($this->data, !$print);
    }

}

