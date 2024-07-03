<?php

/**
 * Experimental HTML5-based parser using Jeroen van der Meer's PH5P library.
 * Occupies space in the HTML5 pseudo-namespace, which may cause conflicts.
 *
 * @note
 *    Recent changes to PHP's DOM extension have resulted in some fatal
 *    error conditions with the original version of PH5P. Pending changes,
 *    this lexer will punt to DirectLex if DOM throws an exception.
 */

class HTMLPurifier_Lexer_PH5P extends HTMLPurifier_Lexer_DOMLex
{
    /**
     * @param string $html
     * @param HTMLPurifier_Config $config
     * @param HTMLPurifier_Context $context
     * @return HTMLPurifier_Token[]
     */
    public function tokenizeHTML($html, $config, $context)
    {
        $new_html = $this->normalize($html, $config, $context);
        $new_html = $this->wrapHTML($new_html, $config, $context, false /* no div */);
        try {
            $parser = new HTML5($new_html);
            $doc = $parser->save();
        } catch (DOMException $e) {
            // Uh oh, it failed. Punt to DirectLex.
            $lexer = new HTMLPurifier_Lexer_DirectLex();
            $context->register('PH5PError', $e); // save the error, so we can detect it
            return $lexer->tokenizeHTML($html, $config, $context); // use original HTML
        }
        $tokens = array();
        $this->tokenizeDOM(
            $doc->getElementsByTagName('html')->item(0)-> // <html>
                  getElementsByTagName('body')->item(0) //   <body>
            ,
            $tokens, $config
        );
        return $tokens;
    }
}

