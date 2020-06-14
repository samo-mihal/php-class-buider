<?php
namespace Digitalwerk\PHPClassBuilder\Render;

use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;

/**
 * Class AbstractPHPClassRender
 * @package Digitalwerk\PHPClassBuilder\Render
 */
abstract class AbstractPHPClassRender
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
