<?php

namespace Osmianski\Helper;

class EnvironmentFileEditor
{
    public function edit(array $variables): void
    {
        $path = app()->environmentFilePath();
        $contents = file_get_contents($path);

        foreach ($variables as $variable => $value) {
            $this->setVariable($contents, $variable, $value);
        }

        file_put_contents($path, $contents);
    }

    protected function setVariable(string &$contents, string $variable,
                                   string $value): void
    {
        $replaced = preg_replace(
            "/^" . preg_quote($variable) . "=.*$/m",
            "{$variable}={$value}",
            $contents
        );

        if ($contents !== $replaced) {
            $contents = $replaced;
        }
        else {
            $contents .= "\n{$variable}={$value}";
        }
    }
}
