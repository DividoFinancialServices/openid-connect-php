<?php
declare(strict_types=1);

namespace OpenIdConnectClient;

/**
 * A wrapper around base64_decode which decodes Base64URL-encoded data,
 * which is not the same alphabet as base64.
 *
 * @param string $base64url
 *
 * @return string
 */
function base64url_decode(string $base64url) : string
{
    return base64_decode(b64url2b64($base64url));
}

/**
 * Per RFC4648, "base64 encoding with URL-safe and filename-safe
 * alphabet".  This just replaces characters 62 and 63.  None of the
 * reference implementations seem to restore the padding if necessary,
 * but we'll do it anyway.
 *
 * @param string $base64url
 *
 * @return string
 */
function b64url2b64(string $base64url) : string
{
    // "Shouldn't" be necessary, but why not
    $padding = strlen($base64url) % 4;

    if ($padding > 0) {
        $base64url .= str_repeat("=", 4 - $padding);
    }

    return strtr($base64url, '-_', '+/');
}
