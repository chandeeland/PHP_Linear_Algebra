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
 * Square_Matrix
 *
 * @uses Matrix
 * @copyright 2014 Sigil Inc
 * @author David Chan <dchan@sigilsoftware.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */
class SquareMatrix extends Matrix
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
        if ($this->getColumns() != $this->getRows())
        {
            throw new Exception('not square');
        }
    }

}
