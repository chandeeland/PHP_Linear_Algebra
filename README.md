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
See the examples/ directory for examples of the key client features.
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
    ));

    printf("\n\n %s A", get_class($A));
    $A->display();

    echo "\n\n A * 3 ";
    $tripleA = Matrix::multiply($A, 3);    
    $trippeA->display();

    echo "\n\n A(t) ";
    $A->transpose()->display();
    

    printf("\n\n %s B", get_class($B));
    
    echo "\n\n A * B";
    Matrix::multiply($A,$B)->display();

?>
```

## Code Quality ##

        phpcs --standard=PSR1 src/
