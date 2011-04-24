<?php
/**
 * PHPIMS
 *
 * Copyright (c) 2011 Christer Edvartsen <cogo@starzinger.net>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * * The above copyright notice and this permission notice shall be included in
 *   all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *
 * @package PHPIMS
 * @subpackage Unittests
 * @author Christer Edvartsen <cogo@starzinger.net>
 * @copyright Copyright (c) 2011, Christer Edvartsen
 * @license http://www.opensource.org/licenses/mit-license MIT License
 * @link https://github.com/christeredvartsen/phpims
 */

namespace PHPIMS\Operation;

use \Mockery as m;

/**
 * @package PHPIMS
 * @subpackage Unittests
 * @author Christer Edvartsen <cogo@starzinger.net>
 * @copyright Copyright (c) 2011, Christer Edvartsen
 * @license http://www.opensource.org/licenses/mit-license MIT License
 * @link https://github.com/christeredvartsen/phpims
 */
class EditImageMetadataTest extends OperationTests {
    protected $imageIdentifier = null;

    protected function getNewOperation() {
        $this->imageIdentifier = md5(microtime()) . '.png';

        return new EditImageMetadata($this->imageIdentifier);
    }

    public function getExpectedOperationName() {
        return 'editImageMetadata';
    }

    public function getExpectedRequestPath() {
        return $this->imageIdentifier . '/meta';
    }

    public function testSuccessfullExec() {
        $metadata = array('foo' => 'bar', 'bar' => array('foo', 'bar'));
        $_POST['metadata'] = json_encode($metadata);

        $database = m::mock('PHPIMS\\Database\\DriverInterface');
        $database->shouldReceive('updateMetadata')->once()->with($this->imageIdentifier, $metadata);
        $this->operation->setDatabase($database);

        $this->operation->exec();
    }
}