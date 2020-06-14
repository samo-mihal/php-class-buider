<?php
namespace Digitalwerk\PHPClassBuilder\Object;

/**
 * Class AbstractPHPClassObject
 * @package Digitalwerk\PHPClassBuilder\Object
 */
abstract class AbstractPHPClassObject
{
    /**
     * @var PHPClassObject
     */
    protected $classObject = null;

    /**
     * AbstractPHPClassRender constructor.
     * @param PHPClassObject $classObject
     */
    public function __construct(PHPClassObject $classObject)
    {
        $this->classObject = $classObject;
    }
}
