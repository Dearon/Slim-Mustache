<?php
/**
 * Slim Mustache - a Mustache view class for Slim
 *
 * @author      Remco Meeuwissen
 * @link        http://github.com/dearon/Slim-Mustache
 * @copyright   2014 Remco Meeuwissen
 * @version     0.1.0
 * @package     SlimMustache
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace Slim\Mustache;

/**
 * Mustache view
 *
 * The Mustache view is a custom View class that renders templates using the Mustache
 * template language (https://github.com/bobthecow/mustache.php).
 *
 * Two fields that you, the developer, will need to change are:
 * - parserDirectory
 * - parserOptions
 */
class Mustache extends \Slim\View
{
    /**
     * @var string The path to the Mustache code directory WITHOUT the trailing slash
     */
    public $parserDirectory = null;

    /**
     * @var array The options for the Mustache engine, see
     * https://github.com/bobthecow/mustache.php/wiki
     */
    public $parserOptions = array();

    /**
     * @var Mustache_Engine The Mustache engine for rendering templates.
     */
    private $parserInstance = null;

    /**
     * Render Mustache Template
     *
     * This method will output the rendered template content
     *
     * @param   string $template The path to the Mustache template, relative to the templates directory.
     * @param null $data
     * @return  void
     */
    public function render($template, $data = null)
    {
        $env = $this->getInstance();
        $parser = $env->loadTemplate($template);

        return $parser->render($this->all());
    }

    /**
     * Creates new Mustache_Engine if it doesn't already exist, and returns it.
     *
     * @return \Mustache_Engine
     */
    public function getInstance()
    {
        if (!$this->parserInstance) {
            /**
             * Check if Mustache_Autoloader class exists
             * otherwise include and register it.
             */
            if (!class_exists('\Mustache_Autoloader')) {
                require_once $this->parserDirectory . '/Autoloader.php';
                \Mustache_Autoloader::register();
            }

            $parserOptions = array(
                'loader' => new \Mustache_Loader_FilesystemLoader($this->getTemplatesDirectory()),
            );

            // Check if the partials directory exists, otherwise Mustache will throw a exception
            if (is_dir($this->getTemplatesDirectory().'/partials')) {
                $parserOptions['partials_loader'] = new \Mustache_Loader_FilesystemLoader($this->getTemplatesDirectory().'/partials');
            }

            $parserOptions = array_merge((array)$parserOptions, (array)$this->parserOptions);

            $this->parserInstance = new \Mustache_Engine($parserOptions);
        }

        return $this->parserInstance;
    }
}
