<?php

namespace NotificationChannels\Madar;

use Exception;
use GuzzleHttp\Client as HttpClient;
use GuzzleHTtp\Exception\ClientException;
use NotificationChannels\Madar\Exceptions\CouldNotSendNotification;

class Madar
{
    /**
     * @var string Madar API URL.
     */
    protected string $apiUrl = 'https://mobile.net.sa';

    /**
     * @var HttpClient HTTP Client.
     */
    protected $http;

    /**
     * @var null|string Madar Username (sender mobile number).
     */
    protected $username;

    /**
     * @var null|string Madar password.
     */
    protected $password;

    /**
     * @param  string  $username
     * @param  string  $password
     * @param  HttpClient  $http
     */
    public function __construct(string $username = null, string $password = null, HttpClient $http = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->http = $http;
    }

    /**
     * Get Username.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set Username.
     *
     * @param  string  $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set password.
     *
     * @param  string  $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * Get HttpClient.
     *
     * @return HttpClient
     */
    protected function httpClient(): HttpClient
    {
        return $this->http ?? new HttpClient();
    }

    /**
     * Send text message.
     *
     * <code>
     * $params = [
     *      'numbers'               => '',
     *      'userSender'            => '',
     *      'msg'                   => '',
     *      'By'                    => '',
     *      'dateTimeSendLater'     => '',
     *      'timeSendLater'         => '',
     *      'infos'                 => '',
     *      'return'                => '',
     *      'YesRepeat'             => '',
     * ];
     * </code>
     *
     * @link https://mobile.net.sa/sms/gw
     *
     * @param  array  $params
     */
    public function sendMessage(array $params)
    {
        return $this->sendRequest('/sms/gw', $params);
    }

    public function sendRequest(string $endpoint, array $params)
    {
        if (empty($this->username)) {
            throw CouldNotSendNotification::usernameNotProvided();
        }

        if (empty($this->password)) {
            throw CouldNotSendNotification::passwordNotProvided();
        }

        try {
            $url = $this->apiUrl . $endpoint . '?userName=' . $this->username . '&userPassword=' . $this->password;
            return $this->httpClient()->get($url, ['query' => $params]);
        } catch (ClientException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        } catch (Exception $exception) {
            throw CouldNotSendNotification::serviceNotAvailable($exception);
        }
    }
}
