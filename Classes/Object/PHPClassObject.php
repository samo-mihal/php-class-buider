<?php
namespace Digitalwerk\PHPClassBuilder\Object;

use Digitalwerk\PHPClassBuilder\Object\PHPClass\ConstantObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClass\ContainsObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClass\EditObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClass\FunctionObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClass\TraitObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClass\UsedClassObject;
use Digitalwerk\PHPClassBuilder\Object\PHPClass\VariableObject;
use Digitalwerk\PHPClassBuilder\Render\PHPClassRender;

/**
 * Class PHPClassObject
 * @package Digitalwerk\PHPClassBuilder\Object
 */
class PHPClassObject
{
    /**
     * PHPClassObject constructor.
     * @param string $filename
     */
    public function __construct(string $filename )
    {
        $this->setFilename($filename);
        if ($filename && file_exists($filename)) {
            $this->setLines(file($this->filename));
            $this->setClassInStringFormat(implode('', $this->getLines()));
            $this->initialize();
            if (trim($this->getClassInStringFormat())) {
                throw new \InvalidArgumentException('Could not render this class. Please contact support.');
            }
        }
    }

    /**
     * @var int
     */
    protected $tabSpaces = 4;

    /**
     * @var string
     */
    protected $classInStringFormat = '';

    /**
     * @var array
     */
    protected $stringBetweenOpeningAndClosingCurlyBrackets = [];

    /**
     * @var array
     */
    protected $lines = [];

    /**
     * @var string
     */
    protected $filename = '';

    /**
     * @var string
     */
    protected $comment = '';

    /**
     * @var string
     */
    protected $nameSpace = '';

    /**
     * @var array
     */
    protected $traits = [];

    /**
     * @var bool
     */
    protected $strictMode = false;

    /**
     * @var array
     */
    protected $usedClasses = [];

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $extendsOrImplements = '';

    /**
     * @var array
     */
    protected $constants = [];

    /**
     * @var array
     */
    protected $variables = [];

    /**
     * @var array
     */
    protected $functions = [];

    /**
     * @var int
     */
    protected $functionsCounter = -1;

    /**
     * @return void
     */
    private function initialize(): void
    {
        $this->initializeObjectBeforeClass();
    }

    /**
     * @return void
     */
    private function initializeObjectBeforeClass(): void
    {
        $linesBeforeClass = [];

        /**
         * Before Class
         */
        foreach ($this->getLines() as $line) {
            $linesBeforeClass[] = $line;
            if (strpos($line, '/**') !== false) {
                $this->setComment(
                    $this->getCommentFromString()
                );
            }
            if (strpos($line, 'namespace ') !== false) {
                $nameSpace = trim(str_replace(['namespace', ';'], ['', ''], $line));
                $this->setNameSpace($nameSpace);
            }
            if (strpos($line, 'declare(strict_types=1);') !== false) {
                $this->setStrictMode(true);
            }
            if (strpos($line, 'use ') !== false) {
                $this->addUsedClass()
                    ->setName(
                        trim(
                            str_replace(['use ', ';'], ['', ''], $line) .
                            $this->getStringBetween(
                                $this->getClassInStringFormat(),
                                str_replace(';', '', $line),
                                ';'
                            )
                        )
                    );
            }
            if (strpos($line, 'class ') !== false) {
                $this->setName(
                    trim(
                        $this->getStringBetween(
                            $line,
                            'class ',
                            ' '
                        )
                    )
                );
                $this->setExtendsOrImplements(
                    trim(
                        $this->getStringBetween(
                            $line,
                            $this->getName(),
                            substr($line, -1)
                        )
                    )
                );
                $headerRender = new PHPClassRender\HeaderRender($this);
                $this->removeFromClassInStringFormatString(implode("\n", $headerRender->render()));
                $this->initializeObjectInClass(array_diff(file($this->filename), $linesBeforeClass));

                break;
            }
        }
    }

    /**
     * @param $fileLines
     * @return void
     */
    private function initializeObjectInClass($fileLines): void
    {
        array_shift($fileLines);
        array_pop($fileLines);

        $this->setClassInStringFormat(implode('', $fileLines));

        /**
         * After Class
         */
        foreach ($fileLines as $line) {
            if (strpos($line, 'use ') !== false) {
                $this->setTraitsFromString($line);
            }
            if (strpos($line, 'const ') !== false) {
                $this->setConstantFromString($line);
            }
            if (strpos($line, 'protected ') !== false && strpos($line, 'function') === false) {
                $this->setVariableFromString($line, 'protected');
            }
            if (strpos($line, 'private ') !== false && strpos($line, 'function') === false) {
                $this->setVariableFromString($line, 'private');
            }
            if (strpos($line, 'public ') !== false && strpos($line, 'function') === false) {
                $this->setVariableFromString($line, 'public');
            }
            if (strpos($line, 'function ') !== false) {
                $this->setFunctionFromString($line);
            }
        }

    }

