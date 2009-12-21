<?php
/**
 * Tests for appimage.core.php
 * This test case is specific for PHPUnit and requires the phpunit PEAR package.
 * It allows you to easily debug the output of method calls and also validate that you config settings
 * are valid and working correctly.
 *
 * Command line: phpunit AppImageCoreTest appimage.core.phpunit.test.php
 */

require_once 'PHPUnit'.DIRECTORY_SEPARATOR.'Framework.php';
require_once '..'.DIRECTORY_SEPARATOR.'appimage.core.php';

class AppImageCoreTest extends PHPUnit_Framework_TestCase {
	var $AppImageCore;
	var $file = 'phpRDJST8';
	var $img_id = 'test';

	function setup() {
		$this->AppImageCore = new AppImageCore();
	}

	function testUploadAvatar() {
		$key = $this->AppImageCore->upload('avatar', $this->file, $this->img_id);
		print_r($key);
	}

	function testUploadPhoto() {
		$key = $this->AppImageCore->upload('photo', $this->file, $this->img_id);
		print_r($key);
	}

	function testGetUrlsAvatar() {
		$img_id = 'test';
		$urls = $this->AppImageCore->getUrls('avatar', $this->img_id);
		print_r($urls);
	}

	function testGetUrlsPhoto() {
		$urls = $this->AppImageCore->getUrls('photo', $this->img_id);
		print_r($urls);
	}

	function testCropPercentage() {
		$x1 = 0.1;
		$y1 = 0.2;
		$x2 = 0.5;
		$y2 = 0.8;
		$unit = "percentage";
		$response = $this->AppImageCore->crop('avatar', $this->img_id, $x1, $y1, $x2, $y2, $unit);
		print_r($response);
		$urls = $this->AppImageCore->getUrls('avatar', $this->img_id);
		$this->assertEquals(md5(file_get_contents($urls['image'])),"58bd13d32e8101645c293cdeff0a5ec1");
	}

	function testCropPixels() {
		$x1 = 20;
		$y1 = 80;
		$x2 = 260;
		$y2 = 300;
		$unit = "pixels";
		$response = $this->AppImageCore->crop('avatar', $this->img_id, $x1, $y1, $x2, $y2, $unit);
		print_r($response);
		$urls = $this->AppImageCore->getUrls('avatar', $this->img_id);
		$this->assertEquals(md5(file_get_contents($urls['image'])),"5353c2b9ad9e60cd9ecbe921dab2184f");
	}

	function testResizePercentage() {
		// note: keeps aspect ratio, using dimensions that produce smallest image.
		// using the image provided will result in 123 x 154px image.
		$width = 0.4;
		$height = 0.5;
		$unit = "percentage";
		$response = $this->AppImageCore->resize('avatar', $this->img_id, $width, $height, $unit);
		print_r($response);
		$urls = $this->AppImageCore->getUrls('avatar', $this->img_id);
		$this->assertEquals(md5(file_get_contents($urls['image'])),"7689c434fa853d0a9460c3a28cef0ebb");
	}

	function testResizePixels() {
		// note: keeps aspect ratio, using dimensions that produce smallest image.
		// using the image provided will result in 160 x 200px image.
		$width = 300;
		$height = 200;
		$unit = "pixels";
		$response = $this->AppImageCore->resize('avatar', $this->img_id, $width, $height, $unit);
		print_r($response);
		$urls = $this->AppImageCore->getUrls('avatar', $this->img_id);
		$this->assertEquals(md5(file_get_contents($urls['image'])),"ed7c7e03524889af6f94b9bfb811b4ae");
	}
}
?>