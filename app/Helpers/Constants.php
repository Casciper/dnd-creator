<?php

namespace App\Helpers;

class Constants
{
    public const DEFAULT_ITEMS_PER_PAGE = 10;
    public const ADMIN_GUARD = 'web';
    public const QUILL_TOOLS = ["text", "color", "header", "list", "format"];
    public const REGEX_ID = '[1-9]{1}[0-9]*';
    public const REGEX_CODE = '[a-z0-9\-_]+';
    public const REGEX_TIME_CODE = 'past|future';
    public const REGEX_PHONE = 'regex:~\+[0-9]{1}\s{1}\([0-9]{3}\)\s[0-9]{3}\-{1}[0-9]{2}\-{1}[0-9]{2}~';
    public const REGEX_CODE_RULE = 'regex:~^[A-z0-9\-]+$~';
    public const REGEX_TITLE = 'regex:~^[А-Яа-яЁёa-zA-Z\-0-9\s\'"№#%&*«»,.?!]+$~u';
}
