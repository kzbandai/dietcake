<?php

namespace DietCook;

class Model
{
    public $id;
    /** @var array $validation */
    public $validation;
    /** @var array $validation_errors */
    public $validation_errors;

    public function __construct(array $data = [])
    {
        $this->set($data);
    }

    public function set(array $data): void
    {
        foreach ($data as $k => $v) {
            $this->$k = $v;
        }
    }

    /**
     * @throws DCException
     */
    public function validate(): bool
    {
        $members = get_object_vars($this);
        unset($members['validation'], $members['validation_errors']);

        $errors = 0;
        foreach ($members as $member => $v) {
            if (!isset($this->validation[$member])) {
                continue;
            }
            foreach ($this->validation[$member] as $rule_name => $args) {
                $validate_func = array_shift($args);
                if (method_exists($this, $validate_func)) {
                    $valid = \call_user_func_array([$this, $validate_func], array_merge([$v], $args));
                } elseif (\function_exists($validate_func)) {
                    $valid = \call_user_func_array($validate_func, array_merge([$v], $args));
                } else {
                    throw new DCException("{$validate_func} does not exist");
                }
                $this->validation_errors[$member][$rule_name] = $valid ? false : true;
                if (!$valid) {
                    $errors++;
                }
            }
        }

        return $errors === 0;
    }

    public function hasError(): bool
    {
        if (empty($this->validation_errors)) {
            return false;
        }
        foreach ($this->validation_errors as $v) {
            foreach ($v as $w) {
                if ($w) {
                    return true;
                }
            }
        }

        return false;
    }
}
