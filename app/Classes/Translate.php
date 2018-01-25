<?php

namespace App\Classes;

use Stichoza\GoogleTranslate\TranslateClient;
use Stichoza\GoogleTranslate\Tokens\GoogleTokenGenerator;

class Translate extends TranslateClient
{
    /**
     * @var TranslateClient Because nobody cares about singletons
     */
    protected static $staticInstance;

    /**
     * @var \GuzzleHttp\Client HTTP Client
     */
    protected $httpClient;

    /**
     * @var string Source language - from where the string should be translated
     */
    protected $sourceLanguage;

    /**
     * @var string Target language - to which language string should be translated
     */
    protected $targetLanguage;

    /**
     * @var string|bool Last detected source language
     */
    protected static $lastDetectedSource;

    /**
     * @var string Google Translate URL base
     */
    protected $urlBase = 'https://translate.google.com/translate_a/single';

    /**
     * @var array Dynamic guzzleHTTP client options
     */
    protected $httpOptions = [];

    /**
     * @var array URL Parameters
     */
    protected $urlParams = [
        'client'   => 't',
        'hl'       => 'en',
        'dt'       => 't',
        'sl'       => null, // Source language
        'tl'       => null, // Target language
        'q'        => null, // String to translate
        'ie'       => 'UTF-8', // Input encoding
        'oe'       => 'UTF-8', // Output encoding
        'multires' => 1,
        'otf'      => 0,
        'pc'       => 1,
        'trs'      => 1,
        'ssel'     => 0,
        'tsel'     => 0,
        'kc'       => 1,
        'tk'       => null,
    ];

    /**
     * @var array Regex key-value patterns to replace on response data
     */
    protected $resultRegexes = [
        '/,+/'  => ',',
        '/\[,/' => '[',
    ];

    /**
     * @var TokenProviderInterface
     */
    protected $tokenProvider;

    /**
     * @var string Default token generator class name
     */
    protected $defaultTokenProvider = GoogleTokenGenerator::class;

    public function translate($word)
    {
        $context = \App\Classes\Context::getContext();
        if (!count($context->lang_db)) {
          $context->lang_db = $context->translation
          ->where('lang', $this->targetLanguage)
          ->get();
        }

        $lang = $context->lang_db
        ->where('word', $word)
        ->first();

        if (isset($lang->id) && $lang->id) {
          return $lang->text;
        }

        $text = parent::translate($word);
        $trans = $context->translation;
        $trans->lang = $this->targetLanguage;
        $trans->word = $word;
        $trans->text = $text;
        $trans->save();

        return $text;
    }
}
