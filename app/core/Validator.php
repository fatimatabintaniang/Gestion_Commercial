<?php

namespace App\Core;



class Validator
{
    private static ?self $instance = null;
    private array $errors = [];
    private array $rules = [];

    private function __construct()
    {
        $this->rules = [
            "required" => function ($value, $key, $message = "Ce champ est obligatoire"): bool {
                if (empty($value)) {
                    $this->addError($key, $message);
                    return false;
                }
                return true;
            },
            "email" => function ($value, $key, $message = "Email invalide"): bool {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($key, $message);
                    return false;
                }
                return true;
            },
            "min" => function ($value, $key, $min, $message = null): bool {
                if (strlen($value) < $min) {
                    $this->addError($key, $message ?? "Doit contenir au moins $min caractères");
                    return false;
                }
                return true;
            }
        ];
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }


    public function make($rule, callable $callable)
    {
        $this->rules[$rule] = $callable;
    }
    public function addError(string $key, string $message): void
    {
        $this->errors[$key] = $message;
    }

    public function validate(array $data, array $rules): bool
    {
        $this->errors = []; // Réinitialiser les erreurs avant chaque validation

        foreach ($rules as $field => $fieldRules) {
            if (!isset($data[$field])) {
                $this->addError($field, "Le champ $field n'existe pas dans les données.");
                continue;
            }

            $value = $data[$field];
            $fieldHasError = false;

            foreach ($fieldRules as $rule => $message) {
                if (is_int($rule)) { // Si la règle est numérique (message uniquement)
                    $rule = $message;
                    $message = null;
                }

                // Gestion des règles avec paramètres (comme "min:6")
                $ruleParts = explode(':', $rule);
                $ruleName = $ruleParts[0];
                $ruleParam = $ruleParts[1] ?? null;

                if (!isset($this->rules[$ruleName])) {
                    throw new \InvalidArgumentException("La règle de validation '$ruleName' n'existe pas.");
                }

                $callback = $this->rules[$ruleName];
                $params = [$value, $field];

                // Ajouter le paramètre si présent (comme le 6 dans "min:6")
                if ($ruleParam !== null) {
                    $params[] = $ruleParam;
                }

                // Ajouter le message personnalisé s'il existe
                if ($message !== null) {
                    $params[] = $message;
                }

                // Exécuter la validation
                $isValid = call_user_func_array($callback, $params);

                // Si la validation échoue, on sort de la boucle pour ce champ
                if (!$isValid) {
                    $fieldHasError = true;
                    break;
                }
            }
        }

        return empty($this->errors);
    }
}
