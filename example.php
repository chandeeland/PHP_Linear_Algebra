<?php
namespace Chandeeland\LinearAlgebra;

require 'src/Matrix.php';
require 'src/Matrix/Square.php';
require 'src/Matrix/Identity.php';

$A = Matrix::factory(array(
            array(1,2,3,4),
            array(10,20,30,40),
            array(-1,-2,-3,-4),
            ));

$B = Matrix::factory(array(
            array(0,1,.2),
            array(5,-1,2),
            array(-2,3,.3),
            array(0,1,0),
            ));

// display 
printf("\n\n %s A", get_class($A));
$A->display();

// scalar multiplication 
echo "\n\n Matrix * Scalar example: A * 3 ";
$tripleA = Matrix::multiply($A, 3);    
$tripleA->display();

// transpose of A
echo "\n\n Transposition:  A(t) ";
$A->transpose()->display();


printf("\n\n %s B", get_class($B));
$B->display();


// matrix multiplication
echo "\n\n Matrix Multiplcation A * B";
Matrix::multiply($A,$B)->display();


// identity matrix 
echo "\n\n generate I10 ";
$I10 = IdentityMatrix::factory(10);
$I10->display();


echo "\n\n addition example I10 + I10";
Matrix::add($I10, $I10)->display();

echo "\n\n";

?>
