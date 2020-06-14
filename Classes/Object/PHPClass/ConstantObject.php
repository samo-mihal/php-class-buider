<?php
namespace Digitalwerk\PHPClassBuilder\Object\PHPClass;

use Digitalwerk\PHPClassBuilder\Object\AbstractPHPClassObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;

/**
 * Class ConstantObject
 * @package Digitalwerk\PHPClassBuilder\Object\PHPClass
 */
class ConstantObject extends AbstractPHPClassObject
{
    /**
     * ConstantObject constructor.
     * @param PHPClassObject $classObject
     */
    public function __construct(PHPClassObject $classObject)
    {
        parent::__construct($classObject);
    }

    /**
     * ConstantsObject destructor.
     */
    public function __destruct()
    {
        $this->setConstants();
    }

    /**
     * @return void
     */
    private function setConstants(): void
    {
        $constants = $this->classObject->getConstants();
        $constants[] = $this;
        $this->classObject->setConstants($constants);
    }

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $value = '';

    /**
     * @var string
     */
    protected $comment = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return ConstantObject
     */
    public function setName(string $name): ConstantObject
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return ConstantObject
     */
    public function setComment(string $comment): ConstantObject
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return ConstantObject
     */
    public function setValue(string $value): ConstantObject
    {
        $this->value = $value;
        return $this;
    }
}
