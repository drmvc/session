<?php

namespace DrMVC\Session;

/**
 * Class Session
 * @package DrMVC\Session
 */
class Session implements SessionInterface
{
    /**
     * Session prefix name
     * @var string
     */
    private $_prefix;

    /**
     * Session constructor.
     *
     * @param   string|null $prefix
     */
    public function __construct(string $prefix = null)
    {
        $this->setPrefix($prefix);
    }

    /**
     * Generate prefix with key, or return only prefix
     *
     * @param   string|null $key
     * @return  string|null
     */
    public function getPrefix(string $key = null)
    {
        return (null !== $key) ? $this->_prefix . $key : $this->_prefix;
    }

    /**
     * @param   string|null $prefix
     * @return  SessionInterface
     */
    public function setPrefix(string $prefix = null): SessionInterface
    {
        $this->_prefix = $prefix;
        return $this;
    }

    /**
     * @return bool
     */
    public function isStarted(): bool
    {
        return (session_status() === PHP_SESSION_ACTIVE);
    }

    /**
     * if session has not started, start sessions
     *
     * @return  string
     */
    public function init(): string
    {
        if (!$this->isStarted()) {
            session_start();
        }
        return $this->id();
    }

    /**
     * Add value to a session.
     *
     * @param   array|string $name name the data to save
     * @param   string|bool $value the data to save
     * @return  SessionInterface
     */
    public function set($name, $value = false): SessionInterface
    {
        if (\is_array($name) && false === $value) {
            foreach ($name as $key => $val) {
                $_SESSION[$this->getPrefix($key)] = $val;
            }
        } else {
            $_SESSION[$this->getPrefix($name)] = $value;
        }

        return $this;
    }

    /**
     * Extract item from session then delete from the session,
     * finally return the item.
     *
     * @param   string $name item to extract
     * @return  mixed
     */
    public function pull(string $name): string
    {
        $name = $this->getPrefix($name);

        if (isset($_SESSION[$name])) {
            $value = $_SESSION[$name];
            unset($_SESSION[$name]);
            return $value;
        }
        return false;
    }

    /**
     * Get item from session
     *
     * @param   string $name item to look for in session
     * @return  mixed
     */
    public function get(string $name)
    {
        $key = $this->getPrefix() . $name;
        return $_SESSION[$key] ?? false;
    }

    /**
     * Return session id
     *
     * @return  string with the session id.
     */
    public function id(): string
    {
        return session_id();
    }

    /**
     * Regenerate session_id and return new id
     *
     * @return  string
     */
    public function regenerate(): string
    {
        session_regenerate_id(true);
        return $this->id();
    }

    /**
     * Return the session array.
     *
     * @return  array of session indexes
     */
    public function display(): array
    {
        return $_SESSION;
    }

    /**
     * Remove some single key, remove keys by prefix or destroy session
     *
     * @param   string $name session name to destroy
     * @return  SessionInterface
     */
    public function destroy($name = null): SessionInterface
    {
        $name = $this->getPrefix($name) ?? null;

        if (null === $name) {
            // Clean up if key name is not provided
            session_unset();
            session_destroy();
        } else {
            // Or just remove single key
            unset($_SESSION[$name]);
        }

        return $this;
    }

}
