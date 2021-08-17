<?php 

/**
 * PHP Encrypter
 *
 * @author  Riku Särkinen <riku@adbar.io>
 * @link    https://github.com/adbario/php-encrypter
 * @license https://github.com/adbario/php-encrypter/blob/master/LICENSE.md (MIT License)
 */

class Encrypt {

    protected $key;

    protected $authKey;

    public function __construct() {
        $this->key = ENCRYPTION_KEY;
        $this->authKey = null;
    }

   /**
     * Encrypt the given value
     *
     * @param  mixed  $value     The value to encrypt
     * @param  bool   $serialize Serialize the value
     * @return string
     */
    public function encrypt($value, $serialize = true)
    {
        $iv = random_bytes(16);

        // Encrypt the given value
        $encrypted = openssl_encrypt(
            $serialize ? serialize($value) : $value,
            'AES-256-CBC', $this->key, 0, $iv
        );

        if ($encrypted !== false) {
            // Create a keyed hash for the encrypted value
            $hmac = $this->hash($iv . $encrypted);

            return base64_encode($iv . $hmac . $encrypted);
        }
    }

     /**
     * Encrypt the given string without serialization
     *
     * @param  string $value The string to encrypt
     * @return string
     */
    public function encryptString($value)
    {
        return $this->encrypt($value, false);
    }

    /**
     * Decrypt the given value
     *
     * @param  string $value       The value to decrypt
     * @param  bool   $unserialize Unserialize the value
     * @return mixed
     */
    public function decrypt($value, $unserialize = true) {
        $value = base64_decode($value);

        $iv         = mb_substr($value, 0, 16, '8bit');
        $hmac       = mb_substr($value, 16, 32, '8bit');
        $encrypted  = mb_substr($value, 48, null, '8bit');

        // Create a keyed hash for the decrypted value
        $hmacNew = $this->hash($iv . $encrypted);

        if ($this->hashEquals($hmac, $hmacNew)) {
            // Decrypt the given value
            $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $this->key, 0, $iv);

            if ($decrypted !== false) {
                return $unserialize ? unserialize($decrypted) : $decrypted;
            }
        }
    }

    /**
     * Decrypt the given string without unserialization
     *
     * @param  string $value The string to decrypt
     * @return string
     */
    public function decryptString($value) {
        return $this->decrypt($value, false);
    }

     /**
     * Create a keyed hash for the given value
     *
     * @param  string $value Value to hash
     * @return string
     */
    protected function hash($value) {
        return hash_hmac('sha256', $value, $this->authKey, true);
    }

    /**
     * Compare hashes
     *
     * @param  string $original Original hash
     * @param  string $new      New hash
     * @return bool
     */
    protected function hashEquals($original, $new) {
        // PHP version >= 5.6
        if (function_exists('hash_equals')) {
            return hash_equals($original, $new);
        }

        // PHP version < 5.6
        if (!is_string($original) || !is_string($new)) {
            return false;
        }

        if ($originalLength = mb_strlen($original) !== mb_strlen($new)) {
            return false;
        }

        $result = 0;

        for ($i = 0; $i < $originalLength; ++$i) {
            $result |= ord($original[$i]) ^ ord($new[$i]);
        }

        return $result === 0;
    }

}