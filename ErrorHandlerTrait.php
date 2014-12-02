<?php

namespace nkovacs\errbit;

use Errbit\Errbit;
use yii\base\InvalidConfigException;

/**
 * ErrorHandlerTrait should be attached to an error handler.
 * It sends errors to errbit.
 */
trait ErrorHandlerTrait
{
    /**
     * @var string errbit api key
     */
    public $errbitApiKey;

    /**
     * @var string errbit host
     */
    public $errbitHost;

    /**
     * @var array errbit configuration
     */
    public $errbit;

    public function register()
    {
        $config = [
            'api_key' => $this->errbitApiKey,
            'host'    => $this->errbitHost,
        ];

        if (is_array($this->errbit)) {
            $config = array_merge($config, $this->errbit);
        }

        if ($config['api_key'] === null) {
            throw new InvalidConfigException('Errbit API key is required.');
        }
        if ($config['host'] === null) {
            throw new InvalidConfigException('Errbit host is required.');
        }

        Errbit::instance()
            ->configure($config);

        parent::register();
    }

    protected function logException($exception)
    {
        Errbit::instance()->notify($exception);
        parent::logException($exception);
    }
}
