<?php

declare(strict_types=1);

namespace App\Validation;

class RegexValidations
{
    final public const REGEX_GENERIC_STRING = '^\S(?:.*\S)?$';

    final public const REGEX_LETTERS_ONLY = '^[a-zA-Z]';

    final public const REGEX_LETTER_AND_DIGITS = '^[a-zA-Z\d]';

    final public const REGEX_NUMERIC = '\d+';

    final public const REGEX_NUMERIC_ONLY = '^\d+$';

    // phpcs:ignore
    final public const REGEX_EMAIL = '^[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$';

    final public const REGEX_ZIPCODE = '^\d{4}[A-Z]{2}$';

    final public const REGEX_UUID = '^[a-fA-F\d]{8}(?:\-[a-fA-F\d]{4}){3}\-[a-fA-F\d]{12}$';

    // phpcs:ignore
    final public const REGEX_DATE = '^((\d\d[2468][048]|\d\d[13579][26]|\d\d0[48]|[02468][048]00|[13579][26]00)-02-29|\d{4}-((0[13578]|1[02])-(0[1-9]|[12]\d|3[01])|(0[469]|11)-(0[1-9]|[12]\d|30)|(02)-(0[1-9]|1\d|2[0-8])))$';

    // phpcs:ignore
    final public const REGEX_DATETIME = '^((\d\d[2468][048]|\d\d[13579][26]|\d\d0[48]|[02468][048]00|[13579][26]00)-02-29|\d{4}-((0[13578]|1[02])-(0[1-9]|[12]\d|3[01])|(0[469]|11)-(0[1-9]|[12]\d|30)|(02)-(0[1-9]|1\d|2[0-8])))T\d{2}:\d{2}:\d{2}.\d{3}Z$';

    final public const REGEX_IBAN = '^NL[0-9]{2}[A-z0-9]{4}[0-9]{10}$';

    // phpcs:ignore
    final public const REGEX_URL = '^https?(?:\:\/\/)?[\w-]+(?:\.[\w-]+)+(?:[\w.,@?^!=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])+$';

    // phpcs:ignore
    final public const REGEX_URI = '^\/([a-zA-Z0-9_\.~-]+)\/([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12})$';



    final public const GENERIC_STRING = '/' . self::REGEX_GENERIC_STRING . '/';

    final public const LETTERS_ONLY = '/' . self::REGEX_LETTERS_ONLY . '/';

    final public const LETTER_AND_DIGITS = '/' . self::REGEX_LETTER_AND_DIGITS . '/';

    final public const NUMERIC = '/' . self::REGEX_NUMERIC . '/';

    final public const NUMERIC_ONLY = '/' . self::REGEX_NUMERIC_ONLY . '/';

    final public const EMAIL = '/' . self::REGEX_EMAIL . '/';

    final public const ZIPCODE = '/' . self::REGEX_ZIPCODE . '/';

    final public const UUID = '/' . self::REGEX_UUID . '/';

    final public const DATE = '/' . self::REGEX_DATE . '/';

    final public const DATETIME = '/' . self::REGEX_DATETIME . '/';

    final public const IBAN = '/' . self::REGEX_IBAN . '/';

    final public const URL = '/' . self::REGEX_URL . '/';

    final public const URI = '/' . self::REGEX_URI . '/';
}
