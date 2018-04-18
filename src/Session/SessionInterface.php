<?php

namespace DrMVC\Session;

interface SessionInterface
{

    /**
     * @param   string $prefix
     * @return  SessionInterface
     */
    public function setPrefix(string $prefix): SessionInterface;

    /**
     * @return  string|null
     */
    public function getPrefix();

    /**
     * @return  bool
     */
    public function isStarted(): bool;

    /**
     * if session has not started, start sessions
     *
     * @return  string
     */
    public function init(): string;

    /**
     * Add value to a session.
     *
     * @param   array|string $name name the data to save
     * @param   string|bool $value the data to save
     * @return  SessionInterface
     */
    public function set($name, $value = false): SessionInterface;

    /**
     * Extract item from session then delete from the session,
     * finally return the item.
     *
     * @param  string $name item to extract
     * @return mixed
     */
    public function pull(string $name): string;

    /**
     * Get item from session
     *
     * @param  string $name item to look for in session
     * @return mixed
     */
    public function get(string $name);

    /**
     * Return session id
     *
     * @return  string with the session id.
     */
    public function id(): string;

    /**
     * Regenerate session_id and return new id
     *
     * @return  string
     */
    public function regenerate(): string;

    /**
     * Return the session array.
     *
     * @return  array of session indexes
     */
    public function display(): array;

    /**
     * Empties and destroys the session.
     *
     * @param   string $key - session name to destroy
     */
    public function destroy($key = null);

}
