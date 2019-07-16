<?php

class EmailConfig
{

    public $default = array(
        'transport' => 'Mail',
        'charset' => 'utf-8',
        'headerCharset' => 'utf-8',
    );
    public $mailhog = [
        'transport'     => 'Smtp',
        'host'          => 'mailhog',
        'port'          => 1025,
        'charset'       => 'utf-8',
        'headerCharset' => 'utf-8'
    ];

}
