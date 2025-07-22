<?php

namespace App\Core;

use App\Core\Abstract\Singleton;

class Validator extends Singleton
{
    private array $errors = [];
    private array $rules = [];

    public function __construct()
    {
        // Initialisation des règles de base via make()
        $this->make('required', function ($value, $key, $message = "Ce champ est obligatoire"): bool {
            if (empty($value)) {
                $this->addError($key, $message);
                return false;
            }
            return true;
        });

        $this->make('email', function ($value, $key, $message = "Email invalide"): bool {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $this->addError($key, $message);
                return false;
            }
            return true;
        });

        $this->make('min', function ($value, $key, $min, $message = null): bool {
            if (strlen($value) < $min) {
                $this->addError($key, $message ?? "Doit contenir au moins $min caractères");
                return false;
            }
            return true;
        });
    }

  

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function make(string $rule, callable $callback): void
    {
        $this->rules[$rule] = $callback;
    }

    public function addError(string $key, string $message): void
    {
        $this->errors[$key] = $message;
    }

    public function validate(array $data, array $rules): bool
    {
        $this->errors = [];

        foreach ($rules as $field => $fieldRules) {
            if (!isset($data[$field])) {
                $this->addError($field, "Le champ $field n'existe pas dans les données.");
                continue;
            }

            $value = $data[$field];
            $fieldHasError = false;

            foreach ($fieldRules as $rule => $message) {
                if (is_int($rule)) {
                    $rule = $message;
                    $message = null;
                }

                $ruleParts = explode(':', $rule);
                $ruleName = $ruleParts[0];
                $ruleParam = $ruleParts[1] ?? null;

                if (!isset($this->rules[$ruleName])) {
                    throw new \InvalidArgumentException("La règle de validation '$ruleName' n'existe pas.");
                }

                $params = [$value, $field];
                if ($ruleParam !== null) $params[] = $ruleParam;
                if ($message !== null) $params[] = $message;

                if (!call_user_func_array($this->rules[$ruleName], $params)) {
                    $fieldHasError = true;
                    break;
                }
            }
        }

        return empty($this->errors);
    }
}