/*

Copyright 2007 Jeroen van der Meer <http://jero.net/>

Permission is hereby granted, free of charge, to any person obtaining a
copy of this software and associated documentation files (the
"Software"), to deal in the Software without restriction, including
without limitation the rights to use, copy, modify, merge, publish,
distribute, sublicense, and/or sell copies of the Software, and to
permit persons to whom the Software is furnished to do so, subject to
the following conditions:

The above copyright notice and this permission notice shall be included
in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/

class HTML5
{
    private $data;
    private $char;
    private $EOF;
    private $state;
    private $tree;
    private $token;
    private $content_model;
    private $escape = false;
    private $entities = array(
        'AElig;',
        'AElig',
        'AMP;',
        'AMP',
        'Aacute;',
        'Aacute',
        'Acirc;',
        'Acirc',
        'Agrave;',
        'Agrave',
        'Alpha;',
        'Aring;',
        'Aring',
        'Atilde;',
        'Atilde',
        'Auml;',
        'Auml',
        'Beta;',
        'COPY;',
        'COPY',
        'Ccedil;',
        'Ccedil',
        'Chi;',
        'Dagger;',
        'Delta;',
        'ETH;',
        'ETH',
        'Eacute;',
        'Eacute',
        'Ecirc;',
        'Ecirc',
        'Egrave;',
        'Egrave',
        'Epsilon;',
        'Eta;',
        'Euml;',
        'Euml',
        'GT;',
        'GT',
        'Gamma;',
        'Iacute;',
        'Iacute',
        'Icirc;',
        'Icirc',
        'Igrave;',
        'Igrave',
        'Iota;',
        'Iuml;',
        'Iuml',
        'Kappa;',
        'LT;',
        'LT',
        'Lambda;',
        'Mu;',
        'Ntilde;',
        'Ntilde',
        'Nu;',
        'OElig;',
        'Oacute;',
        'Oacute',
        'Ocirc;',
        'Ocirc',
        'Ograve;',
        'Ograve',
        'Omega;',
        'Omicron;',
        'Oslash;',
        'Oslash',
        'Otilde;',
        'Otilde',
        'Ouml;',
        'Ouml',
        'Phi;',
        'Pi;',
        'Prime;',
        'Psi;',
        'QUOT;',
        'QUOT',
        'REG;',
        'REG',
        'Rho;',
        'Scaron;',
        'Sigma;',
        'THORN;',
        'THORN',
        'TRADE;',
        'Tau;',
        'Theta;',
        'Uacute;',
        'Uacute',
        'Ucirc;',
        'Ucirc',
        'Ugrave;',
        'Ugrave',
        'Upsilon;',
        'Uuml;',
        'Uuml',
        'Xi;',
        'Yacute;',
        'Yacute',
        'Yuml;',
        'Zeta;',
        'aacute;',
        'aacute',
        'acirc;',
        'acirc',
        'acute;',
        'acute',
        'aelig;',
        'aelig',
        'agrave;',
        'agrave',
        'alefsym;',
        'alpha;',
        'amp;',
        'amp',
        'and;',
        'ang;',
        'apos;',
        'aring;',
        'aring',
        'asymp;',
        'atilde;',
        'atilde',
        'auml;',
        'auml',
        'bdquo;',
        'beta;',
        'brvbar;',
        'brvbar',
        'bull;',
        'cap;',
        'ccedil;',
        'ccedil',
        'cedil;',
        'cedil',
        'cent;',
        'cent',
        'chi;',
        'circ;',
        'clubs;',
        'cong;',
        'copy;',
        'copy',
        'crarr;',
        'cup;',
        'curren;',
        'curren',
        'dArr;',
        'dagger;',
        'darr;',
        'deg;',
        'deg',
        'delta;',
        'diams;',
        'divide;',
        'divide',
        'eacute;',
        'eacute',
        'ecirc;',
        'ecirc',
        'egrave;',
        'egrave',
        'empty;',
        'emsp;',
        'ensp;',
        'epsilon;',
        'equiv;',
        'eta;',
        'eth;',
        'eth',
        'euml;',
        'euml',
        'euro;',
        'exist;',
        'fnof;',
        'forall;',
        'frac12;',
        'frac12',
        'frac14;',
        'frac14',
        'frac34;',
        'frac34',
        'frasl;',
        'gamma;',
        'ge;',
        'gt;',
        'gt',
        'hArr;',
        'harr;',
        'hearts;',
        'hellip;',
        'iacute;',
        'iacute',
        'icirc;',
        'icirc',
        'iexcl;',
        'iexcl',
        'igrave;',
        'igrave',
        'image;',
        'infin;',
        'int;',
        'iota;',
        'iquest;',
        'iquest',
        'isin;',
        'iuml;',
        'iuml',
        'kappa;',
        'lArr;',
        'lambda;',
        'lang;',
        'laquo;',
        'laquo',
        'larr;',
        'lceil;',
        'ldquo;',
        'le;',
        'lfloor;',
        'lowast;',
        'loz;',
        'lrm;',
        'lsaquo;',
        'lsquo;',
        'lt;',
        'lt',
        'macr;',
        'macr',
        'mdash;',
        'micro;',
        'micro',
        'middot;',
        'middot',
        'minus;',
        'mu;',
        'nabla;',
        'nbsp;',
        'nbsp',
        'ndash;',
        'ne;',
        'ni;',
        'not;',
        'not',
        'notin;',
        'nsub;',
        'ntilde;',
        'ntilde',
        'nu;',
        'oacute;',
        'oacute',
        'ocirc;',
        'ocirc',
        'oelig;',
        'ograve;',
        'ograve',
        'oline;',
        'omega;',
        'omicron;',
        'oplus;',
        'or;',
        'ordf;',
        'ordf',
        'ordm;',
        'ordm',
        'oslash;',
        'oslash',
        'otilde;',
        'otilde',
        'otimes;',
        'ouml;',
        'ouml',
        'para;',
        'para',
        'part;',
        'permil;',
        'perp;',
        'phi;',
        'pi;',
        'piv;',
        'plusmn;',
        'plusmn',
        'pound;',
        'pound',
        'prime;',
        'prod;',
        'prop;',
        'psi;',
        'quot;',
        'quot',
        'rArr;',
        'radic;',
        'rang;',
        'raquo;',
        'raquo',
        'rarr;',
        'rceil;',
        'rdquo;',
        'real;',
        'reg;',
        'reg',
        'rfloor;',
        'rho;',
        'rlm;',
        'rsaquo;',
        'rsquo;',
        'sbquo;',
        'scaron;',
        'sdot;',
        'sect;',
        'sect',
        'shy;',
        'shy',
        'sigma;',
        'sigmaf;',
        'sim;',
        'spades;',
        'sub;',
        'sube;',
        'sum;',
        'sup1;',
        'sup1',
        'sup2;',
        'sup2',
        'sup3;',
        'sup3',
        'sup;',
        'supe;',
        'szlig;',
        'szlig',
        'tau;',
        'there4;',
        'theta;',
        'thetasym;',
        'thinsp;',
        'thorn;',
        'thorn',
        'tilde;',
        'times;',
        'times',
        'trade;',
        'uArr;',
        'uacute;',
        'uacute',
        'uarr;',
        'ucirc;',
        'ucirc',
        'ugrave;',
        'ugrave',
        'uml;',
        'uml',
        'upsih;',
        'upsilon;',
        'uuml;',
        'uuml',
        'weierp;',
        'xi;',
        'yacute;',
        'yacute',
        'yen;',
        'yen',
        'yuml;',
        'yuml',
        'zeta;',
        'zwj;',
        'zwnj;'
    );

    const PCDATA = 0;
    const RCDATA = 1;
    const CDATA = 2;
    const PLAINTEXT = 3;

    const DOCTYPE = 0;
    const STARTTAG = 1;
    const ENDTAG = 2;
    const COMMENT = 3;
    const CHARACTR = 4;
    const EOF = 5;

    public function __construct($data)
    {
        $this->data = $data;
        $this->char = -1;
        $this->EOF = strlen($data);
        $this->tree = new HTML5TreeConstructer;
        $this->content_model = self::PCDATA;

        $this->state = 'data';

        while ($this->state !== null) {
            $this->{$this->state . 'State'}();
        }
    }

    public function save()
    {
        return $this->tree->save();
    }

    private function char()
    {
        return ($this->char < $this->EOF)
            ? $this->data[$this->char]
            : false;
    }

    private function character($s, $l = 0)
    {
        if ($s + $l < $this->EOF) {
            if ($l === 0) {
                return $this->data[$s];
            } else {
                return substr($this->data, $s, $l);
            }
        }
    }

    private function characters($char_class, $start)
    {
        return preg_replace('#^([' . $char_class . ']+).*#s', '\\1', substr($this->data, $start));
    }

    private function dataState()
    {
        // Consume the next input character
        $this->char++;
        $char = $this->char();

        if ($char === '&' && ($this->content_model === self::PCDATA || $this->content_model === self::RCDATA)) {
            /* U+0026 AMPERSAND (&)
            When the content model flag is set to one of the PCDATA or RCDATA
            states: switch to the entity data state. Otherwise: treat it as per
            the "anything else"    entry below. */
            $this->state = 'entityData';

        } elseif ($char === '-') {
            /* If the content model flag is set to either the RCDATA state or
            the CDATA state, and the escape flag is false, and there are at
            least three characters before this one in the input stream, and the
            last four characters in the input stream, including this one, are
            U+003C LESS-THAN SIGN, U+0021 EXCLAMATION MARK, U+002D HYPHEN-MINUS,
            and U+002D HYPHEN-MINUS ("<!--"), then set the escape flag to true. */
            if (($this->content_model === self::RCDATA || $this->content_model ===
                    self::CDATA) && $this->escape === false &&
                $this->char >= 3 && $this->character($this->char - 4, 4) === '<!--'
            ) {
                $this->escape = true;
            }

            /* In any case, emit the input character as a character token. Stay
            in the data state. */
            $this->emitToken(
                array(
                    'type' => self::CHARACTR,
                    'data' => $char
                )
            );

            /* U+003C LESS-THAN SIGN (<) */
        } elseif ($char === '<' && ($this->content_model === self::PCDATA ||
                (($this->content_model === self::RCDATA ||
                        $this->content_model === self::CDATA) && $this->escape === false))
        ) {
            /* When the content model flag is set to the PCDATA state: switch
            to the tag open state.

            When the content model flag is set to either the RCDATA state or
            the CDATA state and the escape flag is false: switch to the tag
            open state.

            Otherwise: treat it as per the "anything else" entry below. */
            $this->state = 'tagOpen';

            /* U+003E GREATER-THAN SIGN (>) */
        } elseif ($char === '>') {
            /* If the content model flag is set to either the RCDATA state or
            the CDATA state, and the escape flag is true, and the last three
            characters in the input stream including this one are U+002D
            HYPHEN-MINUS, U+002D HYPHEN-MINUS, U+003E GREATER-THAN SIGN ("-->"),
            set the escape flag to false. */
            if (($this->content_model === self::RCDATA ||
                    $this->content_model === self::CDATA) && $this->escape === true &&
                $this->character($this->char, 3) === '-->'
            ) {
                $this->escape = false;
            }

            /* In any case, emit the input character as a character token.
            Stay in the data state. */
            $this->emitToken(
                array(
                    'type' => self::CHARACTR,
                    'data' => $char
                )
            );

        } elseif ($this->char === $this->EOF) {
            /* EOF
            Emit an end-of-file token. */
            $this->EOF();

        } elseif ($this->content_model === self::PLAINTEXT) {
            /* When the content model flag is set to the PLAINTEXT state
            THIS DIFFERS GREATLY FROM THE SPEC: Get the remaining characters of
            the text and emit it as a character token. */
            $this->emitToken(
                array(
                    'type' => self::CHARACTR,
                    'data' => substr($this->data, $this->char)
                )
            );

            $this->EOF();

        } else {
            /* Anything else
            THIS DIFFERS GREATLY FROM THE SPEC: Get as many character that
            otherwise would also be treated as a character token and emit it
            as a single character token. Stay in the data state. */
            $len = strcspn($this->data, '<&', $this->char);
            $char = substr($this->data, $this->char, $len);
            $this->char += $len - 1;

            $this->emitToken(
                array(
                    'type' => self::CHARACTR,
                    'data' => $char
                )
            );

            $this->state = 'data';
        }
    }

    private function entityDataState()
    {
        // Attempt to consume an entity.
        $entity = $this->entity();

        // If nothing is returned, emit a U+0026 AMPERSAND character token.
        // Otherwise, emit the character token that was returned.
        $char = (!$entity) ? '&' : $entity;
        $this->emitToken(
            array(
                'type' => self::CHARACTR,
                'data' => $char
            )
        );

        // Finally, switch to the data state.
        $this->state = 'data';
    }

    private function tagOpenState()
    {
        switch ($this->content_model) {
            case self::RCDATA:
            case self::CDATA:
                /* If the next input character is a U+002F SOLIDUS (/) character,
                consume it and switch to the close tag open state. If the next
                input character is not a U+002F SOLIDUS (/) character, emit a
                U+003C LESS-THAN SIGN character token and switch to the data
                state to process the next input character. */
                if ($this->character($this->char + 1) === '/') {
                    $this->char++;
                    $this->state = 'closeTagOpen';

                } else {
                    $this->emitToken(
                        array(
                            'type' => self::CHARACTR,
                            'data' => '<'
                        )
                    );

                    $this->state = 'data';
                }
                break;

            case self::PCDATA:
                // If the content model flag is set to the PCDATA state
                // Consume the next input character:
                $this->char++;
                $char = $this->char();

                if ($char === '!') {
                    /* U+0021 EXCLAMATION MARK (!)
                    Switch to the markup declaration open state. */
                    $this->state = 'markupDeclarationOpen';

                } elseif ($char === '/') {
                    /* U+002F SOLIDUS (/)
                    Switch to the close tag open state. */
                    $this->state = 'closeTagOpen';

                } elseif (preg_match('/^[A-Za-z]$/', $char)) {
                    /* U+0041 LATIN LETTER A through to U+005A LATIN LETTER Z
                    Create a new start tag token, set its tag name to the lowercase
                    version of the input character (add 0x0020 to the character's code
                    point), then switch to the tag name state. (Don't emit the token
                    yet; further details will be filled in before it is emitted.) */
                    $this->token = array(
                        'name' => strtolower($char),
                        'type' => self::STARTTAG,
                        'attr' => array()
                    );

                    $this->state = 'tagName';

                } elseif ($char === '>') {
                    /* U+003E GREATER-THAN SIGN (>)
                    Parse error. Emit a U+003C LESS-THAN SIGN character token and a
                    U+003E GREATER-THAN SIGN character token. Switch to the data state. */
                    $this->emitToken(
                        array(
                            'type' => self::CHARACTR,
                            'data' => '<>'
                        )
                    );

                    $this->state = 'data';

                } elseif ($char === '?') {
                    /* U+003F QUESTION MARK (?)
                    Parse error. Switch to the bogus comment state. */
                    $this->state = 'bogusComment';

                } else {
                    /* Anything else
                    Parse error. Emit a U+003C LESS-THAN SIGN character token and
                    reconsume the current input character in the data state. */
                    $this->emitToken(
                        array(
                            'type' => self::CHARACTR,
                            'data' => '<'
                        )
                    );

                    $this->char--;
                    $this->state = 'data';
                }
                break;
        }
    }

    private function closeTagOpenState()
    {
        $next_node = strtolower($this->characters('A-Za-z', $this->char + 1));
        $the_same = count($this->tree->stack) > 0 && $next_node === end($this->tree->stack)->nodeName;

        if (($this->content_model === self::RCDATA || $this->content_model === self::CDATA) &&
            (!$the_same || ($the_same && (!preg_match(
                            '/[\t\n\x0b\x0c >\/]/',
                            $this->character($this->char + 1 + strlen($next_node))
                        ) || $this->EOF === $this->char)))
        ) {
            /* If the content model flag is set to the RCDATA or CDATA states then
            examine the next few characters. If they do not match the tag name of
            the last start tag token emitted (case insensitively), or if they do but
            they are not immediately followed by one of the following characters:
                * U+0009 CHARACTER TABULATION
                * U+000A LINE FEED (LF)
                * U+000B LINE TABULATION
                * U+000C FORM FEED (FF)
                * U+0020 SPACE
                * U+003E GREATER-THAN SIGN (>)
                * U+002F SOLIDUS (/)
                * EOF
            ...then there is a parse error. Emit a U+003C LESS-THAN SIGN character
            token, a U+002F SOLIDUS character token, and switch to the data state
            to process the next input character. */
            $this->emitToken(
                array(
                    'type' => self::CHARACTR,
                    'data' => '</'
                )
            );

            $this->state = 'data';

        } else {
            /* Otherwise, if the content model flag is set to the PCDATA state,
            or if the next few characters do match that tag name, consume the
            next input character: */
            $this->char++;
            $char = $this->char();

            if (preg_match('/^[A-Za-z]$/', $char)) {
                /* U+0041 LATIN LETTER A through to U+005A LATIN LETTER Z
                Create a new end tag token, set its tag name to the lowercase version
                of the input character (add 0x0020 to the character's code point), then
                switch to the tag name state. (Don't emit the token yet; further details
                will be filled in before it is emitted.) */
                $this->token = array(
                    'name' => strtolower($char),
                    'type' => self::ENDTAG
                );

                $this->state = 'tagName';

            } elseif ($char === '>') {
                /* U+003E GREATER-THAN SIGN (>)
                Parse error. Switch to the data state. */
                $this->state = 'data';

            } elseif ($this->char === $this->EOF) {
                /* EOF
                Parse error. Emit a U+003C LESS-THAN SIGN character token and a U+002F
                SOLIDUS character token. Reconsume the EOF character in the data state. */
                $this->emitToken(
                    array(
                        'type' => self::CHARACTR,
                        'data' => '</'
                    )
                );

                $this->char--;
                $this->state = 'data';

            } else {
                /* Parse error. Switch to the bogus comment state. */
                $this->state = 'bogusComment';
            }
        }
    }

    private function tagNameState()
    {
        // Consume the next input character:
        $this->char++;
        $char = $this->character($this->char);

        if (preg_match('/^[\t\n\x0b\x0c ]$/', $char)) {
            /* U+0009 CHARACTER TABULATION
            U+000A LINE FEED (LF)
            U+000B LINE TABULATION
            U+000C FORM FEED (FF)
            U+0020 SPACE
            Switch to the before attribute name state. */
            $this->state = 'beforeAttributeName';

        } elseif ($char === '>') {
            /* U+003E GREATER-THAN SIGN (>)
            Emit the current tag token. Switch to the data state. */
            $this->emitToken($this->token);
            $this->state = 'data';

        } elseif ($this->char === $this->EOF) {
            /* EOF
            Parse error. Emit the current tag token. Reconsume the EOF
            character in the data state. */
            $this->emitToken($this->token);

            $this->char--;
            $this->state = 'data';

        } elseif ($char === '/') {
            /* U+002F SOLIDUS (/)
            Parse error unless this is a permitted slash. Switch to the before
            attribute name state. */
            $this->state = 'beforeAttributeName';

        } else {
            /* Anything else
            Append the current input character to the current tag token's tag name.
            Stay in the tag name state. */
            $this->token['name'] .= strtolower($char);
            $this->state = 'tagName';
        }
    }

    private function beforeAttributeNameState()
    {
        // Consume the next input character:
        $this->char++;
        $char = $this->character($this->char);

        if (preg_match('/^[\t\n\x0b\x0c ]$/', $char)) {
            /* U+0009 CHARACTER TABULATION
            U+000A LINE FEED (LF)
            U+000B LINE TABULATION
            U+000C FORM FEED (FF)
            U+0020 SPACE
            Stay in the before attribute name state. */
            $this->state = 'beforeAttributeName';

        } elseif ($char === '>') {
            /* U+003E GREATER-THAN SIGN (>)
            Emit the current tag token. Switch to the data state. */
            $this->emitToken($this->token);
            $this->state = 'data';

        } elseif ($char === '/') {
            /* U+002F SOLIDUS (/)
            Parse error unless this is a permitted slash. Stay in the before
            attribute name state. */
            $this->state = 'beforeAttributeName';

        } elseif ($this->char === $this->EOF) {
            /* EOF
            Parse error. Emit the current tag token. Reconsume the EOF
            character in the data state. */
            $this->emitToken($this->token);

            $this->char--;
            $this->state = 'data';

        } else {
            /* Anything else
            Start a new attribute in the current tag token. Set that attribute's
            name to the current input character, and its value to the empty string.
            Switch to the attribute name state. */
            $this->token['attr'][] = array(
                'name' => strtolower($char),
                'value' => null
            );

            $this->state = 'attributeName';
        }
    }

    private function attributeNameState()
    {
        // Consume the next input character:
        $this->char++;
        $char = $this->character($this->char);

        if (preg_match('/^[\t\n\x0b\x0c ]$/', $char)) {
            /* U+0009 CHARACTER TABULATION
            U+000A LINE FEED (LF)
            U+000B LINE TABULATION
            U+000C FORM FEED (FF)
            U+0020 SPACE
            Stay in the before attribute name state. */
            $this->state = 'afterAttributeName';

        } elseif ($char === '=') {
            /* U+003D EQUALS SIGN (=)
            Switch to the before attribute value state. */
            $this->state = 'beforeAttributeValue';

        } elseif ($char === '>') {
            /* U+003E GREATER-THAN SIGN (>)
            Emit the current tag token. Switch to the data state. */
            $this->emitToken($this->token);
            $this->state = 'data';

        } elseif ($char === '/' && $this->character($this->char + 1) !== '>') {
            /* U+002F SOLIDUS (/)
            Parse error unless this is a permitted slash. Switch to the before
            attribute name state. */
            $this->state = 'beforeAttributeName';

        } elseif ($this->char === $this->EOF) {
            /* EOF
            Parse error. Emit the current tag token. Reconsume the EOF
            character in the data state. */
            $this->emitToken($this->token);

            $this->char--;
            $this->state = 'data';

        } else {
            /* Anything else
            Append the current input character to the current attribute's name.
            Stay in the attribute name state. */
            $last = count($this->token['attr']) - 1;
            $this->token['attr'][$last]['name'] .= strtolower($char);

            $this->state = 'attributeName';
        }
    }

    private function afterAttributeNameState()
    {
        // Consume the next input character:
        $this->char++;
        $char = $this->character($this->char);

        if (preg_match('/^[\t\n\x0b\x0c ]$/', $char)) {
            /* U+0009 CHARACTER TABULATION
            U+000A LINE FEED (LF)
            U+000B LINE TABULATION
            U+000C FORM FEED (FF)
            U+0020 SPACE
            Stay in the after attribute name state. */
            $this->state = 'afterAttributeName';

        } elseif ($char === '=') {
            /* U+003D EQUALS SIGN (=)
            Switch to the before attribute value state. */
            $this->state = 'beforeAttributeValue';

        } elseif ($char === '>') {
            /* U+003E GREATER-THAN SIGN (>)
            Emit the current tag token. Switch to the data state. */
            $this->emitToken($this->token);
            $this->state = 'data';

        } elseif ($char === '/' && $this->character($this->char + 1) !== '>') {
            /* U+002F SOLIDUS (/)
            Parse error unless this is a permitted slash. Switch to the
            before attribute name state. */
            $this->state = 'beforeAttributeName';

        } elseif ($this->char === $this->EOF) {
            /* EOF
            Parse error. Emit the current tag token. Reconsume the EOF
            character in the data state. */
            $this->emitToken($this->token);

            $this->char--;
            $this->state = 'data';

        } else {
            /* Anything else
            Start a new attribute in the current tag token. Set that attribute's
            name to the current input character, and its value to the empty string.
            Switch to the attribute name state. */
            $this->token['attr'][] = array(
                'name' => strtolower($char),
                'value' => null
            );

            $this->state = 'attributeName';
        }
    }

    private function beforeAttributeValueState()
    {
        // Consume the next input character:
        $this->char++;
        $char = $this->character($this->char);

        if (preg_match('/^[\t\n\x0b\x0c ]$/', $char)) {
            /* U+0009 CHARACTER TABULATION
            U+000A LINE FEED (LF)
            U+000B LINE TABULATION
            U+000C FORM FEED (FF)
            U+0020 SPACE
            Stay in the before attribute value state. */
            $this->state = 'beforeAttributeValue';

        } elseif ($char === '"') {
            /* U+0022 QUOTATION MARK (")
            Switch to the attribute value (double-quoted) state. */
            $this->state = 'attributeValueDoubleQuoted';

        } elseif ($char === '&') {
            /* U+0026 AMPERSAND (&)
            Switch to the attribute value (unquoted) state and reconsume
            this input character. */
            $this->char--;
            $this->state = 'attributeValueUnquoted';

        } elseif ($char === '\'') {
            /* U+0027 APOSTROPHE (')
            Switch to the attribute value (single-quoted) state. */
            $this->state = 'attributeValueSingleQuoted';

        } elseif ($char === '>') {
            /* U+003E GREATER-THAN SIGN (>)
            Emit the current tag token. Switch to the data state. */
            $this->emitToken($this->token);
            $this->state = 'data';

        } else {
            /* Anything else
            Append the current input character to the current attribute's value.
            Switch to the attribute value (unquoted) state. */
            $last = count($this->token['attr']) - 1;
            $this->token['attr'][$last]['value'] .= $char;

            $this->state = 'attributeValueUnquoted';
        }
    }

    private function attributeValueDoubleQuotedState()
    {
        // Consume the next input character:
        $this->char++;
        $char = $this->character($this->char);

        if ($char === '"') {
            /* U+0022 QUOTATION MARK (")
            Switch to the before attribute name state. */
            $this->state = 'beforeAttributeName';

        } elseif ($char === '&') {
            /* U+0026 AMPERSAND (&)
            Switch to the entity in attribute value state. */
            $this->entityInAttributeValueState('double');

        } elseif ($this->char === $this->EOF) {
            /* EOF
            Parse error. Emit the current tag token. Reconsume the character
            in the data state. */
            $this->emitToken($this->token);

            $this->char--;
            $this->state = 'data';

        } else {
            /* Anything else
            Append the current input character to the current attribute's value.
            Stay in the attribute value (double-quoted) state. */
            $last = count($this->token['attr']) - 1;
            $this->token['attr'][$last]['value'] .= $char;

            $this->state = 'attributeValueDoubleQuoted';
        }
    }

    private function attributeValueSingleQuotedState()
    {
        // Consume the next input character:
        $this->char++;
        $char = $this->character($this->char);

        if ($char === '\'') {
            /* U+0022 QUOTATION MARK (')
            Switch to the before attribute name state. */
            $this->state = 'beforeAttributeName';

        } elseif ($char === '&') {
            /* U+0026 AMPERSAND (&)
            Switch to the entity in attribute value state. */
            $this->entityInAttributeValueState('single');

        } elseif ($this->char === $this->EOF) {
            /* EOF
            Parse error. Emit the current tag token. Reconsume the character
            in the data state. */
            $this->emitToken($this->token);

            $this->char--;
            $this->state = 'data';

        } else {
            /* Anything else
            Append the current input character to the current attribute's value.
            Stay in the attribute value (single-quoted) state. */
            $last = count($this->token['attr']) - 1;
            $this->token['attr'][$last]['value'] .= $char;

            $this->state = 'attributeValueSingleQuoted';
        }
    }

    private function attributeValueUnquotedState()
    {
        // Consume the next input character:
        $this->char++;
        $char = $this->character($this->char);

        if (preg_match('/^[\t\n\x0b\x0c ]$/', $char)) {
            /* U+0009 CHARACTER TABULATION
            U+000A LINE FEED (LF)
            U+000B LINE TABULATION
            U+000C FORM FEED (FF)
            U+0020 SPACE
            Switch to the before attribute name state. */
            $this->state = 'beforeAttributeName';

        } elseif ($char === '&') {
            /* U+0026 AMPERSAND (&)
            Switch to the entity in attribute value state. */
            $this->entityInAttributeValueState();

        } elseif ($char === '>') {
            /* U+003E GREATER-THAN SIGN (>)
            Emit the current tag token. Switch to the data state. */
            $this->emitToken($this->token);
            $this->state = 'data';

        } else {
            /* Anything else
            Append the current input character to the current attribute's value.
            Stay in the attribute value (unquoted) state. */
            $last = count($this->token['attr']) - 1;
            $this->token['attr'][$last]['value'] .= $char;

            $this->state = 'attributeValueUnquoted';
        }
    }

    private function entityInAttributeValueState()
    {
        // Attempt to consume an entity.
        $entity = $this->entity();

        // If nothing is returned, append a U+0026 AMPERSAND character to the
        // current attribute's value. Otherwise, emit the character token that
        // was returned.
        $char = (!$entity)
            ? '&'
            : $entity;

        $last = count($this->token['attr']) - 1;
        $this->token['attr'][$last]['value'] .= $char;
    }

    private function bogusCommentState()
    {
        /* Consume every character up to the first U+003E GREATER-THAN SIGN
        character (>) or the end of the file (EOF), whichever comes first. Emit
        a comment token whose data is the concatenation of all the characters
        starting from and including the character that caused the state machine
        to switch into the bogus comment state, up to and including the last
        consumed character before the U+003E character, if any, or up to the
        end of the file otherwise. (If the comment was started by the end of
        the file (EOF), the token is empty.) */
        $data = $this->characters('^>', $this->char);
        $this->emitToken(
            array(
                'data' => $data,
                'type' => self::COMMENT
            )
        );

        $this->char += strlen($data);

        /* Switch to the data state. */
        $this->state = 'data';

        /* If the end of the file was reached, reconsume the EOF character. */
        if ($this->char === $this->EOF) {
            $this->char = $this->EOF - 1;
        }
    }

    private function markupDeclarationOpenState()
    {
        /* If the next two characters are both U+002D HYPHEN-MINUS (-)
        characters, consume those two characters, create a comment token whose
        data is the empty string, and switch to the comment state. */
        if ($this->character($this->char + 1, 2) === '--') {
            $this->char += 2;
            $this->state = 'comment';
            $this->token = array(
                'data' => null,
                'type' => self::COMMENT
            );

            /* Otherwise if the next seven chacacters are a case-insensitive match
            for the word "DOCTYPE", then consume those characters and switch to the
            DOCTYPE state. */
        } elseif (strtolower($this->character($this->char + 1, 7)) === 'doctype') {
            $this->char += 7;
            $this->state = 'doctype';

            /* Otherwise, is is a parse error. Switch to the bogus comment state.
            The next character that is consumed, if any, is the first character
            that will be in the comment. */
        } else {
            $this->char++;
            $this->state = 'bogusComment';
        }
    }

    private function commentState()
    {
        /* Consume the next input character: */
        $this->char++;
        $char = $this->char();

        /* U+002D HYPHEN-MINUS (-) */
        if ($char === '-') {
            /* Switch to the comment dash state  */
            $this->state = 'commentDash';

            /* EOF */
        } elseif ($this->char === $this->EOF) {
            /* Parse error. Emit the comment token. Reconsume the EOF character
            in the data state. */
            $this->emitToken($this->token);
            $this->char--;
            $this->state = 'data';

            /* Anything else */
        } else {
            /* Append the input character to the comment token's data. Stay in
            the comment state. */
            $this->token['data'] .= $char;
        }
    }

    private function commentDashState()
    {
        /* Consume the next input character: */
        $this->char++;
        $char = $this->char();

        /* U+002D HYPHEN-MINUS (-) */
        if ($char === '-') {
            /* Switch to the comment end state  */
            $this->state = 'commentEnd';

            /* EOF */
        } elseif ($this->char === $this->EOF) {
            /* Parse error. Emit the comment token. Reconsume the EOF character
            in the data state. */
            $this->emitToken($this->token);
            $this->char--;
            $this->state = 'data';

            /* Anything else */
        } else {
            /* Append a U+002D HYPHEN-MINUS (-) character and the input
            character to the comment token's data. Switch to the comment state. */
            $this->token['data'] .= '-' . $char;
            $this->state = 'comment';
        }
    }

    private function commentEndState()
    {
        /* Consume the next input character: */
        $this->char++;
        $char = $this->char();

        if ($char === '>') {
            $this->emitToken($this->token);
            $this->state = 'data';

        } elseif ($char === '-') {
            $this->token['data'] .= '-';

        } elseif ($this->char === $this->EOF) {
            $this->emitToken($this->token);
            $this->char--;
            $this->state = 'data';

        } else {
            $this->token['data'] .= '--' . $char;
            $this->state = 'comment';
        }
    }

    private function doctypeState()
    {
        /* Consume the next input character: */
        $this->char++;
        $char = $this->char();

        if (preg_match('/^[\t\n\x0b\x0c ]$/', $char)) {
            $this->state = 'beforeDoctypeName';

        } else {
            $this->char--;
            $this->state = 'beforeDoctypeName';
        }
    }

    private function beforeDoctypeNameState()
    {
        /* Consume the next input character: */
        $this->char++;
        $char = $this->char();

        if (preg_match('/^[\t\n\x0b\x0c ]$/', $char)) {
            // Stay in the before DOCTYPE name state.

        } elseif (preg_match('/^[a-z]$/', $char)) {
            $this->token = array(
                'name' => strtoupper($char),
                'type' => self::DOCTYPE,
                'error' => true
            );

            $this->state = 'doctypeName';

        } elseif ($char === '>') {
            $this->emitToken(
                array(
                    'name' => null,
                    'type' => self::DOCTYPE,
                    'error' => true
                )
            );

            $this->state = 'data';

        } elseif ($this->char === $this->EOF) {
            $this->emitToken(
                array(
                    'name' => null,
                    'type' => self::DOCTYPE,
                    'error' => true
                )
            );

            $this->char--;
            $this->state = 'data';

        } else {
            $this->token = array(
                'name' => $char,
                'type' => self::DOCTYPE,
                'error' => true
            );

            $this->state = 'doctypeName';
        }
    }

    private function doctypeNameState()
    {
        /* Consume the next input character: */
        $this->char++;
        $char = $this->char();

        if (preg_match('/^[\t\n\x0b\x0c ]$/', $char)) {
            $this->state = 'AfterDoctypeName';

        } elseif ($char === '>') {
            $this->emitToken($this->token);
            $this->state = 'data';

        } elseif (preg_match('/^[a-z]$/', $char)) {
            $this->token['name'] .= strtoupper($char);

        } elseif ($this->char === $this->EOF) {
            $this->emitToken($this->token);
            $this->char--;
            $this->state = 'data';

        } else {
            $this->token['name'] .= $char;
        }

        $this->token['error'] = ($this->token['name'] === 'HTML')
            ? false
            : true;
    }

    private function afterDoctypeNameState()
    {
        /* Consume the next input character: */
        $this->char++;
        $char = $this->char();

        if (preg_match('/^[\t\n\x0b\x0c ]$/', $char)) {
            // Stay in the DOCTYPE name state.

        } elseif ($char === '>') {
            $this->emitToken($this->token);
            $this->state = 'data';

        } elseif ($this->char === $this->EOF) {
            $this->emitToken($this->token);
            $this->char--;
            $this->state = 'data';

        } else {
            $this->token['error'] = true;
            $this->state = 'bogusDoctype';
        }
    }

    private function bogusDoctypeState()
    {
        /* Consume the next input character: */
        $this->char++;
        $char = $this->char();

        if ($char === '>') {
            $this->emitToken($this->token);
            $this->state = 'data';

        } elseif ($this->char === $this->EOF) {
            $this->emitToken($this->token);
            $this->char--;
            $this->state = 'data';

        } else {
            // Stay in the bogus DOCTYPE state.
        }
    }

    private function entity()
    {
        $start = $this->char;

        // This section defines how to consume an entity. This definition is
        // used when parsing entities in text and in attributes.

        // The behaviour depends on the identity of the next character (the
        // one immediately after the U+0026 AMPERSAND character):

        switch ($this->character($this->char + 1)) {
            // U+0023 NUMBER SIGN (#)
            case '#':

                // The behaviour further depends on the character after the
                // U+0023 NUMBER SIGN:
                switch ($this->character($this->char + 1)) {
                    // U+0078 LATIN SMALL LETTER X
                    // U+0058 LATIN CAPITAL LETTER X
                    case 'x':
                    case 'X':
                        // Follow the steps below, but using the range of
                        // characters U+0030 DIGIT ZERO through to U+0039 DIGIT
                        // NINE, U+0061 LATIN SMALL LETTER A through to U+0066
                        // LATIN SMALL LETTER F, and U+0041 LATIN CAPITAL LETTER
                        // A, through to U+0046 LATIN CAPITAL LETTER F (in other
                        // words, 0-9, A-F, a-f).
                        $char = 1;
                        $char_class = '0-9A-Fa-f';
                        break;

                    // Anything else
                    default:
                        // Follow the steps below, but using the range of
                        // characters U+0030 DIGIT ZERO through to U+0039 DIGIT
                        // NINE (i.e. just 0-9).
                        $char = 0;
                        $char_class = '0-9';
                        break;
                }

                // Consume as many characters as match the range of characters
                // given above.
                $this->char++;
                $e_name = $this->characters($char_class, $this->char + $char + 1);
                $entity = $this->character($start, $this->char);
                $cond = strlen($e_name) > 0;

                // The rest of the parsing happens below.
                break;

            // Anything else
            default:
                // Consume the maximum number of characters possible, with the
                // consumed characters case-sensitively matching one of the
                // identifiers in the first column of the entities table.

                $e_name = $this->characters('0-9A-Za-z;', $this->char + 1);
                $len = strlen($e_name);

                for ($c = 1; $c <= $len; $c++) {
                    $id = substr($e_name, 0, $c);
                    $this->char++;

                    if (in_array($id, $this->entities)) {
                        if ($e_name[$c - 1] !== ';') {
                            if ($c < $len && $e_name[$c] == ';') {
                                $this->char++; // consume extra semicolon
                            }
                        }
                        $entity = $id;
                        break;
                    }
                }

                $cond = isset($entity);
                // The rest of the parsing happens below.
                break;
        }

        if (!$cond) {
            // If no match can be made, then this is a parse error. No
            // characters are consumed, and nothing is returned.
            $this->char = $start;
            return false;
        }

        // Return a character token for the character corresponding to the
        // entity name (as given by the second column of the entities table).
        return html_entity_decode('&' . rtrim($entity, ';') . ';', ENT_QUOTES, 'UTF-8');
    }

    private function emitToken($token)
    {
        $emit = $this->tree->emitToken($token);

        if (is_int($emit)) {
            $this->content_model = $emit;

        } elseif ($token['type'] === self::ENDTAG) {
            $this->content_model = self::PCDATA;
        }
    }

    private function EOF()
    {
        $this->state = null;
        $this->tree->emitToken(
            array(
                'type' => self::EOF
            )
        );
    }
}

