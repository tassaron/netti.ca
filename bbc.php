<?php

	/**
     * A class to allow easy parsing of BBCode
     *
     * @author Michael Rushton <michael@squiloople.com>
     * @version 1.0
     * @copyright © 2010 Michael Rushton - http://squiloople.com
     *
     * Feel free to use and redistribute this code
     */

    namespace Parsers;

    final class BBCodeParser
    {

        /**
         * Array to contain regular expressions of BB tags
         *
         * @access private
         * @var array
         */

        private $_bbTags = array(

            '/\[b\]([\x20-\x7E]+?)\[\/b\]/i',
            '/\[i\]([\x20-\x7E]+?)\[\/i\]/i',
            '/\[u\]([\x20-\x7E]+?)\[\/u\]/i',
            '/\[s\]([\x20-\x7E]+?)\[\/s\]/i',
            '/\[sub\]([\x20-\x7E]+?)\[\/sub\]/i',
            '/\[sup\]([\x20-\x7E]+?)\[\/sup\]/i',
            '/\[img\]([\x20-\x7E]+?)\[\/img\]/i',
            '/\[url\]([\x20-\x7E]+?)\[\/url\]/i',
            '/\[email\]([\x20-\x7E]+?)\[\/email\]/i',
            '/\[quote\]([\x20-\x7E]+?)\[\/quote\]/i',
            '/\[color=([0-9a-f]{6})\]([\x20-\x7E]+?)\[\/color\]/i',
            '/\[size=([1-9]?[0-9])\]([\x20-\x7E]+?)\[\/size\]/i',
            '/\[font=([a-z\x20]+)\]([\x20-\x7E]+?)\[\/font\]/i',
            '/\[img=([\x20-\x7E]+?)\]([\x20-\x7E]+?)\[\/img\]/i',
            '/\[url=([\x20-\x5A\x5C\x5E-\x7E]+)\]([\x20-\x7E]+?)\[\/url\]/i',
            '/\[email=([\x20-\x5A\x5C\x5E-\x7E]+)\]([\x20-\x7E]+?)\[\/email\]/i',
            '/\[quote=([\x20-\x5A\x5C\x5E-\x7E]+)\]([\x20-\x7E]+?)\[\/quote\]/i',

        );

        /**
         * Array to contain HTML tag replacements
         *
         * @access private
         * @var array
         */

        private $_htmlTags = array(

            '<strong>$1</strong>',
            '<em>$1</em>',
            '<span style="text-decoration:underline">$1</span>',
            '<del>$1</del>',
            '<sub>$1</sub>',
            '<sup>$1</sup>',
            '<img src="$1" alt="" />',
            '<a href="$1">$1</a>',
            '<a href="mailto:$1">$1</a>',
            '<fieldset>$1</fieldset>',
            '<span style="color:#$1;background-color:transparent">$2</span>',
            '<span style="font-size:$1px">$2</span>',
            '<span style="font-family:\'$1\', sans-serif">$2</span>',
            '<img src="$2" alt="$1" />',
            '<a href="$1">$2</a>',
            '<a href="mailto:$1">$2</a>',
            '<fieldset><legend>$1</legend>$2</fieldset>',

        );

        /**
         * Create "[tag]Text[/tag] => <tag>Text</tag>" style BB tags
         *
         * @access public
         * @param string
         * @param string
         */

        public function createTag($bb, $html = false)
        {

            // If an HTML tag is not specified, emulate the BB tag

            $html = $html ?: $bb;

            // Create a new BB tag regular expression of the form: [tag]Text[/tag]

            $this->_bbTags[] = '/\[' . $bb . '\]([\x20-\x7E]+?)\[\/' . $bb . '\]/i';

            // Create a new HTML tag replacement of the form <tag>Text</tag>

            $this->_htmlTags[] = '<' . $html . '>$1</' . $html . '>';

        }

        /**
         * Create "[tag=option]Text[/tag] => <tag option="option">Text</tag>" style BB tags
         *
         * @access public
         * @param string
         * @param string
         */

        public function createParameterTag($bb, $html)
        {

            // Create a new BB tag regular expression of the form [tag=option][/tag]

            $this->_bbTags[] = '/\[' . $bb . '=([\x20-\x5A\x5C\x5E-\x7E]+)\]([\x20-\x7E]+?)\[\/' . $bb . '\]/i';

            // Create a new HTML tag replacement of the form <tag option="option">Text</tag>

            $this->_htmlTags[] = '<' . $html . '>$2</' . strtok($html, ' ') . '>';

        }

        /**
         * Create "[smile] => :)" style BB tags
         *
         * @access public
         * @param string
         * @param string
         */

        public function createSpecialTag($bb, $html)
        {

            // Create a new BB tag regular expression of the form [tag] (does not require usual brackets)

            $this->_bbTags[] = '/' . preg_quote($bb) . '/i';

            // Create a new replacement (does not need to be an HTML tag)

            $this->_htmlTags[] = $html;

        }

        /**
         * Return the parsed string
         *
         * @access public
         * @param string
         * @return string
         */

        public function parseString($string)
        {

            // Ensure that the loop runs at least once

            $count = 1;

                // Only replace tags if the string has not been fully parsed

                while ($count !== 0) {

                    // Replace BB tags with HTML tags; will repeat if successful

                    $string = preg_replace($this->_bbTags, $this->_htmlTags, $string, -1, $count);

                }

            // Return the parsed string

            return $string;

        }

    }
?>