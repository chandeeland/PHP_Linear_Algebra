<?php
namespace Chandeeland\LinearAlgebra;

require '../src/Matrix.php';
require '../src/Matrix/Square.php';
require '../src/Matrix/Identity.php';
require '../src/Vector.php';


class MatrixTest extends \PHPUnit_Framework_TestCase
{
    public function testFactoryMatrix()
    {
        $A = Matrix::factory(
            array_chunk(array_keys(array_fill(1,20,0)),5)   
        );
        $this->assertInstanceOf('\Chandeeland\LinearAlgebra\Matrix', $A);
        $this->assertEquals(4, $A->getRows());
        $this->assertEquals(5, $A->getColumns());
    }

    public function testFactorySquareMatrix()
    {
        $A = Matrix::factory(
            array_chunk(array_keys(array_fill(1,25,0)),5)   
        );
        $this->assertInstanceOf('\Chandeeland\LinearAlgebra\Matrix', $A);
        $this->assertInstanceOf('\Chandeeland\LinearAlgebra\SquareMatrix', $A);
        $this->assertEquals(5, $A->getRows());
        $this->assertEquals(5, $A->getColumns());
    }

    public function testFactoryVector()
    {
         $A = Matrix::factory(
            array_chunk(array_keys(array_fill(1,15,0)),1)   
        );
        $this->assertInstanceOf('\Chandeeland\LinearAlgebra\Matrix', $A);
        $this->assertInstanceOf('\Chandeeland\LinearAlgebra\Vector', $A);
        $this->assertEquals(15, $A->getRows());
    }

    public function testFactoryIdentity($size = 5)
    {
        $A = IdentityMatrix::factory($size);

        $this->assertInstanceOf('\Chandeeland\LinearAlgebra\Matrix', $A);
        $this->assertInstanceOf('\Chandeeland\LinearAlgebra\IdentityMatrix', $A);
        $this->assertEquals($size, $A->getRows());
        $this->assertEquals($size, $A->getColumns());

        for ($i = 0; $i < $size; $i++)
        {
            for ($j = 0; $j < $size; $j++)
            {
                if ($i == $j) 
                {
                    $this->assertEquals(1, $A[$i][$j]);
                }
                else
                {
                    $this->assertEquals(0, $A[$i][$j]);
                }
            }
        }
    }

    public function testScalarMultiplication()
    {
        $A = Matrix::factory(array(
                array(1,3),
                array(2,2),
                array(3,1),
                array(4,0),
        ));

        $expected = Matrix::factory(array(
                array(3,9),
                array(6,6),
                array(9,3),
                array(12,0),
        ));

        $A3 = Matrix::multiply($A, 3);
        $this->assertEquals($expected, $A3);
    }

    public function testMatrixMultiplication()
    {
        $C = Matrix::factory(array(
                    array(1,3),
                    array(2,2),
                    array(3,1),
                    array(4,0),
                    ));

        $D = Matrix::factory(array(
                    array(10,100,1000),
                    array(4,2,1),
                    )); 
        $expected = Matrix::factory(  array (
                0 => 
                array(
                    0 => 22,
                    1 => 106,
                    2 => 1003,
                    ),
                1 => 
                array (
                    0 => 28,
                    1 => 204,
                    2 => 2002,
                    ),
                2 => 
                array (
                    0 => 34,
                    1 => 302,
                    2 => 3001,
                    ),
                3 => 
                array (
                    0 => 40,
                    1 => 400,
                    2 => 4000,
                    ),
                ));

        $CD = Matrix::multiply($C,$D);
        $this->assertEquals($expected, $CD);
    }

    public function testDensity()
    {
        $I = IdentityMatrix::factory(10);
        $sparcity = $I->sparsity();
        $density = $I->density();
        $this->assertEquals(1, $sparcity + $density);

        $this->assertEquals(.9, $sparcity);
        $this->assertEquals(.1, $density);
    }
}


/*

$B = Matrix::factory(
        array_chunk(array_keys(array_fill(1,20,0)),4)   
    );



$E = Matrix::factory(array(
    array(42,19,0),
    array(-98,-8,15),
    array(1,2,3),
));

$V = Matrix::factory(array(
    array(1),
    array(5),
    array(-11),
    array(0),
));

$I3 = Matrix::factory(array(
    array(1,0,0),
    array(0,1,0),
    array(0,0,1),
));

function scalar_multi_test(Matrix $A)
{
    echo "\n\n original matrix A (5x5)";
    $A->display();

    echo "\n\n multiply A * 3";
    $A1 = Matrix::multiply($A, 3);
    $A1->display();

    echo "\n\n multiply 4 * A (commutative)";
    $A2 = Matrix::multiply(4, $A);
    $A2->display();
}

function transpose_test(Matrix $A)
{
    echo "\n\n transpose A";
    $A->display();
    $A = $A->transpose();
    echo "\n";
    $A->display();
    $A = $A->transpose();
    echo "\n";
    $A->display();
    $A = $A->transpose();
    echo "\n";
    $A->display();
    $A = $A->transpose();
    echo "\n";
    $A->display();
    $A = $A->transpose();

}

function add_test(Matrix $A, Matrix $B)
{
    echo "\n\n Matrix A";
    $A->display();

    echo "\n\n Matrix B";
    $B->display();
    echo "\n\n add A + B";
    Matrix::add($A,$B)->display();

    echo "\n\n";
}


function multi_test(Matrix $A, Matrix $B)
{
    echo "\n\n Matrix A (4x2)";
    $A->display();

    echo "\n\n Matrix B (2x3)";
    $B->display();
    echo "\n\n multiply A * B";
    Matrix::multiply($A,$B)->display();

    echo "\n\n";
}

scalar_multi_test($A);
multi_test($C,$D);
multi_test($E,$I3);

add_test($E,$I3);
add_test($E,$E);

transpose_test($I3);
*/