    /**
     * @return string
     */
    private function getCommentFromString(): string
    {
        $comment = $this->getStringBetween(
                $this->getClassInStringFormat(),
                '/**',
                '*/'
            );
        $comment =  $comment ? '/**' . $comment . '*/' : '';
        return $comment;
    }

    /**
     * @param string $string
     * @return void
     */
    private function removeFromClassInStringFormatString(string $string): void
    {
        $this->setClassInStringFormat(
            str_replace($string, '', $this->getClassInStringFormat())
        );
    }

    /**
     * @param $line
     */
    private function setTraitsFromString($line): void
    {
        $trait = new TraitObject($this);
        $trait->setName(
            $this->getStringBetween(
                $line,
                'use ',
                ';'
            )
        );
        $comment = $this->getCommentFromString();
        if ($comment && strpos($this->lines[$this->getArrayKeyOfLineBefore($line)], '*/') !== false) {
            $trait->setComment($comment);
        }
        $traitsRender = new PHPClassRender\TraitsRender($this);
        $this->removeFromClassInStringFormatString($traitsRender->renderTrait($trait, false));
    }

    /**
     * @param $line
     */
    private function setConstantFromString($line): void
    {
        $constant = new ConstantObject($this);
        $constant
            ->setName(
                $this->getStringBetween(
                    $line,
                    'const ',
                    ' '
                )
            )
            ->setValue(
                $this->getStringBetween(
                    $this->getClassInStringFormat(),
                    $constant->getName() . ' = ',
                    ';'
                )
            );
        $comment = $this->getCommentFromString();
        if ($comment && strpos($this->lines[$this->getArrayKeyOfLineBefore($line)], '*/') !== false) {
            $constant->setComment($comment);
        }

        $constantRender = new PHPClassRender\ConstantsRender($this);
        $this->removeFromClassInStringFormatString($constantRender->renderConstant($constant, false));
    }

    /**
     * @param $line
     * @param $type
     */
    private function setVariableFromString($line, $type): void
    {
        $variable = new VariableObject($this);
        $advanceType = trim(
            $this->getStringBetween(
            $line,
            $type,
            '$'
            )
        );
        $variable
            ->setName(
                $this->getStringBetween(
                    $line,
                    '$',
                    ' '
                )
            )
            ->setValue(
                $this->getStringBetween(
                    $this->getClassInStringFormat(),
                    $variable->getName() . ' = ',
                    ';'
                )
            )
            ->setType(
                $advanceType ? $type . ' ' . $advanceType : $type
            );
        $comment = $this->getCommentFromString();
        if ($comment && strpos($this->lines[$this->getArrayKeyOfLineBefore($line)], '*/') !== false) {
            $variable->setComment($comment);
        }

        $variablesRender = new PHPClassRender\VariablesRender($this);
        $this->removeFromClassInStringFormatString(
            $variablesRender->renderVariable($variable)
        );
    }

