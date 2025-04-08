<?php
/**
 * Class WCLSI_Request_Validator
 * Handles validation of API requests
 */
class WCLSI_Request_Validator {
    private const REQUIRED_FIELDS = [
        'api_key' => 'string',
        'api_secret' => 'string',
        'account_id' => 'integer'
    ];

    private array $errors = [];

    /**
     * Validate API credentials
     * @param array $credentials API credentials
     * @return bool True if valid, false otherwise
     */
    public function validate_credentials(array $credentials): bool {
        $this->errors = [];

        // Check required fields
        foreach (self::REQUIRED_FIELDS as $field => $type) {
            if (!isset($credentials[$field])) {
                $this->errors[] = "Missing required field: $field";
                continue;
            }

            if (!$this->validate_type($credentials[$field], $type)) {
                $this->errors[] = "Invalid type for field $field: expected $type";
            }
        }

        // Validate API key format
        if (isset($credentials['api_key']) && !$this->validate_api_key($credentials['api_key'])) {
            $this->errors[] = 'Invalid API key format';
        }

        // Validate API secret format
        if (isset($credentials['api_secret']) && !$this->validate_api_secret($credentials['api_secret'])) {
            $this->errors[] = 'Invalid API secret format';
        }

        // Validate account ID
        if (isset($credentials['account_id']) && !$this->validate_account_id($credentials['account_id'])) {
            $this->errors[] = 'Invalid account ID';
        }

        return empty($this->errors);
    }

    /**
     * Validate request parameters
     * @param array $params Request parameters
     * @param array $rules Validation rules
     * @return bool True if valid, false otherwise
     */
    public function validate_params(array $params, array $rules): bool {
        $this->errors = [];

        foreach ($rules as $field => $rule) {
            if (!isset($params[$field]) && !$rule['optional']) {
                $this->errors[] = "Missing required parameter: $field";
                continue;
            }

            if (isset($params[$field])) {
                if (!$this->validate_type($params[$field], $rule['type'])) {
                    $this->errors[] = "Invalid type for parameter $field: expected {$rule['type']}";
                }

                if (isset($rule['min']) && $params[$field] < $rule['min']) {
                    $this->errors[] = "Parameter $field must be at least {$rule['min']}";
                }

                if (isset($rule['max']) && $params[$field] > $rule['max']) {
                    $this->errors[] = "Parameter $field must be at most {$rule['max']}";
                }
            }
        }

        return empty($this->errors);
    }

    /**
     * Get validation errors
     * @return array List of errors
     */
    public function get_errors(): array {
        return $this->errors;
    }

    /**
     * Validate value type
     * @param mixed $value Value to validate
     * @param string $type Expected type
     * @return bool True if valid, false otherwise
     */
    private function validate_type($value, string $type): bool {
        switch ($type) {
            case 'string':
                return is_string($value);
            case 'integer':
                return is_int($value);
            case 'float':
                return is_float($value);
            case 'boolean':
                return is_bool($value);
            case 'array':
                return is_array($value);
            default:
                return false;
        }
    }

    /**
     * Validate API key format
     * @param string $key API key
     * @return bool True if valid, false otherwise
     */
    private function validate_api_key(string $key): bool {
        return preg_match('/^[a-zA-Z0-9]{32}$/', $key) === 1;
    }

    /**
     * Validate API secret format
     * @param string $secret API secret
     * @return bool True if valid, false otherwise
     */
    private function validate_api_secret(string $secret): bool {
        return preg_match('/^[a-zA-Z0-9]{64}$/', $secret) === 1;
    }

    /**
     * Validate account ID
     * @param int $id Account ID
     * @return bool True if valid, false otherwise
     */
    private function validate_account_id(int $id): bool {
        return $id > 0;
    }
} 