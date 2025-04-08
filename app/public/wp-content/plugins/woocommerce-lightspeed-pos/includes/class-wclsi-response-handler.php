<?php
/**
 * Class WCLSI_Response_Handler
 * Handles API response processing and error handling
 */
class WCLSI_Response_Handler {
    private const SUCCESS_CODES = [200, 201, 202, 204];
    private const RETRY_CODES = [429, 500, 502, 503, 504];
    private const MAX_RETRIES = 3;

    private WCLSI_Error_Logger $logger;
    private int $retry_count = 0;

    /**
     * Initialize the response handler
     * @param WCLSI_Error_Logger $logger Error logger instance
     */
    public function __construct(WCLSI_Error_Logger $logger) {
        $this->logger = $logger;
    }

    /**
     * Handle API response
     * @param mixed $response API response
     * @param int $status_code HTTP status code
     * @param string $endpoint API endpoint
     * @return mixed Processed response
     */
    public function handle_response($response, int $status_code, string $endpoint) {
        if (in_array($status_code, self::SUCCESS_CODES)) {
            return $this->process_success_response($response);
        }

        if (in_array($status_code, self::RETRY_CODES) && $this->retry_count < self::MAX_RETRIES) {
            return $this->handle_retry($response, $status_code, $endpoint);
        }

        return $this->handle_error($response, $status_code, $endpoint);
    }

    /**
     * Process successful response
     * @param mixed $response API response
     * @return mixed Processed response
     */
    private function process_success_response($response) {
        if (is_string($response)) {
            $response = json_decode($response, true);
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->logger->log('Failed to decode JSON response: ' . json_last_error_msg());
            return false;
        }

        return $response;
    }

    /**
     * Handle retryable error
     * @param mixed $response API response
     * @param int $status_code HTTP status code
     * @param string $endpoint API endpoint
     * @return mixed Retry result or error
     */
    private function handle_retry($response, int $status_code, string $endpoint) {
        $this->retry_count++;
        $this->logger->log(
            "Retrying request to $endpoint (attempt $this->retry_count of " . self::MAX_RETRIES . ")",
            ['status_code' => $status_code]
        );

        // Calculate exponential backoff delay
        $delay = pow(2, $this->retry_count);
        sleep($delay);

        return false; // Signal to retry the request
    }

    /**
     * Handle error response
     * @param mixed $response API response
     * @param int $status_code HTTP status code
     * @param string $endpoint API endpoint
     * @return false Always returns false for errors
     */
    private function handle_error($response, int $status_code, string $endpoint) {
        $error_message = $this->get_error_message($response, $status_code);
        $this->logger->log(
            "API request to $endpoint failed",
            [
                'status_code' => $status_code,
                'error' => $error_message,
                'response' => $response
            ]
        );

        return false;
    }

    /**
     * Get error message from response
     * @param mixed $response API response
     * @param int $status_code HTTP status code
     * @return string Error message
     */
    private function get_error_message($response, int $status_code): string {
        if (is_string($response)) {
            $response = json_decode($response, true);
        }

        if (is_array($response) && isset($response['error'])) {
            return $response['error'];
        }

        return "HTTP $status_code";
    }

    /**
     * Reset retry count
     */
    public function reset_retry_count(): void {
        $this->retry_count = 0;
    }
} 