class HTML5TreeConstructer
{
    public $stack = array();

    private $phase;
    private $mode;
    private $dom;
    private $foster_parent = null;
    private $a_formatting = array();

    private $head_pointer = null;
    private $form_pointer = null;

    private $scoping = array('button', 'caption', 'html', 'marquee', 'object', 'table', 'td', 'th');
    private $formatting = array(
        'a',
        'b',
        'big',
        'em',
        'font',
        'i',
        'nobr',
        's',
        'small',
        'strike',
        'strong',
        'tt',
        'u'
    );
    private $special = array(
        'address',
        'area',
        'base',
        'basefont',
        'bgsound',
        'blockquote',
        'body',
        'br',
        'center',
        'col',
        'colgroup',
        'dd',
        'dir',
        'div',
        'dl',
        'dt',
        'embed',
        'fieldset',
        'form',
        'frame',
        'frameset',
        'h1',
        'h2',
        'h3',
        'h4',
        'h5',
        'h6',
        'head',
        'hr',
        'iframe',
        'image',
        'img',
        'input',
        'isindex',
        'li',
        'link',
        'listing',
        'menu',
        'meta',
        'noembed',
        'noframes',
        'noscript',
        'ol',
        'optgroup',
        'option',
        'p',
        'param',
        'plaintext',
        'pre',
        'script',
        'select',
        'spacer',
        'style',
        'tbody',
        'textarea',
        'tfoot',
        'thead',
        'title',
        'tr',
        'ul',
        'wbr'
    );

