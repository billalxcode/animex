<?php
session_status() === PHP_SESSION_ACTIVE ?: session_start();

/**
 * Set session data for user login.
 *
 * @param array $userData Associative array containing user data to store in session.
 */
function setLoginSession($userData) {
    $_SESSION['user'] = $userData;
}

/**
 * Check if the user is logged in.
 *
 * @return bool True if the user is logged in, false otherwise.
 */
function isLoggedIn() {
    return isset($_SESSION['user']);
}

/**
 * Get the logged-in user data.
 *
 * @return array|null The user data if logged in, null otherwise.
 */
function getLoginSession() {
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

/**
 * Get specific data from the logged-in user's session.
 *
 * @param string $key The key for the specific data to retrieve.
 * @return mixed|null The value associated with the key if it exists, null otherwise.
 */
function getLoginData($key) {
    return isset($_SESSION['user'][$key]) ? $_SESSION['user'][$key] : null;
}

/**
 * Clear the login session (logout).
 */
function clearLoginSession() {
    unset($_SESSION['user']);
}