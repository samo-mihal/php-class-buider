<?php
namespace Digitalwerk\PHPClassBuilder\Object\PHPClass;

use Digitalwerk\PHPClassBuilder\Object\AbstractPHPClassObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;

/**
 * Class VariableObject
 * @package Digitalwerk\PHPClassBuilder\Object\PHPClass
 */
class VariableObject extends AbstractPHPClassObject
{
    /**
     * VariableObject constructor.
     * @param PHPClassObject $classObject
     */
    public function __construct(PHPClassObject $classObject)
    {
        parent::__construct($classObject);
    }

    /**
     * VariableObject destructor.
     */
    public function __destruct()
    {
        $this->setVariables();
    }

    /**
     * @return void
     */
    private function setVariables(): void
    {
        $variables = $this->classObject->getVariables();
        $variables[] = $this;
        $this->classObject->setVariables($variables);
    }

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $type = '';

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
     * @return VariableObject
     */
    public function setName(string $name): VariableObject
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     * @return VariableObject
     */
    public function setType(? string $type): VariableObject
    {
        $this->type = $type;
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
     * @return VariableObject
     */
    public function setComment(string $comment): VariableObject
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
     * @return VariableObject
     */
    public function setValue(string $value): VariableObject
    {
        $this->value = $value;
        return $this;
    }
}
