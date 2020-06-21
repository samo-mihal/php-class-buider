<?php
namespace Digitalwerk\PHPClassBuilder\Object\PHPClass;

use Digitalwerk\PHPClassBuilder\Object\AbstractPHPClassObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;

/**
 * Class UsedClassObject
 * @package Digitalwerk\PHPClassBuilder\Object\PHPClass
 */
class UsedClassObject extends AbstractPHPClassObject
{
    /**
     * UsedClassesObject constructor.
     * @param PHPClassObject $classObject
     */
    public function __construct(PHPClassObject $classObject)
    {
        parent::__construct($classObject);
    }

    /**
     * UsedClassesObject destructor.
     */
    public function __destruct()
    {
        $this->setUsedClass();
    }

    /**
     * @return void
     */
    private function setUsedClass(): void
    {
        $usedClasses = $this->classObject->getUsedClasses();
        $usedClasses[] = $this;
        $this->classObject->setUsedClasses($usedClasses);
    }

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return UsedClassObject
     */
    public function setName(string $name): UsedClassObject
    {
        $this->name = $name;
        return $this;
    }
}