    // The different phases.
    const INIT_PHASE = 0;
    const ROOT_PHASE = 1;
    const MAIN_PHASE = 2;
    const END_PHASE = 3;

    // The different insertion modes for the main phase.
    const BEFOR_HEAD = 0;
    const IN_HEAD = 1;
    const AFTER_HEAD = 2;
    const IN_BODY = 3;
    const IN_TABLE = 4;
    const IN_CAPTION = 5;
    const IN_CGROUP = 6;
    const IN_TBODY = 7;
    const IN_ROW = 8;
    const IN_CELL = 9;
    const IN_SELECT = 10;
    const AFTER_BODY = 11;
    const IN_FRAME = 12;
    const AFTR_FRAME = 13;

    // The different types of elements.
    const SPECIAL = 0;
    const SCOPING = 1;
    const FORMATTING = 2;
    const PHRASING = 3;

    const MARKER = 0;

    public function __construct()
    {
        $this->phase = self::INIT_PHASE;
        $this->mode = self::BEFOR_HEAD;
        $this->dom = new DOMDocument;

        $this->dom->encoding = 'UTF-8';
        $this->dom->preserveWhiteSpace = true;
        $this->dom->substituteEntities = true;
        $this->dom->strictErrorChecking = false;
    }

    // Process tag tokens
    public function emitToken($token)
    {
        switch ($this->phase) {
            case self::INIT_PHASE:
                return $this->initPhase($token);
                break;
            case self::ROOT_PHASE:
                return $this->rootElementPhase($token);
                break;
            case self::MAIN_PHASE:
                return $this->mainPhase($token);
                break;
            case self::END_PHASE :
                return $this->trailingEndPhase($token);
                break;
        }
    }

