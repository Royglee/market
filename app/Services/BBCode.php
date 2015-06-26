<?php
/**
 * Created by PhpStorm.
 * User: Marcell
 * Date: 2015.06.26.
 * Time: 0:55
 */

namespace App\Services;


use Golonka\BBCode\BBCodeParser;

class BBCode {

    protected $bbcode;

    function __construct(BBCodeParser $bbcode)
    {
        $this->bbcode = $bbcode;
        return $this;

    }

    public function parse($source, $caseInsensitive = false)
    {
        $this->setParser();
        return $this->bbcode->parse(htmlspecialchars($source), $caseInsensitive);
    }

    public function setParser()
    {
        $this->bbcode->parsers = [
            'bold' => [
                'pattern' => '/\[b\](.*?)\[\/b\]/s',
                'replace' => '<strong>$1</strong>',
            ],
            'italic' => [
                'pattern' => '/\[i\](.*?)\[\/i\]/s',
                'replace' => '<em>$1</em>',
            ],
            'underline' => [
                'pattern' => '/\[u\](.*?)\[\/u\]/s',
                'replace' => '<span style="text-decoration: underline">$1</span>',
            ],
            'size' => [
                'pattern' => '/\[size\=([0-9]*)\](.*?)\[\/size\]/s',
                'replace' => '<span style="font-size: $1% ">$2</span>',
            ],
            'color' => [
                'pattern' => '/\[color\=(#[A-f0-9]{6}|#[A-f0-9]{3})\](.*?)\[\/color\]/s',
                'replace' => '<font color="$1">$2</font>',
            ],
            'center' => [
                'pattern' => '/\[center\](.*?)\[\/center\]/s',
                'replace' => '<div style="text-align:center;">$1</div>',
            ],
            'quote' => [
                'pattern' => '/\[quote\](.*?)\[\/quote\]/s',
                'replace' => '<blockquote>$1</blockquote>',
            ],
            'namedquote' => [
                'pattern' => '/\[quote\=(.*?)\](.*)\[\/quote\]/s',
                'replace' => '<blockquote><small>$1</small>$2</blockquote>',
            ],
            'link' => [
                'pattern' => '/\[url\](.*?)\[\/url\]/s',
                'replace' => '<a href="$1">$1</a>',
            ],
            'namedlink' => [
                'pattern' => '/\[url\=(.*?)\](.*?)\[\/url\]/s',
                'replace' => '<a href="$1">$2</a>',
            ],
            'image' => [
                'pattern' => '/\[img\](.*?)\[\/img\]/s',
                'replace' => '<img src="$1">',
            ],
            'orderedlistnumerical' => [
                'pattern' => '/\[list=1\](.*?)\[\/list\]/s',
                'replace' => '<ol>$1</ol>',
            ],
            'orderedlistalpha' => [
                'pattern' => '/\[list=a\](.*?)\[\/list\]/s',
                'replace' => '<ol type="a">$1</ol>',
            ],
            'unorderedlist' => [
                'pattern' => '/\[list\](.*?)\[\/list\]/s',
                'replace' => '<ul>$1</ul>',
            ],
            'listitem' => [
                'pattern' => '/\[\*\](.*)/',
                'replace' => '<li>$1</li>',
            ],
            'code' => [
                'pattern' => '/\[code\](.*?)\[\/code\]/s',
                'replace' => '<code>$1</code>',
            ],
            'linebreak' => [
                'pattern' => '/\r/',
                'replace' => '<br />',
            ]
        ];
    }

}