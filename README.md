# PHP Linear Algebra Matrix Math Library #

## Description ##
This library Aims to provide Basic Matrix representations suitable for Linear Algebra calculation in PHP

* Matrix                            [done]
* Vector Representation             [done]
* Matrix * Scalar Multiplication    [done]
* Matrix * Matrix Multiplication    [done]
* Matrix Transposition              [done]
* Matrix Decomposition
* Matrix Inversion
* Matrix Sparsity/Density Calculation [done]


## Beta ##
This library is in Beta and not feature complete.
I've implemented simple data structures and basic functionality but it's still a long way from ready


## Requirements ##
* [PHP 5.3 or higher](http://www.php.net/)

## Installation ##

        update composer.json to inlude     

        php composer.phar install

## Basic Example ##
See the examples.php directory for examples of the key client features.
```PHP
<?php

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
```

Outputs

```
$ php example.php 


 Chandeeland\LinearAlgebra\Matrix A
  1  2  3  4
 10 20 30 40
 -1 -2 -3 -4

 Matrix * Scalar example: A * 3 
   3   6   9  12
  30  60  90 120
  -3  -6  -9 -12

 Transposition:  A(t) 
  1 10 -1
  2 20 -2
  3 30 -3
  4 40 -4

 Chandeeland\LinearAlgebra\Matrix B
   0   1 0.2
   5  -1   2
  -2   3 0.3
   0   1   0

 Matrix Multiplcation A * B
    4   12  5.1
   40  120   51
   -4  -12 -5.1

 generate I10 
 1 0 0 0 0 0 0 0 0 0
 0 1 0 0 0 0 0 0 0 0
 0 0 1 0 0 0 0 0 0 0
 0 0 0 1 0 0 0 0 0 0
 0 0 0 0 1 0 0 0 0 0
 0 0 0 0 0 1 0 0 0 0
 0 0 0 0 0 0 1 0 0 0
 0 0 0 0 0 0 0 1 0 0
 0 0 0 0 0 0 0 0 1 0
 0 0 0 0 0 0 0 0 0 1

 addition example I10 + I10
 2 0 0 0 0 0 0 0 0 0
 0 2 0 0 0 0 0 0 0 0
 0 0 2 0 0 0 0 0 0 0
 0 0 0 2 0 0 0 0 0 0
 0 0 0 0 2 0 0 0 0 0
 0 0 0 0 0 2 0 0 0 0
 0 0 0 0 0 0 2 0 0 0
 0 0 0 0 0 0 0 2 0 0
 0 0 0 0 0 0 0 0 2 0
 0 0 0 0 0 0 0 0 0 2


```

## Code Quality ##

        phpcs --standard=PSR1 src/
