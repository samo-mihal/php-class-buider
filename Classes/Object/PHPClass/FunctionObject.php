<?php
namespace Digitalwerk\PHPClassBuilder\Object\PHPClass;

use Digitalwerk\PHPClassBuilder\Object\AbstractPHPClassObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;

/**
 * Class FunctionObject
 * @package Digitalwerk\PHPClassBuilder\Object\PHPClass
 */
class FunctionObject extends AbstractPHPClassObject
{
    /**
     * FunctionObject constructor.
     * @param PHPClassObject $classObject
     */
    public function __construct(PHPClassObject $classObject)
    {
        parent::__construct($classObject);
    }

    /**
     * FunctionObject destructor.
     */
    public function __destruct()
    {
        $this->setFunctions();
    }

    /**
     * @return void
     */
    private function setFunctions(): void
    {
        $functions = $this->classObject->getFunctions();
        $functions[] = $this;
        $this->classObject->setFunctions($functions);
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
    protected $content = '';

    /**
     * @var string
     */
    protected $comment = '';

    /**
     * @var string
     */
    protected $argumentsAndDescription = '';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return FunctionObject
     */
    public function setName(string $name): FunctionObject
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
     * @param string $type
     * @return FunctionObject
     */
    public function setType(string $type): FunctionObject
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return FunctionObject
     */
    public function setContent(string $content): FunctionObject
    {
        $this->content = $content;
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
     * @return FunctionObject
     */
    public function setComment(string $comment): FunctionObject
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string
     */
    public function getArgumentsAndDescription(): string
    {
        return $this->argumentsAndDescription;
    }

    /**
     * @param string $argumentsAndDescription
     * @return FunctionObject
     */
    public function setArgumentsAndDescription(string $argumentsAndDescription): FunctionObject
    {
        $this->argumentsAndDescription = $argumentsAndDescription;
        return $this;
    }
}
