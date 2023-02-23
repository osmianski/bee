<?php

namespace Osmianski\Extensibility;

use Osmianski\Helper\Traits\ConstructedFromArray;

class Compiler
{
    use ConstructedFromArray {
        ConstructedFromArray::__construct as parentConstruct;
    }

    protected array $paths;
    protected array $generatorClasses;
    protected Generated\Code $code;

    public function __construct(array $data = [])
    {
        $this->parentConstruct($data);
        $this->code = new Generated\Code();
    }

    public function compile(): string {
        foreach ($this->generatorClasses as $generatorClass) {
            $generator = new $generatorClass([
                'code' => $this->code,
            ]);

            /* @var Generator $generator */
            $generator->generate();
        }
        return $this->code->compile();
    }
}
