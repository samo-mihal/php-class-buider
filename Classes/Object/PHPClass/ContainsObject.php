<?php
namespace Digitalwerk\PHPClassBuilder\Object\PHPClass;

use Digitalwerk\PHPClassBuilder\Object\AbstractPHPClassObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;

/**
 * Class ContainsObject
 * @package Digitalwerk\PHPClassBuilder\Object\PHPClass
 */
class ContainsObject extends AbstractPHPClassObject
{
    /**
     * ContainsObject constructor.
     * @param PHPClassObject $classObject
     */
    public function __construct(PHPClassObject $classObject)
    {
        parent::__construct($classObject);
    }

    /**
     * @param $name
     * @return bool
     */
    public function usedClass($name): bool
    {
        if ($this->classObject->getUsedClasses()) {
            /** @var UsedClassObject $usedClass */
            foreach ($this->classObject->getUsedClasses() as $usedClass) {
                if ($usedClass->getName() === $name) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }

    /**
     * @param $name
     * @return bool
     */
    public function trait($name): bool
    {
        if ($this->classObject->getTraits()) {
            /** @var TraitObject $trait */
            foreach ($this->classObject->getTraits() as $trait) {
                if ($trait->getName() === $name) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }

    /**
     * @param $name
     * @return bool
     */
    public function constant($name): bool
    {
        if ($this->classObject->getConstants()) {
            /** @var ConstantObject $constant */
            foreach ($this->classObject->getConstants() as $constant) {
                if ($constant->getName() === $name) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }

    /**
     * @param $name
     * @return bool
     */
    public function function($name): bool
    {
        if ($this->classObject->getFunctions()) {
            /** @var FunctionObject $function */
            foreach ($this->classObject->getFunctions() as $function) {
                if ($function->getName() === $name) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }

    /**
     * @param $name
     * @return bool
     */
    public function variable($name): bool
    {
        if ($this->classObject->getVariables()) {
            /** @var VariableObject $variable */
            foreach ($this->classObject->getVariables() as $variable) {
                if ($variable->getName() === $name) {
                    return true;
                    break;
                }
            }
        }
        return false;
    }
}
