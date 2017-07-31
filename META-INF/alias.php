<?php

return [
    \ZanPHP\Log\BaseLogger::class => "Zan\\Framework\\Sdk\\Log\\BaseLogger",
    \ZanPHP\Log\BlackholeLogger::class => "Zan\\Framework\\Sdk\\Log\\BlackholeLogger",
    \ZanPHP\Log\BufferLogger::class => "Zan\\Framework\\Sdk\\Log\\BufferLogger",
    \ZanPHP\Log\BufferWriter::class => "Zan\\Framework\\Sdk\\Log\\BufferWriter",
    \ZanPHP\Log\FileLogger::class => "Zan\\Framework\\Sdk\\Log\\FileLogger",
    \ZanPHP\Log\FileWriter::class => "Zan\\Framework\\Sdk\\Log\\FileWriter",
    \ZanPHP\Log\Log::class => "Zan\\Framework\\Sdk\\Log\\Log",
    \ZanPHP\Log\LogWriter::class => "Zan\\Framework\\Sdk\\Log\\LogWriter",
    \ZanPHP\Log\SkynetLogger::class => "Zan\\Framework\\Sdk\\Log\\SkynetLogger",
    \ZanPHP\Log\SystemLogger::class => "Zan\\Framework\\Sdk\\Log\\SystemLogger",
    \ZanPHP\Log\SystemWriter::class => "Zan\\Framework\\Sdk\\Log\\SystemWriter",
    \ZanPHP\Log\SystemWriterEx::class => "Zan\\Framework\\Sdk\\Log\\SystemWriterEx",
];