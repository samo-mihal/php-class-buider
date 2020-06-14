<?php
namespace Digitalwerk\PHPClassBuilder\Object\PHPClass;

use Digitalwerk\PHPClassBuilder\Object\AbstractPHPClassObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClassObject;

/**
 * Class TraitObject
 * @package Digitalwerk\PHPClassBuilder\Object\PHPClass
 */
class TraitObject extends AbstractPHPClassObject
{
    /**
     * TraitObject constructor.
     * @param PHPClassObject $classObject
     */
    public function __construct(PHPClassObject $classObject)
    {
        parent::__construct($classObject);
    }

    /**
     * TraitsObject destructor.
     */
    public function __destruct()
    {
        $this->setTraits();
    }

    /**
     * @return void
     */
    private function setTraits(): void
    {
        $traits = $this->classObject->getTraits();
        $traits[] = $this;
        $this->classObject->setTraits($traits);
    }

    /**
     * @var string
     */
    protected $name = '';

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
     * @return TraitObject
     */
    public function setName(string $name): TraitObject
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
     * @return TraitObject
     */
    public function setComment(string $comment): TraitObject
    {
        $this->comment = $comment;
        return $this;
    }
}