    private function initPhase($token)
    {
        /* Initially, the tree construction stage must handle each token
        emitted from the tokenisation stage as follows: */

        /* A DOCTYPE token that is marked as being in error
        A comment token
        A start tag token
        An end tag token
        A character token that is not one of one of U+0009 CHARACTER TABULATION,
            U+000A LINE FEED (LF), U+000B LINE TABULATION, U+000C FORM FEED (FF),
            or U+0020 SPACE
        An end-of-file token */
        if ((isset($token['error']) && $token['error']) ||
            $token['type'] === HTML5::COMMENT ||
            $token['type'] === HTML5::STARTTAG ||
            $token['type'] === HTML5::ENDTAG ||
            $token['type'] === HTML5::EOF ||
            ($token['type'] === HTML5::CHARACTR && isset($token['data']) &&
                !preg_match('/^[\t\n\x0b\x0c ]+$/', $token['data']))
        ) {
            /* This specification does not define how to handle this case. In
            particular, user agents may ignore the entirety of this specification
            altogether for such documents, and instead invoke special parse modes
            with a greater emphasis on backwards compatibility. */

            $this->phase = self::ROOT_PHASE;
            return $this->rootElementPhase($token);

            /* A DOCTYPE token marked as being correct */
        } elseif (isset($token['error']) && !$token['error']) {
            /* Append a DocumentType node to the Document  node, with the name
            attribute set to the name given in the DOCTYPE token (which will be
            "HTML"), and the other attributes specific to DocumentType objects
            set to null, empty lists, or the empty string as appropriate. */
            $doctype = new DOMDocumentType(null, null, 'HTML');

            /* Then, switch to the root element phase of the tree construction
            stage. */
            $this->phase = self::ROOT_PHASE;

            /* A character token that is one of one of U+0009 CHARACTER TABULATION,
            U+000A LINE FEED (LF), U+000B LINE TABULATION, U+000C FORM FEED (FF),
            or U+0020 SPACE */
        } elseif (isset($token['data']) && preg_match(
                '/^[\t\n\x0b\x0c ]+$/',
                $token['data']
            )
        ) {
            /* Append that character  to the Document node. */
            $text = $this->dom->createTextNode($token['data']);
            $this->dom->appendChild($text);
        }
    }

