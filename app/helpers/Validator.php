<?php

namespace App\Helpers;

class Validator
{
    /**
     * Summary of validate
     * @param array $data
     * @param array $rules
     * @return array
     */
    public static function validate(array $data, array $rules)
    {
        $errors    = [];
        $validated = [];

        foreach ($rules as $field => $ruleString) {
            $rulesArr = explode('|', $ruleString);
            $value    = $data[$field] ?? null;

            // Normalize value
            $isArray = self::isArrayRule($rulesArr);
            $value   = $isArray ? (is_array($value) ? $value : []) : self::clean($value);

            if ($isArray) {
                [$validated[$field], $errors[$field]] = self::validateArray($field, $value, $rulesArr);
                if (empty($errors[$field])) unset($errors[$field]);
            } else {
                $validated[$field] = self::sanitize($value);
                self::validateScalar($field, $value, $rulesArr, $errors);
            }
        }

        if (!empty($errors)) {
            $_SESSION['isError']           = 1;
            $_SESSION['validation_errors'] = $errors;
            $_SESSION['old']               = $data;

            header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
            exit();
        }

        return $validated;
    }

    /**
     * Summary of isArrayRule
     * @param array $rules
     * @return bool
     */
    private static function isArrayRule(array $rules): bool
    {
        return in_array('array', $rules) || in_array('required_array', $rules);
    }

    /**
     * Summary of validateArray
     * @param mixed $field
     * @param mixed $values
     * @param mixed $rules
     * @return array<array>
     */
    private static function validateArray($field, $values, $rules)
    {
        $errors    = [];
        $validated = [];

        foreach ($values as $i => $item) {
            $item = self::clean($item);

            foreach ($rules as $rule) {
                if ($rule === 'required_array' && $item === '') {
                    $errors[$i][] = "$field[$i] is required";
                    continue;
                }

                if ($item === '') continue;

                if ($rule === 'string' && !is_string($item)) {
                    $errors[$i][] = "$field[$i] must be a string";
                }

                if ($rule === 'numeric' && !is_numeric($item)) {
                    $errors[$i][] = "$field[$i] must be numeric";
                }

                self::checkMinMax($field, $i, $item, $rule, $errors);
            }

            $validated[$i] = self::sanitize($item);
        }

        return [$validated, $errors];
    }

    /**
     * Summary of validateScalar
     * @param mixed $field
     * @param mixed $value
     * @param mixed $rules
     * @param mixed $errors
     * @return void
     */
    private static function validateScalar($field, $value, $rules, &$errors)
    {
        if (isset($_FILES[$field]) && is_array($_FILES[$field]) && isset($_FILES[$field]['tmp_name'])) {
            $value = $_FILES[$field];

            if (in_array('required', $rules)) {
                if (!$value || $value['error'] === UPLOAD_ERR_NO_FILE) {
                    $errors[$field][] = "$field is required";
                    return;
                }
            }

            if ($value['error'] === UPLOAD_ERR_NO_FILE) {
                return;
            }

            if ($value['error'] !== UPLOAD_ERR_OK) {
                $errors[$field][] = "$field upload failed";
                return;
            }

            foreach ($rules as $rule) {
                if ($rule === 'required' && ($value === null || $value === '')) {
                    $errors[$field][] = "$field is required";
                    continue;
                }

                if (($value === null || $value === '') && in_array('nullable', $rules)) {
                    return;
                }

                if ($rule === 'image') {
                    if (!@getimagesize($value['tmp_name'])) {
                        $errors[$field][] = "$field must be an image";
                    }
                }

                if ($rule === 'confirmed') {
                    $confirmField = $field . '_confirmation';
                    $confirmValue = $_POST[$confirmField] ?? null;

                    if ($value !== $confirmValue) {
                        $errors[$field][] = "$field confirmation does not match";
                    }
                }

                if ($rule === 'file') {
                    if (!is_uploaded_file($value['tmp_name'])) {
                        $errors[$field][] = "$field must be a valid file";
                    }
                }

                if (str_starts_with($rule, 'mimes:')) {
                    $allowed = explode(',', str_replace('mimes:', '', $rule));
                    $ext     = strtolower(pathinfo($value['name'], PATHINFO_EXTENSION));

                    if (!in_array($ext, $allowed)) {
                        $errors[$field][] = "$field invalid file type";
                    }
                }

                if (str_starts_with($rule, 'max_size:')) {
                    $maxKb  = (int) str_replace('max_size:', '', $rule);
                    $sizeKb = $value['size'] / 1024;

                    if ($sizeKb > $maxKb) {
                        $errors[$field][] = "$field too large";
                    }
                }
            }

            return;
        }

        foreach ($rules as $rule) {
            if ($rule === 'required' && ($value === null || $value === '')) {
                $errors[$field][] = "$field is required";
                continue;
            }

            if (($value === null || $value === '') && in_array('nullable', $rules)) {
                return;
            }

            if ($rule === 'string' && !is_string($value)) {
                $errors[$field][] = "$field must be a string";
            }

            if ($rule === 'numeric' && !is_numeric($value)) {
                $errors[$field][] = "$field must be numeric";
            }

            if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field][] = "$field must be a valid email";
            }

