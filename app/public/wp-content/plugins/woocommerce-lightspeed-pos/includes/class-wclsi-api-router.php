<?php
/**
 * Class WCLSI_Api_Router
 * Handles API endpoints and routing
 */
class WCLSI_Api_Router {
    private const API_BASE_URL = 'https://api.lightspeed.com/API';
    private const API_VERSION = 'v1';

    private int $account_id;
    private WCLSI_Auth_Manager $auth_manager;
    private WCLSI_Response_Handler $response_handler;
    private WCLSI_Rate_Limiter $rate_limiter;

    /**
     * Initialize the API router
     * @param int $account_id Account ID
     * @param WCLSI_Auth_Manager $auth_manager Auth manager
     * @param WCLSI_Response_Handler $response_handler Response handler
     * @param WCLSI_Rate_Limiter $rate_limiter Rate limiter
     */
    public function __construct(
        int $account_id,
        WCLSI_Auth_Manager $auth_manager,
        WCLSI_Response_Handler $response_handler,
        WCLSI_Rate_Limiter $rate_limiter
    ) {
        $this->account_id = $account_id;
        $this->auth_manager = $auth_manager;
        $this->response_handler = $response_handler;
        $this->rate_limiter = $rate_limiter;
    }

    /**
     * Make a GET request
     * @param string $endpoint API endpoint
     * @param array $params Query parameters
     * @return mixed API response
     */
    public function get(string $endpoint, array $params = []): mixed {
        return $this->request('GET', $endpoint, $params);
    }

    /**
     * Make a POST request
     * @param string $endpoint API endpoint
     * @param array $data Request data
     * @return mixed API response
     */
    public function post(string $endpoint, array $data = []): mixed {
        return $this->request('POST', $endpoint, [], $data);
    }

    /**
     * Make a PUT request
     * @param string $endpoint API endpoint
     * @param array $data Request data
     * @return mixed API response
     */
    public function put(string $endpoint, array $data = []): mixed {
        return $this->request('PUT', $endpoint, [], $data);
    }

    /**
     * Make a DELETE request
     * @param string $endpoint API endpoint
     * @return mixed API response
     */
    public function delete(string $endpoint): mixed {
        return $this->request('DELETE', $endpoint);
    }

    /**
     * Make an API request
     * @param string $method HTTP method
     * @param string $endpoint API endpoint
     * @param array $params Query parameters
     * @param array $data Request data
     * @return mixed API response
     */
    private function request(
        string $method,
        string $endpoint,
        array $params = [],
        array $data = []
    ): mixed {
        $this->rate_limiter->wait_for_request();

        $url = $this->build_url($endpoint, $params);
        $args = $this->build_request_args($method, $data);

        $response = wp_remote_request($url, $args);
        $status_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);

        $this->rate_limiter->record_request();

        return $this->response_handler->handle_response($body, $status_code, $endpoint);
    }

    /**
     * Build API URL
     * @param string $endpoint API endpoint
     * @param array $params Query parameters
     * @return string Complete API URL
     */
    private function build_url(string $endpoint, array $params): string {
        $url = sprintf(
            '%s/%s/Account/%d/%s',
            self::API_BASE_URL,
            self::API_VERSION,
            $this->account_id,
            $endpoint
        );

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        return $url;
    }

    /**
     * Build request arguments
     * @param string $method HTTP method
     * @param array $data Request data
     * @return array Request arguments
     */
    private function build_request_args(string $method, array $data): array {
        $args = [
            'method' => $method,
            'headers' => $this->auth_manager->get_auth_headers(),
            'timeout' => 30
        ];

        if (!empty($data)) {
            $args['body'] = json_encode($data);
        }

        return $args;
    }
} 