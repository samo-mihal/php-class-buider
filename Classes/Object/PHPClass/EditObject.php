<?php
namespace Digitalwerk\PHPClassBuilder\Object\PHPClass;

use Digitalwerk\PHPClassBuilder\Object\AbstractPHPClassObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;

/**
 * Class EditObject
 * @package Digitalwerk\PHPClassBuilder\Object\PHPClass
 */
class EditObject extends AbstractPHPClassObject
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
     * @return UsedClassObject|null
     */
    public function usedClass($name): ? UsedClassObject
    {
        if ($this->classObject->getUsedClasses()) {
            /** @var UsedClassObject $usedClass */
            foreach ($this->classObject->getUsedClasses() as $usedClass) {
                if ($usedClass->getName() === $name) {
                    return $usedClass;
                    break;
                }
            }
        }
        return null;
    }

    /**
     * @param $name
     * @return TraitObject|null
     */
    public function trait($name): ? TraitObject
    {
        if ($this->classObject->getTraits()) {
            /** @var TraitObject $trait */
            foreach ($this->classObject->getTraits() as $trait) {
                if ($trait->getName() === $name) {
                    return $trait;
                    break;
                }
            }
        }
        return null;
    }

    /**
     * @param $name
     * @return ConstantObject|null
     */
    public function constant($name): ? ConstantObject
    {
        if ($this->classObject->getConstants()) {
            /** @var ConstantObject $constant */
            foreach ($this->classObject->getConstants() as $constant) {
                if ($constant->getName() === $name) {
                    return $constant;
                    break;
                }
            }
        }
        return null;
    }

    /**
     * @param $name
     * @return FunctionObject|null
     */
    public function function($name): ? FunctionObject
    {
        if ($this->classObject->getFunctions()) {
            /** @var FunctionObject $function */
            foreach ($this->classObject->getFunctions() as $function) {
                if ($function->getName() === $name) {
                    return $function;
                    break;
                }
            }
        }
        return null;
    }

    /**
     * @param $name
     * @return VariableObject|null
     */
    public function variable($name): ? VariableObject
    {
        if ($this->classObject->getVariables()) {
            /** @var VariableObject $variable */
            foreach ($this->classObject->getVariables() as $variable) {
                if ($variable->getName() === $name) {
                    return $variable;
                    break;
                }
            }
        }
        return null;
    }
}
