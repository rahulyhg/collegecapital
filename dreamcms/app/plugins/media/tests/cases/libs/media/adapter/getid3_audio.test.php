<?php
/**
 * Getid3Audio Media Adapter Test Case File
 *
 * Copyright (c) 2007-2010 David Persson
 *
 * Distributed under the terms of the MIT License.
 * Redistributions of files must retain the above copyright notice.
 *
 * PHP version 5
 * CakePHP version 1.3
 *
 * @package    media
 * @subpackage media.tests.cases.libs.media.adapter
 * @copyright  2007-2010 David Persson <davidpersson@gmx.de>
 * @license    http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link       http://github.com/davidpersson/media
 */
App::import('Lib','Media.AudioMedia', array('file' => 'media' . DS . 'audio.php'));
App::import('Lib','GetId3AudioMediaAdapter', array('file' => 'media' . DS . 'adapter' . DS . 'get_id3_audio.php'));
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DS . 'fixtures' . DS . 'test_data.php';

/**
 * Test Getid3 Audio Media Adapter Class
 *
 * @package    media
 * @subpackage media.tests.cases.libs.media.adapter
 */
class TestGetid3AudioMedia extends AudioMedia {
	var $adapters = array('Getid3Audio');
}

/**
 * Getid3 Audio Media Adapter Test Case Class
 *
 * @package    media
 * @subpackage media.tests.cases.libs.media.adapter
 */
class Getid3AudioMediaAdapterTest extends CakeTestCase {
	function setUp() {
		$this->TestData = new TestData();
	}

	function tearDown() {
		$this->TestData->flushFiles();
	}

	function skip() {
		$this->skipUnless(App::import(array(
			'type' => 'Vendor',
			'name'=> 'getID3',
			'file' => 'getid3/getid3.php'
			)), 'Getid3 not in vendor');
	}

	function testBasic() {
		$result = new TestGetid3AudioMedia($this->TestData->getFile('audio-mpeg.ID3v1.mp3'));
		$this->assertIsA($result, 'object');

		$Media = new TestGetid3AudioMedia($this->TestData->getFile('audio-mpeg.ID3v1.mp3'));
		$result = $Media->toString();
		$this->assertTrue(!empty($result));
	}

	function testInformationId3v1() {
		$Media = new TestGetid3AudioMedia($this->TestData->getFile('audio-mpeg.ID3v1.mp3'));

		$result = $Media->artist();
		$this->assertEqual($result, 'Artist');

		$result = $Media->title();
		$this->assertEqual($result, 'Title');

		$result = $Media->album();
		$this->assertEqual($result, 'Album');

		$result = $Media->year();
		$this->assertEqual($result, 2009);

		$result = $Media->track();
		$this->assertEqual($result, null);

		$result = $Media->duration();
		$this->assertEqual($result, 1);

		$result = $Media->bitRate();
		$this->assertEqual($result, 64000);

		$result = $Media->samplingRate();
		$this->assertEqual($result, 24000);

		$result = $Media->quality();
		$this->assertEqual($result, 1);
	}

	function testInformationId3v2() {
		$Media = new TestGetid3AudioMedia($this->TestData->getFile('audio-mpeg.ID3v2.mp3'));

		$result = $Media->artist();
		$this->assertEqual($result, 'Artist');

		$result = $Media->title();
		$this->assertEqual($result, 'Title');

		$result = $Media->album();
		$this->assertEqual($result, 'Album');

		$result = $Media->year();
		$this->assertEqual($result, 2009);

		$result = $Media->track();
		$this->assertEqual($result, 1);

		$result = $Media->duration();
		$this->assertEqual($result, 1);

		$result = $Media->bitRate();
		$this->assertEqual($result, 64000);

		$result = $Media->samplingRate();
		$this->assertEqual($result, 24000);

		$result = $Media->quality();
		$this->assertEqual($result, 1);
	}

	function testInformationNotag() {
		$Media = new TestGetid3AudioMedia($this->TestData->getFile('audio-mpeg.notag.mp3'));

		$result = $Media->artist();
		$this->assertEqual($result, null);

		$result = $Media->title();
		$this->assertEqual($result, null);

		$result = $Media->album();
		$this->assertEqual($result, null);

		$result = $Media->year();
		$this->assertEqual($result, null);

		$result = $Media->track();
		$this->assertEqual($result, null);

		$result = $Media->duration();
		$this->assertEqual($result, 1);

		$result = $Media->bitRate();
		$this->assertEqual($result, 64000);

		$result = $Media->samplingRate();
		$this->assertEqual($result, 24000);

		$result = $Media->quality();
		$this->assertEqual($result, 1);
	}

	function testInformationVorbisComment() {
		$Media = new TestGetid3AudioMedia($this->TestData->getFile('audio-vorbis.comments.ogg'));

		$result = $Media->artist();
		$this->assertEqual($result, 'Artist');

		$result = $Media->title();
		$this->assertEqual($result, 'Title');

		$result = $Media->album();
		$this->assertEqual($result, 'Album');

		$result = $Media->year();
		$this->assertEqual($result, 2009);

		$result = $Media->track();
		$this->assertEqual($result, 1);

		$result = $Media->duration();
		$this->assertEqual($result, 1);

		$result = $Media->bitRate();
		$this->assertEqual($result, 36666);

		$result = $Media->samplingRate();
		$this->assertEqual($result, 24000);

		$result = $Media->quality();
		$this->assertEqual($result, 1);
	}

	function testInformationVorbisNotag() {
		$Media = new TestGetid3AudioMedia($this->TestData->getFile('audio-vorbis.notag.ogg'));

		$result = $Media->artist();
		$this->assertEqual($result, null);

		$result = $Media->title();
		$this->assertEqual($result, null);

		$result = $Media->album();
		$this->assertEqual($result, null);

		$result = $Media->year();
		$this->assertEqual($result, null);

		$result = $Media->track();
		$this->assertEqual($result, null);

		$result = $Media->duration();
		$this->assertEqual($result, 1);

		$result = $Media->bitRate();
		$this->assertEqual($result, 36666);

		$result = $Media->samplingRate();
		$this->assertEqual($result, 24000);

		$result = $Media->quality();
		$this->assertEqual($result, 1);
	}

	function testConvertMp3() {
		$Media = new TestGetid3AudioMedia($this->TestData->getFile('audio-mpeg.ID3v2.mp3'));
		$Media->convert('image/jpeg');
		$result = $Media->mimeType;
		$this->assertTrue($result, 'image/jpeg');
	}

	function testConvertOgg() {
		$Media = new TestGetid3AudioMedia($this->TestData->getFile('audio-vorbis.comments.ogg'));
		$Media->convert('image/png');
		$result = $Media->mimeType;
		$this->assertTrue($result, 'image/png');
	}
}
?>