    private function rootElementPhase($token)
    {
        /* After the initial phase, as each token is emitted from the tokenisation
        stage, it must be processed as described in this section. */

        /* A DOCTYPE token */
        if ($token['type'] === HTML5::DOCTYPE) {
            // Parse error. Ignore the token.

            /* A comment token */
        } elseif ($token['type'] === HTML5::COMMENT) {
            /* Append a Comment node to the Document object with the data
            attribute set to the data given in the comment token. */
            $comment = $this->dom->createComment($token['data']);
            $this->dom->appendChild($comment);

            /* A character token that is one of one of U+0009 CHARACTER TABULATION,
            U+000A LINE FEED (LF), U+000B LINE TABULATION, U+000C FORM FEED (FF),
            or U+0020 SPACE */
        } elseif ($token['type'] === HTML5::CHARACTR &&
            preg_match('/^[\t\n\x0b\x0c ]+$/', $token['data'])
        ) {
            /* Append that character  to the Document node. */
            $text = $this->dom->createTextNode($token['data']);
            $this->dom->appendChild($text);

            /* A character token that is not one of U+0009 CHARACTER TABULATION,
                U+000A LINE FEED (LF), U+000B LINE TABULATION, U+000C FORM FEED
                (FF), or U+0020 SPACE
            A start tag token
            An end tag token
            An end-of-file token */
        } elseif (($token['type'] === HTML5::CHARACTR &&
                !preg_match('/^[\t\n\x0b\x0c ]+$/', $token['data'])) ||
            $token['type'] === HTML5::STARTTAG ||
            $token['type'] === HTML5::ENDTAG ||
            $token['type'] === HTML5::EOF
        ) {
            /* Create an HTMLElement node with the tag name html, in the HTML
            namespace. Append it to the Document object. Switch to the main
            phase and reprocess the current token. */
            $html = $this->dom->createElement('html');
            $this->dom->appendChild($html);
            $this->stack[] = $html;

            $this->phase = self::MAIN_PHASE;
            return $this->mainPhase($token);
        }
    }

