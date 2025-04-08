<?php
/**
 * Class WCLSI_Auth_Manager
 * Handles API authentication and token management
 */
class WCLSI_Auth_Manager {
    private const TOKEN_CACHE_KEY = 'wclsi_auth_token';
    private const TOKEN_EXPIRY = 3600; // 1 hour
    private const REFRESH_WINDOW = 300; // 5 minutes

    private string $api_key;
    private string $api_secret;
    private int $account_id;
    private ?string $token = null;
    private int $token_expiry = 0;
    private WCLSI_Error_Logger $logger;

    /**
     * Initialize the auth manager
     * @param string $api_key API key
     * @param string $api_secret API secret
     * @param int $account_id Account ID
     * @param WCLSI_Error_Logger $logger Error logger
     */
    public function __construct(
        string $api_key,
        string $api_secret,
        int $account_id,
        WCLSI_Error_Logger $logger
    ) {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        $this->account_id = $account_id;
        $this->logger = $logger;
        $this->load_token();
    }

    /**
     * Get authentication token
     * @return string Authentication token
     * @throws Exception If token cannot be obtained
     */
    public function get_token(): string {
        if ($this->is_token_valid()) {
            return $this->token;
        }

        return $this->refresh_token();
    }

    /**
     * Check if current token is valid
     * @return bool True if token is valid
     */
    private function is_token_valid(): bool {
        if (!$this->token) {
            return false;
        }

        $time_to_expiry = $this->token_expiry - time();
        return $time_to_expiry > self::REFRESH_WINDOW;
    }

    /**
     * Refresh authentication token
     * @return string New authentication token
     * @throws Exception If token refresh fails
     */
    private function refresh_token(): string {
        try {
            $response = $this->request_new_token();
            $this->token = $response['access_token'];
            $this->token_expiry = time() + $response['expires_in'];
            $this->save_token();
            return $this->token;
        } catch (Exception $e) {
            $this->logger->log('Failed to refresh token: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Request new token from API
     * @return array Token response
     * @throws Exception If request fails
     */
    private function request_new_token(): array {
        $response = wp_remote_post('https://api.lightspeed.com/oauth/access_token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'body' => [
                'client_id' => $this->api_key,
                'client_secret' => $this->api_secret,
                'grant_type' => 'client_credentials'
            ]
        ]);

        if (is_wp_error($response)) {
            throw new Exception($response->get_error_message());
        }

        $body = json_decode(wp_remote_retrieve_body($response), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Failed to decode token response');
        }

        if (!isset($body['access_token'])) {
            throw new Exception('Invalid token response');
        }

        return $body;
    }

    /**
     * Load token from cache
     */
    private function load_token(): void {
        $cached = get_transient(self::TOKEN_CACHE_KEY);
        if ($cached !== false) {
            $this->token = $cached['token'];
            $this->token_expiry = $cached['expiry'];
        }
    }

    /**
     * Save token to cache
     */
    private function save_token(): void {
        set_transient(self::TOKEN_CACHE_KEY, [
            'token' => $this->token,
            'expiry' => $this->token_expiry
        ], self::TOKEN_EXPIRY);
    }

    /**
     * Clear authentication token
     */
    public function clear_token(): void {
        $this->token = null;
        $this->token_expiry = 0;
        delete_transient(self::TOKEN_CACHE_KEY);
    }

    /**
     * Get authentication headers
     * @return array Headers for authenticated requests
     * @throws Exception If token cannot be obtained
     */
    public function get_auth_headers(): array {
        return [
            'Authorization' => 'Bearer ' . $this->get_token(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }
} 