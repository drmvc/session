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
     * Session service status
     * @var boolean
     */
    private $_started = false;

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
     * @return  string
     */
    public function getPrefix(): string
    {
        return $this->_prefix;
    }

    /**
     * @param   string $prefix
     * @return  SessionInterface
     */
    public function setPrefix(string $prefix = null): SessionInterface
    {
        $this->_prefix = $prefix;
        return $this;
    }

    /**
     * @param   bool $instance
     * @return  SessionInterface
     */
    public function setStarted(bool $instance): SessionInterface
    {
        $this->_started = $instance;
        return $this;
    }

    /**
     * @return bool
     */
    public function isStarted(): bool
    {
        return $this->_started;
    }

    /**
     * if session has not started, start sessions
     *
     * @return  SessionInterface
     */
    public function init(): SessionInterface
    {
        if (!$this->isStarted()) {
            session_start();
            $this->setStarted(true);
        }
        return $this;
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
                $_SESSION[$this->getPrefix() . $key] = $val;
            }
        } else {
            $_SESSION[$this->getPrefix() . $name] = $value;
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
        $key = $this->getPrefix() . $name;

        if (isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $value;
        }

        return false;
    }

    /**
     * Get item from session
     *
     * @param   string $name item to look for in session
     * @param   boolean $secondKey if used then use as a second key
     * @return  mixed
     */
    public function get($name, $secondKey = false)
    {
        $key = $this->getPrefix() . $name;

        return (true === $secondKey)
            ? $_SESSION[$key][$secondKey]
            : $_SESSION[$key];
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
     * Empties and destroys the session.
     *
     * @param   string $name session name to destroy
     * @param   boolean $byPrefix if set to true clear all sessions for current SESSION_PREFIX
     * @return  SessionInterface
     */
    public function destroy($name = '', $byPrefix = false): SessionInterface
    {
        // only run if session has started
        if ($this->isStarted()) {
            // if key is empty and $prefix is false
            if ('' === $name && false === $byPrefix) {
                session_unset();
                session_destroy();
            } elseif (true === $byPrefix) {
                // clear all session for set SESSION_PREFIX
                foreach ($_SESSION as $key => $value) {
                    if (strpos($key, $this->getPrefix()) === 0) {
                        unset($_SESSION[$key]);
                    }
                }
            } else {
                // Clear specified session key
                unset($_SESSION[$this->getPrefix() . $name]);
            }
        }
        return $this;
    }

}