    /**
     * @param $line
     */
    private function setFunctionFromString($line): void
    {
        $function = new FunctionObject($this);
        $function
            ->setName(
                $this->getStringBetween(
                    $line,
                    'function ',
                    '('
                )
            )
            ->setType(
                 trim(
                     trim($line)[0] . $this->getStringBetween(
                        $line,
                        trim($line)[0],
                        $function->getName()
                    )
                )
            )
            ->setContent(
                $this->getStringBetweenOpeningAndClosingCurlyBrackets()
            )
            ->setArgumentsAndDescription(
            trim(
                '(' . $this->getStringBetween(
                    $line,
                    '(',
                    substr($line, -1)
                ) . substr($line, -1)
            )
        );
        $comment = $this->getCommentFromString();
        if ($comment && strpos($this->lines[$this->getArrayKeyOfLineBefore($line)], '*/') !== false) {
            $function->setComment($comment);
        }

        $functionsRender = new PHPClassRender\FunctionsRender($this);
        $this->removeFromClassInStringFormatString(
            $functionsRender->renderFunction($function)
        );
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getNameSpace(): string
    {
        return $this->nameSpace;
    }

    /**
     * @param string $nameSpace
     */
    public function setNameSpace(string $nameSpace): void
    {
        $this->nameSpace = $nameSpace;
    }

    /**
     * @return bool
     */
    public function isStrictMode(): bool
    {
        return $this->strictMode;
    }

    /**
     * @param bool $strictMode
     */
    public function setStrictMode(bool $strictMode): void
    {
        $this->strictMode = $strictMode;
    }

    /**
     * @return array
     */
    public function getUsedClasses(): array
    {
        return $this->usedClasses;
    }

    /**
     * @param array $usedClasses
     */
    public function setUsedClasses(array $usedClasses): void
    {
        $this->usedClasses = $usedClasses;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getExtendsOrImplements(): string
    {
        return $this->extendsOrImplements;
    }

    /**
     * @param string $extendsOrImplements
     */
    public function setExtendsOrImplements(string $extendsOrImplements): void
    {
        $this->extendsOrImplements = $extendsOrImplements;
    }

    /**
     * @return array
     */
    public function getConstants(): array
    {
        return $this->constants;
    }

    /**
     * @param array $constants
     */
    public function setConstants(array $constants): void
    {
        $this->constants = $constants;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * @param array|null $variables
     */
    public function setVariables(? array $variables): void
    {
        $this->variables = $variables;
    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return $this->functions;
    }

    /**
     * @param array $functions
     */
    public function setFunctions(array $functions): void
    {
        $this->functions = $functions;
    }

    /**
     * @return array
     */
    public function getTraits(): array
    {
        return $this->traits;
    }

    /**
     * @param array $traits
     */
    public function setTraits(array $traits): void
    {
        $this->traits = $traits;
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
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getClassInStringFormat(): string
    {
        return $this->classInStringFormat;
    }

    /**
     * @param string $classInStringFormat
     */
    public function setClassInStringFormat(string $classInStringFormat): void
    {
        $this->classInStringFormat = $classInStringFormat;
    }

    /**
     * @return array
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * @param array $lines
     */
    public function setLines(array $lines): void
    {
        $this->lines = $lines;
    }

    /**
     * @return int
     */
    public function getFunctionsCounter(): int
    {
        return $this->functionsCounter;
    }

    /**
     * @param int $functionsCounter
     */
    public function setFunctionsCounter(int $functionsCounter): void
    {
        $this->functionsCounter = $functionsCounter;
    }

    /**
     * @return string
     */
    private function getStringBetweenOpeningAndClosingCurlyBrackets(): string
    {
        if (empty($this->stringBetweenOpeningAndClosingCurlyBrackets)) {
            $regex = '/\{(?>[^{}]|(?R))*\}/m';
            preg_match_all($regex, $this->getClassInStringFormat(), $matches);
            $this->setStringBetweenOpeningAndClosingCurlyBrackets($matches);
        }
        $this->setFunctionsCounter($this->getFunctionsCounter() + 1);
        return $this->stringBetweenOpeningAndClosingCurlyBrackets[0][$this->getFunctionsCounter()] ?: '';
    }

    /**
     * @param array $stringBetweenOpeningAndClosingCurlyBrackets
     */
    public function setStringBetweenOpeningAndClosingCurlyBrackets(array $stringBetweenOpeningAndClosingCurlyBrackets): void
    {
        $this->stringBetweenOpeningAndClosingCurlyBrackets = $stringBetweenOpeningAndClosingCurlyBrackets;
    }

    /**
     * @return void
     */
    public function render(): void
    {
        $phpClassRender = new PHPClassRender($this);
        $phpClassRender->render();
    }

    /**
     * @return string
     */
    public function getTabSpaces(): string
    {
        $result = '';
        for ($x = 0; $x < $this->tabSpaces; $x+=1) {
            $result = $result . ' ';
        }
        return $result;
    }

    /**
     * @param int|null $tabSpaces
     */
    public function setTabSpaces(? int $tabSpaces): void
    {
        $this->tabSpaces = $tabSpaces;
    }

    /**
     * @param $line
     * @return false|int|string
     */
    private function getArrayKeyOfLineBefore($line)
    {
        return array_search($line, $this->getLines()) ? array_search($line, $this->getLines()) - 1 : 0;
    }

    /**
     * @return VariableObject
     */
    public function addVariable(): VariableObject
    {
        return new VariableObject($this);
    }

    /**
     * @return FunctionObject
     */
    public function addFunction(): FunctionObject
    {
        return new FunctionObject($this);
    }

    /**
     * @return TraitObject
     */
    public function addTrait(): TraitObject
    {
        return new TraitObject($this);
    }

    /**
     * @return ConstantObject
     */
    public function addConstant(): ConstantObject
    {
        return new ConstantObject($this);
    }

    /**
     * @return UsedClassObject
     */
    public function addUsedClass(): UsedClassObject
    {
        return new UsedClassObject($this);
    }

    /**
     * @return ContainsObject
     */
    public function contains(): ContainsObject
    {
        return new ContainsObject($this);
    }

    /**
     * @return EditObject
     */
    public function edit(): EditObject
    {
        return new EditObject($this);
    }

    /**
     * @return EditObject
     */
    public function get(): EditObject
    {
        return new EditObject($this);
    }

    /**
     * @param $string
     * @param $start
     * @param $end
     * @return false|string
     */
    private function getStringBetween($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