    private function mainPhase($token)
    {
        /* Tokens in the main phase must be handled as follows: */

        /* A DOCTYPE token */
        if ($token['type'] === HTML5::DOCTYPE) {
            // Parse error. Ignore the token.

            /* A start tag token with the tag name "html" */
        } elseif ($token['type'] === HTML5::STARTTAG && $token['name'] === 'html') {
            /* If this start tag token was not the first start tag token, then
            it is a parse error. */

            /* For each attribute on the token, check to see if the attribute
            is already present on the top element of the stack of open elements.
            If it is not, add the attribute and its corresponding value to that
            element. */
            foreach ($token['attr'] as $attr) {
                if (!$this->stack[0]->hasAttribute($attr['name'])) {
                    $this->stack[0]->setAttribute($attr['name'], $attr['value']);
                }
            }

            /* An end-of-file token */
        } elseif ($token['type'] === HTML5::EOF) {
            /* Generate implied end tags. */
            $this->generateImpliedEndTags();

            /* Anything else. */
        } else {
            /* Depends on the insertion mode: */
            switch ($this->mode) {
                case self::BEFOR_HEAD:
                    return $this->beforeHead($token);
                    break;
                case self::IN_HEAD:
                    return $this->inHead($token);
                    break;
                case self::AFTER_HEAD:
                    return $this->afterHead($token);
                    break;
                case self::IN_BODY:
                    return $this->inBody($token);
                    break;
                case self::IN_TABLE:
                    return $this->inTable($token);
                    break;
                case self::IN_CAPTION:
                    return $this->inCaption($token);
                    break;
                case self::IN_CGROUP:
                    return $this->inColumnGroup($token);
                    break;
                case self::IN_TBODY:
                    return $this->inTableBody($token);
                    break;
                case self::IN_ROW:
                    return $this->inRow($token);
                    break;
                case self::IN_CELL:
                    return $this->inCell($token);
                    break;
                case self::IN_SELECT:
                    return $this->inSelect($token);
                    break;
                case self::AFTER_BODY:
                    return $this->afterBody($token);
                    break;
                case self::IN_FRAME:
                    return $this->inFrameset($token);
                    break;
                case self::AFTR_FRAME:
                    return $this->afterFrameset($token);
                    break;
                case self::END_PHASE:
                    return $this->trailingEndPhase($token);
                    break;
            }
        }
    }