            if (strpos($rule, 'date') === 0) {
                self::validateDate($field, $value, $rule, $errors);
            }

            self::checkMinMax($field, null, $value, $rule, $errors);
        }
    }

    /**
     * Summary of validateDate
     * @param mixed $field
     * @param mixed $value
     * @param mixed $rule
     * @param mixed $errors
     * @return void
     */
    private static function validateDate($field, $value, $rule, &$errors)
    {
        $format = strpos($rule, ':') ? explode(':', $rule)[1] : null;

        $valid = $format
            ? ($d = \DateTime::createFromFormat($format, $value)) && $d->format($format) === $value
            : strtotime($value) !== false;

        if (!$valid) {
            $errors[$field][] = $format
                ? "$field must match format $format"
                : "$field must be a valid date";
        }
    }

    /**
     * Summary of checkMinMax
     * @param mixed $field
     * @param mixed $index
     * @param mixed $value
     * @param mixed $rule
     * @param mixed $errors
     * @return void
     */
    private static function checkMinMax($field, $index, $value, $rule, &$errors)
    {
        if (!str_starts_with($rule, 'min:') && !str_starts_with($rule, 'max:')) {
            return;
        }

        $num = (int) explode(':', $rule)[1];

        $isNumeric = is_numeric($value);

        $length = $isNumeric ? $value : strlen((string) $value);

        if (str_starts_with($rule, 'min:') && $length < $num) {
            if ($index === null) {
                $errors[$field] = $isNumeric ? "Value must be at least $num" : "Minimum $num characters required";
            } else {
                $errors[$field][$index][] = $isNumeric ? "Value must be at least $num" : "Minimum $num characters required";
            }
        }

        if (str_starts_with($rule, 'max:') && $length > $num) {
            if ($index === null) {
                $errors[$field] = $isNumeric ? "Value must be less than $num" :   "Maximum $num characters allowed";
            } else {
                $errors[$field][$index][] = $isNumeric ? "Value must be less than $num" :   "Maximum $num characters allowed";
            }
        }
    }

    /**
     * Summary of clean
     * @param mixed $value
     */
    private static function clean($value)
    {
        return is_string($value) ? trim($value) : $value;
    }

    /**
     * Summary of sanitize
     * @param mixed $value
     */
    private static function sanitize($value)
    {
        return is_string($value)
            ? htmlspecialchars($value, ENT_QUOTES, 'UTF-8')
            : $value;
    }

    private static function isFile(array $value): bool
    {
        return isset($value['tmp_name']);
    }

    private static function addError(&$errors, $field, $index, $message)
    {
        if ($index === null) {
            $errors[$field][] = $message;
        } else {
            $errors[$field][$index][] = $message;
        }
    }
}
