<?php

namespace App\Helpers;

class Validator
{
    public static function validate(array $data, array $rules)
    {
        $errors    = [];
        $validated = [];

        foreach ($rules as $field => $ruleString) {
            $rulesArr = explode('|', $ruleString);
            $value    = $data[$field] ?? null;
            $isArrayRule = in_array('required_array', $rulesArr) || in_array('array', $rulesArr);
            if ($isArrayRule && !is_array($value)) {
                $value = []; 
            }
            if (is_array($value)) {
                $validated[$field] = [];
                foreach ($value as $index => $item) {
                    $item = is_string($item) ? trim($item) : $item;
                    foreach ($rulesArr as $rule) {
                        if ($rule === 'required_array' && empty($item)) {
                            $errors[$field][$index][] = "$field at index $index is required";
                        }
                        if ($rule === 'string' && !empty($item) && !is_string($item)) {
                            $errors[$field][$index][] = "$field at index $index must be a string";
                        }
                        if ($rule === 'numeric' && !empty($item) && !is_numeric($item)) {
                            $errors[$field][$index][] = "$field at index $index must be numeric";
                        }
                        if (strpos($rule, 'min:') === 0 && !empty($item)) {
                            $min = (int) str_replace('min:', '', $rule);
                            if (strlen($item) < $min) {
                                $errors[$field][$index][] = "$field at index $index must be at least $min characters";
                            }
                        }
                        if (strpos($rule, 'max:') === 0 && !empty($item)) {
                            $max = (int) str_replace('max:', '', $rule);
                            if (strlen($item) > $max) {
                                $errors[$field][$index][] = "$field at index $index must be less than $max characters";
                            }
                        }
                    }
                    $validated[$field][$index] = is_string($item) ? htmlspecialchars($item, ENT_QUOTES, 'UTF-8') : $item;
                }
            } else {
                $value = is_string($value) ? trim($value) : $value;

                foreach ($rulesArr as $rule) {
                    if ($rule === 'required' && (is_null($value) || $value === '')) {
                        $errors[$field][] = "$field is required";
                    }
                    if ($rule === 'string' && !empty($value) && !is_string($value)) {
                        $errors[$field][] = "$field must be a string";
                    }
                    if ($rule === 'numeric' && !empty($value) && !is_numeric($value)) {
                        $errors[$field][] = "$field must be numeric";
                    }
                    if ($rule === 'email' && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[$field][] = "$field must be a valid email";
                    }
                    if (strpos($rule, 'date') === 0 && !empty($value)) {
                        $format = null;
                        if (strpos($rule, ':') !== false) {
                            [$r, $format] = explode(':', $rule);
                        }
                        $valid = false;
                        if ($format) {
                            $d     = \DateTime::createFromFormat($format, $value);
                            $valid = $d && $d->format($format) === $value;
                        } else {
                            $valid = strtotime($value) !== false;
                        }
                        if (!$valid) {
                            $errors[$field][] = $format
                                ? "$field must be a valid date in format $format"
                                : "$field must be a valid date";
                        }
                    }
                    if (strpos($rule, 'min:') === 0 && !empty($value)) {
                        $min = (int) str_replace('min:', '', $rule);
                        if (strlen($value) < $min) {
                            $errors[$field][] = "$field must be at least $min characters";
                        }
                    }
                    if (strpos($rule, 'max:') === 0 && !empty($value)) {
                        $max = (int) str_replace('max:', '', $rule);
                        if (strlen($value) > $max) {
                            $errors[$field][] = "$field must be less than $max characters";
                        }
                    }
                }
                $validated[$field] = is_string($value) ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8') : $value;
            }
        }

        if (!empty($errors)) {
            $_SESSION['isError']           = 1;
            $_SESSION['validation_errors'] = $errors;
            $_SESSION['old']               = $data;
            $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
            header('Location: ' . $redirect);
            exit();
        }

        return $validated;
    }
}