    private function beforeHead($token)
    {
        /* Handle the token as follows: */

        /* A character token that is one of one of U+0009 CHARACTER TABULATION,
        U+000A LINE FEED (LF), U+000B LINE TABULATION, U+000C FORM FEED (FF),
        or U+0020 SPACE */
        if ($token['type'] === HTML5::CHARACTR &&
            preg_match('/^[\t\n\x0b\x0c ]+$/', $token['data'])
        ) {
            /* Append the character to the current node. */
            $this->insertText($token['data']);

            /* A comment token */
        } elseif ($token['type'] === HTML5::COMMENT) {
            /* Append a Comment node to the current node with the data attribute
            set to the data given in the comment token. */
            $this->insertComment($token['data']);

            /* A start tag token with the tag name "head" */
        } elseif ($token['type'] === HTML5::STARTTAG && $token['name'] === 'head') {
            /* Create an element for the token, append the new element to the
            current node and push it onto the stack of open elements. */
            $element = $this->insertElement($token);

            /* Set the head element pointer to this new element node. */
            $this->head_pointer = $element;

            /* Change the insertion mode to "in head". */
            $this->mode = self::IN_HEAD;

            /* A start tag token whose tag name is one of: "base", "link", "meta",
            "script", "style", "title". Or an end tag with the tag name "html".
            Or a character token that is not one of U+0009 CHARACTER TABULATION,
            U+000A LINE FEED (LF), U+000B LINE TABULATION, U+000C FORM FEED (FF),
            or U+0020 SPACE. Or any other start tag token */
        } elseif ($token['type'] === HTML5::STARTTAG ||
            ($token['type'] === HTML5::ENDTAG && $token['name'] === 'html') ||
            ($token['type'] === HTML5::CHARACTR && !preg_match(
                    '/^[\t\n\x0b\x0c ]$/',
                    $token['data']
                ))
        ) {
            /* Act as if a start tag token with the tag name "head" and no
            attributes had been seen, then reprocess the current token. */
            $this->beforeHead(
                array(
                    'name' => 'head',
                    'type' => HTML5::STARTTAG,
                    'attr' => array()
                )
            );

            return $this->inHead($token);

            /* Any other end tag */
        } elseif ($token['type'] === HTML5::ENDTAG) {
            /* Parse error. Ignore the token. */
        }
    }

    private function inHead($token)
    {
        /* Handle the token as follows: */

        /* A character token that is one of one of U+0009 CHARACTER TABULATION,
        U+000A LINE FEED (LF), U+000B LINE TABULATION, U+000C FORM FEED (FF),
        or U+0020 SPACE.

        THIS DIFFERS FROM THE SPEC: If the current node is either a title, style
        or script element, append the character to the current node regardless
        of its content. */
        if (($token['type'] === HTML5::CHARACTR &&
                preg_match('/^[\t\n\x0b\x0c ]+$/', $token['data'])) || (
                $token['type'] === HTML5::CHARACTR && in_array(
                    end($this->stack)->nodeName,
                    array('title', 'style', 'script')
                ))
        ) {
            /* Append the character to the current node. */
            $this->insertText($token['data']);

            /* A comment token */
        } elseif ($token['type'] === HTML5::COMMENT) {
            /* Append a Comment node to the current node with the data attribute
            set to the data given in the comment token. */
            $this->insertComment($token['data']);

        } elseif ($token['type'] === HTML5::ENDTAG &&
            in_array($token['name'], array('title', 'style', 'script'))
        ) {
            array_pop($this->stack);
            return HTML5::PCDATA;

            /* A start tag with the tag name "title" */
        } elseif ($token['type'] === HTML5::STARTTAG && $token['name'] === 'title') {
            /* Create an element for the token and append the new element to the
            node pointed to by the head element pointer, or, if that is null
            (innerHTML case), to the current node. */
            if ($this->head_pointer !== null) {
                $element = $this->insertElement($token, false);
                $this->head_pointer->appendChild($element);

            } else {
                $element = $this->insertElement($token);
            }

            /* Switch the tokeniser's content model flag  to the RCDATA state. */
            return HTML5::RCDATA;

            /* A start tag with the tag name "style" */
        } elseif ($token['type'] === HTML5::STARTTAG && $token['name'] === 'style') {
            /* Create an element for the token and append the new element to the
            node pointed to by the head element pointer, or, if that is null
            (innerHTML case), to the current node. */
            if ($this->head_pointer !== null) {
                $element = $this->insertElement($token, false);
                $this->head_pointer->appendChild($element);

            } else {
                $this->insertElement($token);
            }

            /* Switch the tokeniser's content model flag  to the CDATA state. */
            return HTML5::CDATA;

            /* A start tag with the tag name "script" */
        } elseif ($token['type'] === HTML5::STARTTAG && $token['name'] === 'script') {
            /* Create an element for the token. */
            $element = $this->insertElement($token, false);
            $this->head_pointer->appendChild($element);

            /* Switch the tokeniser's content model flag  to the CDATA state. */
            return HTML5::CDATA;

            /* A start tag with the tag name "base", "link", or "meta" */
        } elseif ($token['type'] === HTML5::STARTTAG && in_array(
                $token['name'],
                array('base', 'link', 'meta')
            )
        ) {
            /* Create an element for the token and 